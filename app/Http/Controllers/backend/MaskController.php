<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mask;
use App\Tab;
use Storage;

class MaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masks = Mask::paginate(10);
        return view('backend.masks.index', compact('masks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tabs = Tab::all();
        return view('backend.masks.create', compact('tabs'));
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
            'image' => 'required',
            'tab_id' => 'required',
        ]);

        $mask = Mask::create([
            'tab_id'=> $request['tab_id'],
        ]);

        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/mask_imgs/', $file, $filename);
                $mask->image = $filename;
                $mask->save();
        }

        return redirect()->route('masks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mask = Mask::find($id);
        return view('backend.masks.show', compact('mask'));
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
        $mask = Mask::find($id);
        return view('backend.masks.edit', compact('mask','tabs'));
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
        $mask = Mask::find($id);
        $request->validate([
            'tab_id' => 'required',
        ]);         

        $mask->tab_id = $request['tab_id'];

        if($request->file('image'))
        {
            Storage::delete('public/uploads/mask_imgs/'.$mask->image);
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/mask_imgs/', $file, $filename);
            $mask->image = $filename;
            $mask->save();
        }

        $mask->update();

        return redirect()->route('masks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mask = Mask::find($id);
        Storage::delete('public/uploads/mask_imgs/'.$mask->image);
        $mask->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $masks = Mask::WhereHas('tab',function ($query) use ($search){
                            $query->where('name','like', '%'.$search.'%');
                        })
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.masks.index', compact('masks'));
    }
}
