<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PhoneModel;
use App\PhoneBrand;


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
            'image' => 'required',
            'brand_id' => 'required',
        ]);

        PhoneModel::create([
            'name' => $request['name'],
            'image' => $request['image'],
            'phone_brand_id'=> $request['brand_id'],
        ]);

        return redirect()->route('phone_models.index');
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
        $phone_model = PhoneModel::find($id);
        return view('backend.phone_models.edit', compact('phone_model'));
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
            'image' => 'required',
            'phone_brand_id' => 'required',
        ]);         
        
        $phone_model->name = $request['name'];
        $phone_model->image = $request['image'];
        $phone_model->phone_brand_id = $request['phone_brand_id'];

        $phone_model->update();

        return redirect()->route('phone_models.index');
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
        $phone_model->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $phone_models = PhoneModel::where('name', 'like','%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.phone_models.index', compact('phone_models'));
    }
}
