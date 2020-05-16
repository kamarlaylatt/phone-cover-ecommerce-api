<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tab;
use Storage;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tabs = Tab::paginate(10);
        return view('backend.tabs.index', compact('tabs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tabs.create');
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
        ]);

        $tab = Tab::create([
            'name' => $request['name'],
        ]);

        return redirect()->route('tabs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tab = Tab::find($id);
        return view('backend.tabs.show', compact('tab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tab = Tab::find($id);
        return view('backend.tabs.edit', compact('tab'));
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
        $tab = Tab::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);         
        
        $tab->name = $request['name'];

        $tab->update();

        return redirect()->route('tabs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tab = Tab::find($id);
        $tab->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $tabs = Tab::where('name', 'like','%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.tabs.index', compact('tabs'));
    }
}
