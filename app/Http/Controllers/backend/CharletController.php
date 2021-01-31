<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Charlet;
use App\Tab;
use Storage;

class CharletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charlets = Charlet::orderBy('sort_index')->paginate(10);
        return view('backend.charlets.index', compact('charlets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tabs = Tab::all();
        return view('backend.charlets.create', compact('tabs'));
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
            'image' => 'required|image',
            'tab_id' => 'required',
            'sort_index' => 'required|numeric'
        ]);

        $charlet = Charlet::create([
            'tab_id'=> $request['tab_id'],
            'sort_index' => $request['sort_index'],
        ]);

        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/charlet_imgs/', $file, $filename);
                $charlet->image = $filename;
                $charlet->save();
        }

        return redirect()->route('charlets.index')->with('success','Successfully Create Charlet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $charlet = Charlet::find($id);
        return view('backend.charlets.show', compact('charlet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tabs = Tab::all();
        $charlet = Charlet::find($id);
        return view('backend.charlets.edit', compact('charlet','tabs'));
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
        $charlet = Charlet::find($id);
        $request->validate([
            'image' => 'image',
            'tab_id' => 'required',
            'sort_index' => 'required|numeric',
        ]);         

        $charlet->tab_id = $request['tab_id'];
        $charlet->sort_index = $request['sort_index'];

        if($request->file('image'))
        {
            Storage::delete('public/uploads/charlet_imgs/'.$charlet->image);
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/charlet_imgs/', $file, $filename);
            $charlet->image = $filename;
            $charlet->save();
        }

        $charlet->update();

        return redirect()->route('charlets.index')->with('success','Successfully Update Charlet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charlet = Charlet::find($id);
        Storage::delete('public/uploads/charlet_imgs/'.$charlet->image);
        $charlet->delete();

        return redirect()->route('charlets.index')->with('success','Successfully Delete Charlet');
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $charlets = Charlet::WhereHas('tab',function ($query) use ($search){
                            $query->where('name','like', '%'.$search.'%');
                        })
                        ->orderBy('id', 'asc')->paginate(20);
        $charlets->appends(['search'=> $request->search]);        

        return view('backend.charlets.index', compact('charlets'));
    }
}
