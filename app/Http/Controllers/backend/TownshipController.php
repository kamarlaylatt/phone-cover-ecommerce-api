<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Township;
use App\TownshipInfo;
use App\Region;

class TownshipController extends Controller
{
    public function index()
    {
        $townships = Township::paginate(10);
        return view('backend.townships.index', compact('townships'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('backend.townships.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'english_name' => 'required|max:255',
            'myanmar_name' => 'required|max:255',
            'region_id' => 'required',
            'delivery_price' => 'required',
        ]);

        $township = Township::create(['region_id' => $request->region_id, 'delivery_price' => $request->delivery_price]);
        TownshipInfo::Create(['name' => $request->english_name,'township_id'=> $township->id,'language_id'=>1]);
        TownshipInfo::Create(['name' => $request->myanmar_name,'township_id'=> $township->id,'language_id'=>2]);

        return redirect()->route('townships.index')->with('success','Successfully Create Township');
    }

    public function show($id)
    {
        $township = Township::find($id);
        return view('backend.townships.show', compact('township'));
    }

    public function edit($id)
    {
        $township = Township::find($id);
        $regions = Region::all();
        return view('backend.townships.edit', compact('township','regions'));
    }

    public function update(Request $request, $id)
    {
        $township = Township::find($id);
        $request->validate([
            'english_name' => 'required|max:255',
            'myanmar_name' => 'required|max:255',
            'region_id' => 'required',
            'delivery_price' => 'required',
        ]); 
        
        $township->delivery_price = $request->delivery_price;
        $township->region_id = $request->region_id;

        $eng_township = $township->township_infos->where('language_id',1)->first();
        $myan_township = $township->township_infos->where('language_id',2)->first();

        $eng_township->name = $request->english_name;
        $myan_township->name = $request->myanmar_name;
        $township->save();
        $eng_township->save();
        $myan_township->save();

        return redirect()->route('townships.index')->with('success','Successfully Update Township');
    }

    public function destroy(Request $request,$id)
    {
        $township = Township::find($id);          
        $township->delete();
        return redirect()->route('townships.index')->with('success', 'Successfully Delete Township');   
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $townships = Township::whereHas('township_infos', function ($query) use ($search){
                                $query->where('name','like', '%' .$search. '%');
                            })
                            ->orWhereHas('region', function ($query) use ($search){
                                $query->whereHas('region_infos', function ($query) use ($search){
                                    $query->where('name','like', '%' .$search. '%');
                                });
                            })
                            ->orWhere('delivery_price', $search)
                            ->orderBy('id', 'asc')
                            ->paginate(20);

        $townships->appends(['search'=> $request->search]);      

        return view('backend.townships.index', compact('townships'));
    }
}
