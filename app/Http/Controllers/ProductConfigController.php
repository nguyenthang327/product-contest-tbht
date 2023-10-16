<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductConfigRequest;
use App\Models\Product;
use App\Models\ProductConfig;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductConfigController extends Controller
{
    public function store(StoreProductConfigRequest $request){
        try{
            DB::beginTransaction();
            $productConfig = ProductConfig::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'product_id' => $request->input('product_id'),
                'type' => ProductConfig::TYPE_ADD,
            ]);

            if($request->input('specification_ids') && is_array($request->input('specification_ids'))){
                $specificationID = array_filter($request->input('specification_ids'), function ($value) {
                    return $value !== null;
                });
                $productConfig->specifications()->sync($specificationID);
            }

            $productConfig->update(['sort_order' => $productConfig->id]);

            DB::commit();

            return back();
        }catch(Exception $e){
            DB::rollback();
            Log::error('create product config err:' . $e->getMessage());
            return back();
        }
    }

    public function update(Request $request, $id){
        try{
            DB::beginTransaction();
            $productConfig = ProductConfig::where('product_configs.id', $id)->first();

            if (!$productConfig) {
                return null;
            }

            $params = [
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'price' => $request->input('price'),
            ];
            $productConfig->update($params);

            $specificationIDs = $request->input('specification_ids') ?? [];
            $specificationIDs =  array_filter($specificationIDs, function ($value) {
                return $value !== null;
            });
            $productConfig->specifications()->sync($specificationIDs);

            DB::commit();

            return back();
        }catch(Exception $e){
            DB::rollback();
            Log::error('update product config err:' . $e->getMessage());
            return back();
        }
    }

}
