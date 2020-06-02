<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use App\BannerInfo;
use Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::paginate(10);
        return view('backend.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banners.create');
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
           'link' => 'required|string', 
           'english_title' => 'required|string',
           'english_subtitle' => 'required|string',
           'english_button_text' => 'required|string',
           'myanmar_title' => 'required|string',
           'myanmar_subtitle' => 'required|string',
           'myanmar_button_text' => 'required|string',
        ]);

        $banner = Banner::Create([
            'link' => $request['link'],
            'text_color' => $request['text_color'],
            'show_status' => isset($request->show_status[0]) ? 1 : 0,
        ]);

        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/banner_imgs/', $file, $filename);
                $banner->image = $filename;
                $banner->save();
        }

        BannerInfo::Create([
            'title' => $request['english_title'],
            'subtitle' => $request['english_subtitle'],
            'button_text' => $request['english_button_text'],
            'banner_id' => $banner->id,
            'language_id' => 1,
        ]);

        BannerInfo::Create([
            'title' => $request['myanmar_title'],
            'subtitle' => $request['myanmar_subtitle'],
            'button_text' => $request['myanmar_button_text'],
            'banner_id' => $banner->id,
            'language_id' => 2,
        ]);

        return redirect(route('banners.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::find($id);
        return view('backend.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('backend.banners.edit', compact('banner'));
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
            'link' => 'required|string', 
            'english_title' => 'required|string',
            'english_subtitle' => 'required|string',
            'english_button_text' => 'required|string',
            'myanmar_title' => 'required|string',
            'myanmar_subtitle' => 'required|string',
            'myanmar_button_text' => 'required|string',
         ]);

         $banner = Banner::find($id);

         if($request->file('image'))
         {
            Storage::delete('public/uploads/banner_imgs/'.$banner->image); 
            
            $file = $request->file('image');
            $filename = uniqid().'_'.$file->getClientOriginalName();
            Storage::disk('public')->putFileAs('/uploads/banner_imgs/', $file, $filename);
            $banner->image = $filename;
            $banner->save();
         }

        $banner->link = $request['link'];
        $banner->text_color = $request['text_color'];
        $banner->show_status = isset($request->show_status[0]) ? 1 : 0;
 
        $eng_banner = $banner->infos->where('language_id',1)->first();
        $myan_banner = $banner->infos->where('language_id',2)->first();

        $eng_banner->title = $request['english_title'];
        $eng_banner->subtitle = $request['english_subtitle'];
        $eng_banner->button_text = $request['english_button_text'];

        $myan_banner->title = $request['myanmar_title'];
        $myan_banner->subtitle = $request['myanmar_subtitle'];
        $myan_banner->button_text = $request['myanmar_button_text'];

        $banner->save();
        $eng_banner->save();
        $myan_banner->save();

        return redirect(route('banners.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);

        Storage::delete('public/uploads/banner_imgs/'.$banner->image);
        $banner->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $banners = Banner::whereHas('infos', function ($query) use ($search){
                            $query->where('title','like', '%' .$search. '%')
                                    ->orwhere('subtitle','like', '%' .$search. '%')
                                    ->orwhere('button_text','like', '%' .$search. '%');
                            })->orderBy('id', 'asc')->paginate(20);


        return view('backend.banners.index', compact('banners'));
    }
}
