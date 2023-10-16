<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComponentRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $components = Component::get();
        
        return view('components.index', compact('components'));
    }


    /**
     * Display the specified resource.
     */
    public function create()
    {
        return view('components.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponentRequest $request)
    {
        try{
            DB::beginTransaction();
            $component = Component::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'price' => $request->input('price'),
                'measure' => $request->input('measure'),
            ]);

            $component->update(['sort_order' => $component->id]);

            DB::commit();
            return redirect()->route('component.index');
        }catch(Exception $e){
            DB::rollBack();
            Log::error('[ComponentController][store] error: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $component = Component::where('id', $id)->first();
        if(!$component){
            return abort(404);
        }
        return view('components.edit', compact('component'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreComponentRequest $request, string $id)
    {
        try{
            DB::beginTransaction();

            $compoent = Component::where('id', $id)->first();
            if(!$compoent){
                return abort(404);
            }
            $compoent->update([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'price' => $request->input('price'),
                'measure' => $request->input('measure')
            ]);
            DB::commit();
            return redirect()->route('component.index');
            
        }catch(Exception $e){
            DB::rollBack();
            Log::error('[ComponentController][update] error: ' . $e->getMessage());
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();

            $compoent = Component::where('id', $id)->first();
            if(!$compoent){
                return abort(404);
            }
            $compoent->delete();
            DB::commit();
            return redirect()->route('component.index');
            
        }catch(Exception $e){
            DB::rollBack();
            Log::error('[ComponentController][update] error: ' . $e->getMessage());
            return back();
        }
    }
}
