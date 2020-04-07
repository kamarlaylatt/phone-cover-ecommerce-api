<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Recruitment;
use App\RecruitmentInfo;
use Auth;
use Storage;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recruitments = Recruitment::paginate(10);
        return view('backend.recruitments.index', compact('recruitments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.recruitments.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'sort_index' => 'required|numeric', 
            'english_title' => 'required|string',
            'english_description' => 'required|string',
            'myanmar_title' => 'required|string',
            'myanmar_description' => 'required|string',
         ]);
 
         $recruitment = Recruitment::Create([
             'sort_index' => $request['sort_index'],
             'created_by_id' => Auth::user()->id,
         ]);
 
         if($request->file('image'))
         {
                 $file = $request->file('image');
                 $filename = uniqid().'_'.$file->getClientOriginalName();
                 Storage::disk('public')->putFileAs('/uploads/recruitment_imgs/', $file, $filename);
                 $recruitment->image = $filename;
                 $recruitment->save();
         }
 
         RecruitmentInfo::Create([
             'title' => $request['english_title'],
             'description' => $request['english_description'],
             'recruitment_id' => $recruitment->id,
             'language_id' => 1,
         ]);
 
         RecruitmentInfo::Create([
             'title' => $request['myanmar_title'],
             'description' => $request['myanmar_description'],
             'recruitment_id' => $recruitment->id,
             'language_id' => 2,
         ]);
 
         return redirect(route('recruitments.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recruitment = Recruitment::find($id);
        return view('backend.recruitments.show', compact('recruitment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recruitment = Recruitment::find($id);
        return view('backend.recruitments.edit', compact('recruitment'));
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
        $request->validate([
            'sort_index' => 'required|numeric', 
            'english_title' => 'required|string',
            'english_description' => 'required|string',
            'myanmar_title' => 'required|string',
            'myanmar_description' => 'required|string',
         ]);

         $recruitment = Recruitment::find($id);

         if($request->file('image'))
         {
            Storage::delete('public/uploads/recruitment_imgs/'.$recruitment->image); 
            
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/recruitment_imgs/', $file, $filename);
            $recruitment->image = $filename;
            $recruitment->save();
         }

        $recruitment->sort_index = $request['sort_index'];
 
        $eng_recruitment = $recruitment->infos->where('language_id',1)->first();
        $myan_recruitment = $recruitment->infos->where('language_id',2)->first();

        $eng_recruitment->title = $request['english_title'];
        $eng_recruitment->description = $request['english_description'];

        $myan_recruitment->title = $request['myanmar_title'];
        $myan_recruitment->description = $request['myanmar_description'];

        $recruitment->save();
        $eng_recruitment->save();
        $myan_recruitment->save();

        return redirect(route('recruitments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recruitment = Recruitment::find($id);

        Storage::delete('public/uploads/recruitment_imgs/'.$recruitment->image);
        $recruitment->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $recruitments = Recruitment::whereHas('infos', function ($query) use ($search){
                            $query->where('title','like', '%' .$search. '%')
                                    ->orwhere('description','like', '%' .$search. '%');
                            })->orderBy('id', 'asc')->paginate(20);


        return view('backend.recruitments.index', compact('recruitments'));
    }
}
