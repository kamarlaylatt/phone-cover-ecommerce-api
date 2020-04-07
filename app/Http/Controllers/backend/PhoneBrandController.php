<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PhoneBrand;
use Storage;

class PhoneBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phone_brands = PhoneBrand::paginate(10);
        return view('backend.phone_brands.index', compact('phone_brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.phone_brands.create');
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
            'image' => 'required|image',
        ]);

        $phone_brand = PhoneBrand::create([
            'name' => $request['name'],
        ]);

        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/phone_brand_imgs/', $file, $filename);
                $phone_brand->image = $filename;
                $phone_brand->save();
        }

        return redirect()->route('phone_brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phone_brand = PhoneBrand::find($id);
        return view('backend.phone_brands.show', compact('phone_brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phone_brand = PhoneBrand::find($id);
        return view('backend.phone_brands.edit', compact('phone_brand'));
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
        $phone_brand = PhoneBrand::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);         
        
        $phone_brand->name = $request['name'];
        if($request->file('image'))
        {
            Storage::delete('public/uploads/phone_brand_imgs/'.$phone_brand->image); 
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/phone_brand_imgs/', $file, $filename);
            $phone_brand->image = $filename;
            $phone_brand->save();
        }

        $phone_brand->update();

        return redirect()->route('phone_brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone_brand = PhoneBrand::find($id);
        Storage::delete('public/uploads/phone_brand_imgs/'.$phone_brand->image);
        $phone_brand->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $phone_brands = PhoneBrand::where('name', 'like','%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.phone_brands.index', compact('phone_brands'));
    }
}
