<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PhoneModel;
use App\PhoneBrand;
use Storage;


class PhoneModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phone_models = PhoneModel::paginate(10);
        return view('backend.phone_models.index', compact('phone_models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $phone_brands = PhoneBrand::all();
        return view('backend.phone_models.create', compact('phone_brands'));
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
            'frame' => 'required|image',
            'brand_id' => 'required',
        ]);

        $phone_model = PhoneModel::create([
            'name' => $request['name'],
            'phone_brand_id'=> $request['brand_id'],
            'position_x' => $request['position_x'],
            'position_y' => $request['position_y'],
        ]);

        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/phone_model_imgs/', $file, $filename);
                $phone_model->image = $filename;
                $phone_model->save();
        }

        if($request->file('frame'))
        {
                $frame_file = $request->file('frame');
                $framename = uniqid().'_'.$frame_file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/phone_model_frame_imgs/', $frame_file, $framename);
                $phone_model->frame = $framename;
                $phone_model->save();
        }

        return redirect()->route('phone_models.index')->with('success','Successfully Create Phone Model');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phone_model = PhoneModel::find($id);
        return view('backend.phone_models.show', compact('phone_model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phone_brands = PhoneBrand::all();
        $phone_model = PhoneModel::find($id);
        return view('backend.phone_models.edit', compact('phone_model','phone_brands'));
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
        $phone_model = PhoneModel::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_brand_id' => 'required',
        ]);         
        
        $phone_model->name = $request['name'];
        $phone_model->phone_brand_id = $request['phone_brand_id'];
        $phone_model->position_x = $request['position_x'];
        $phone_model->position_y = $request['position_y'];

        if($request->file('image'))
        {
            Storage::delete('public/uploads/phone_model_imgs/'.$phone_model->image);
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/phone_model_imgs/', $file, $filename);
            $phone_model->image = $filename;
            $phone_model->save();
        }

        if($request->file('frame'))
        {
                $frame_file = $request->file('frame');
                $framename = uniqid().'_'.$frame_file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/phone_model_frame_imgs/', $frame_file, $framename);
                $phone_model->frame = $framename;
                $phone_model->save();
        }

        $phone_model->update();

        return redirect()->route('phone_models.index')->with('success','Successfully Update Phone Model');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone_model = PhoneModel::find($id);
        Storage::delete('public/uploads/phone_model_imgs/'.$phone_model->image);
        $phone_model->delete();

        return redirect()->route('phone_models.index')->with('success','Successfully Delete Phone Model');
    
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $phone_models = PhoneModel::where('name', 'like','%'.$search.'%')
                        ->orWhereHas('phone_brand',function ($query) use ($search){
                            $query->where('name','like', '%'.$search.'%');
                        })
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.phone_models.index', compact('phone_models'));
    }
}
