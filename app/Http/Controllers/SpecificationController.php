<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecificationRequest;
use App\Models\Component;
use App\Models\Specification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specifications = Specification::with('components')->get();
        return view('specifications.index', compact('specifications'));
    }


    /**
     * Display the specified resource.
     */
    public function create()
    {
        $components = Component::get();
        return view('specifications.create', compact('components'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecificationRequest $request)
    {
        DB::beginTransaction();
        try{
            $specification = Specification::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
                'specification_group_id' => $request->input('specification_group_id'),
            ]);

            $syncData = [];
            if($request->input('component')){
                foreach($request->input('component')['id'] as $key => $item){
                    if(!empty($item)){
                        $data = [];
                        $data['quantity'] = isset($request->input('component')['quantity'][$key]) ? $request->input('component')['quantity'][$key] : null;
                        $syncData[$item] = $data;
                    }
                }
                $specification->components()->sync($syncData);
            }

            $specification->update(['sort_order' => $specification->id]);

            DB::commit();
            return redirect()->route('specification.index');
        }catch(Exception $e){
            DB::rollBack();
            Log::error('specification store err:' . $e->getMessage());
            return back();
        }

    }

     /**
     * Display the specified resource.
     */
    public function getBySpecificationGroup(Request $request)
    {
        $specifications = Specification::where('specification_group_id', $request->input('specificationGroupId'))->get();
        return response()->json([
            'status' => 200,
            'data' => $specifications,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    public function edit($id){
        $specification = Specification::with(['components'])
            ->where('specifications.id', $id)
            ->first();

        if (!$specification) {
            abort(404);
        }

        return view('specifications.edit', compact('product', 'listSpecificationGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
