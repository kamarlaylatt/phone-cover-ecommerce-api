<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Intension;
use App\OrderStatus;
use File;
use ZipArchive;

class IntensionController extends Controller
{
    public function diyOrder()
    {
        $intensions = Intension::where('type',1)->paginate(10);
        return view('backend.intensions.diy_order', compact('intensions'));
    }

    public function helpOrder()
    {
        $intensions = Intension::where('type',2)->paginate(10);
        return view('backend.intensions.help_order', compact('intensions'));
    }

    public function show($id)
    {
        $intension = Intension::findOrFail($id);
        return view('backend.intensions.show', compact('intension'));
    }

    public function edit($id)
    {
        $intension = Intension::findOrFail($id);
        $order_statuses = OrderStatus::all();
        return view('backend.intensions.edit', compact('intension','order_statuses'));
    }

    public function update(Request $request,$id)
    {
        $intension = Intension::findOrFail($id);
        $intension->remark = $request->remark;
        $intension->order_status_id = $request->order_status_id;
        $intension->update();
        return redirect()->route('intensions.show', $intension->id);
    }

    public function download($id)
    {
        $zip = new ZipArchive;
        $intension = Intension::findOrFail($id);


   
        $fileName = 'intension_images.zip';
   
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            $zip->addFile(storage_path('app/public/orders/images/'.$intension->preview), $intension->preview);
            foreach ($intension->intension_images as $image) {

                $zip->addFile(storage_path('app/public/orders/images/'.$image->image), $image->image);
            }
             
            $zip->close();
        }
    
        return response()->download(public_path($fileName));
    }
}
