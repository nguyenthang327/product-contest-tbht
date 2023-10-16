<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\Specification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        // $products = Product::with(['children', 'parent'])
        //     ->get();
        $keyword = $request->input('keySearch');

        // only correct with 2 level
        $products = Product::select([
                'id',
                'name',
                DB::raw('CONCAT(
                    IF(sort_order is null ,"a", sort_order), ".", id
                ) as sort_order_1'),
                'code',
                'parent_id', // code của sản phẩm cha
                'type',
            ])
            ->with('productConfigs')
            // ->with(['children', 'parent'])
            ->whereNull('parent_id')
            ->where('name', 'like', '%' . $keyword . '%')
            ->when($request->input('type'), function($query) use($request) {
                $query->where('type', $request->input('type'));
            })
            ->unionAll(function ($query) use ($keyword, $request) {
                $query->select('c.id', 'c.name', DB::raw('
                    CONCAT(
                        IF(ph.sort_order is null ,"a", ph.sort_order), ".", ph.id, ".",
                        IF(c.sort_order is null ,"a", c.sort_order), ".", c.id) as sort_order_1'
                ), 'c.code', 'ph.code', 'c.type')
                    ->from('products as c')
                    ->join('products as ph', 'c.parent_id', '=', 'ph.id')
                    ->where('c.name', 'like', '%' . $keyword . '%')
                    ->when($request->input('type'), function($query) use($request) {
                        $query->where('c.type', $request->input('type'));
                    });
            })
            ->orderBy('sort_order_1')
            ->get();
        // dd($products->toArray());

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['productConfigs' => function ($query) {
                $query->with(['specifications' => function ($query2) {
                    $query2->with('components');
                }]);
            }])
            ->where('products.id', $id)
            ->first();

        if (!$product) {
            abort(404);
        }

        $specifications = Specification::get();
        $listSpecificationGroup = $specifications->groupBy('specification_group_id');
        // dd($productSpecificationGroup);
        return view('products.detail', compact('product', 'listSpecificationGroup'));
    }

    public function create()
    {
        $specifications = Specification::with('components')->get();
        $products = Product::whereNull('products.parent_id')->get();
        return view('products.create', compact('specifications', 'products'));
    }

    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {

            $params = [];
            $params['name'] = $request->input('name');
            $params['code'] = $request->input('code');
            $params['type'] = $request->input('type');

            if ($request->input('type') != 2) {
                $params['parent_id'] = null;
            } else {
                if (empty($request->input('parent_id'))) {
                    Log::error('Chưa chọn sản phẩm cha');
                    return back();
                }
                $params['parent_id'] = $request->input('parent_id');
            }

            $product = Product::create($params);

            // random product config code
            do{
                $productConfigCode = $product->code . '_' . strtoupper(Str::random(3));
                $checkCodeExists = ProductConfig::where('product_configs.code', $productConfigCode)->first();
            }while($checkCodeExists);

            // create product config default
            $productConfig = ProductConfig::create([
                'code' => $productConfigCode,
                'name' => 'Mặc định',
                'price' => $request->input('price'),
                'product_id' => $product->id,
                'type' => ProductConfig::TYPE_DEFAULT,
            ]);

            // $productConfig->update(['sort_order' => $productConfig->id]);
            // $product->update(['sort_order' => $product->id]);

            DB::commit();
            return redirect()->route('product.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('specification store err:' . $e->getMessage());
            return back();
        }
    }
}
