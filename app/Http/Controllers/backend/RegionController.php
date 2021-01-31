<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Region;
use App\RegionInfo;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::paginate(10);
        return view('backend.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('backend.regions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'english_name' => 'required|max:255',
            'myanmar_name' => 'required|max:255',
        ]);

        $region = Region::create([]);
        RegionInfo::Create(['name' => $request->english_name,'region_id'=> $region->id,'language_id'=>1]);
        RegionInfo::Create(['name' => $request->myanmar_name,'region_id'=> $region->id,'language_id'=>2]);

        return redirect()->route('regions.index')->with('success','Successfully Create Region');
    }

    public function show($id)
    {
        $region = Region::find($id);
        return view('backend.regions.show', compact('region'));
    }

    public function edit($id)
    {
        $region = Region::find($id);
        return view('backend.regions.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $region = Region::find($id);
        $request->validate([
            'english_name' => 'required|max:255',
            'myanmar_name' => 'required|max:255',
        ]);         

        $eng_region = $region->region_infos->where('language_id',1)->first();
        $myan_region = $region->region_infos->where('language_id',2)->first();

        $eng_region->name = $request->english_name;
        $myan_region->name = $request->myanmar_name;
        $eng_region->save();
        $myan_region->save();

        return redirect()->route('regions.index')->with('success','Successfully Update Region');
    }

    public function destroy(Request $request,$id)
    {
        $region = Region::find($id);          
        $region->delete();
        return redirect()->route('regions.index')->with('success', 'Successfully Delete Region');   
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $regions = Region::whereHas('region_infos', function ($query) use ($search){
                            $query->where('name','like', '%' .$search. '%');
                            })->orderBy('id', 'asc')->paginate(20);

        $regions->appends(['search'=> $request->search]);      

        return view('backend.regions.index', compact('regions'));
    }
    
}
