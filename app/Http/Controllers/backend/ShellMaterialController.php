<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShellMaterial;

class ShellMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shell_materials = ShellMaterial::orderBy('sort_index')->paginate(10);
        return view('backend.shell_materials.index', compact('shell_materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.shell_materials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sort_index' => 'required|numeric',
        ]);

        ShellMaterial::create([
            'name' => $request['name'],
            'price' => $request['price'],
            'sort_index' => $request['sort_index'],
        ]);

        return redirect()->route('shell_materials.index')->with('success','Successfully Create Shell Material');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shell_material = ShellMaterial::find($id);
        return view('backend.shell_materials.show', compact('shell_material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shell_material = ShellMaterial::find($id);
        return view('backend.shell_materials.edit', compact('shell_material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shell_material = ShellMaterial::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sort_index' => 'required|numeric',
        ]);         
        
        $shell_material->name = $request['name'];
        $shell_material->price = $request['price'];
        $shell_material->sort_index = $request['sort_index'];

        $shell_material->update();

        return redirect()->route('shell_materials.index')->with('success','Successfully Update Shell Material');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shell_material = ShellMaterial::find($id);
        $shell_material->delete();

        return redirect()->route('shell_materials.index')->with('success','Successfully delete shell material');
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $shell_materials = ShellMaterial::where('name', 'like','%'.$search.'%')
                        ->orWhere('price', 'like', '%'.$search.'%')
                        ->orWhere('sort_index', 'like', '%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);

        return view('backend.shell_materials.index', compact('shell_materials'));
    }
}
