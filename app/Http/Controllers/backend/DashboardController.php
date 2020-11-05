<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use URL;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend._dashboard.dashboard');
    }

    public function imageUpload(Request $request){
        if($request->file('image'))
        {
                $file = $request->file('image');
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/uploads/editor_imgs/', $file, $filename);
        }

        if(is_file(Storage::path('public/uploads/editor_imgs/'.$filename)))
        {
            $image_url = url(Storage::url('uploads/editor_imgs/'.$filename));
        }
        else{
            $image_url = asset('images/default.png');
        }

         return response()->json([
             'status' => 200,
             'message' => "Successfully Upload Image",
             'data' => [
                 'img_url' => $image_url,
             ] 
         ]);
    }

    public function imageRemove(Request $request){
        if(is_file(Storage::path('public/uploads/editor_imgs/'.$request->filename)))
        {
            Storage::delete('public/uploads/editor_imgs/'.$request->filename);
        }

        return response()->json([
            'status' => 200,
            'message' => "Successfully Delete Image",
            'data' => (object)[],
        ]);
    }
}
