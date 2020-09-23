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
        $intension = Intension::findOrFail($id);

        if(is_file(public_path('/intension_images.zip')))
        {
            unlink(public_path('/intension_images.zip'));
        }

   
        $fileName = 'intension_images.zip';
        $zip = new ZipArchive;
        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE)
        {

            if($intension->type == 1)
            {
                $zip->addFile(storage_path('app/public/orders/images/'.$intension->preview), $intension->preview);
            }
            foreach ($intension->intension_images as $image) {

                $zip->addFile(storage_path('app/public/orders/images/'.$image->image), $image->image);
            }
             
            $zip->close();

        }
    
        if(is_file(public_path('/intension_images.zip')))
        {
            return response()->download($fileName);   
        }else{
            return redirect()->back()->with('error','There is no file for download!');
        }
    }

    public function diySearch(Request $request)
    {
        $search = $request['search'];

        $intensions = Intension::where('order_no', 'like','%'.$search.'%')
                        ->orWhere('name','like','%'.$search.'%')
                        ->orWhere('phone','like','%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.intensions.diy_order', compact('intensions'));

    }

    public function helpSearch(Request $request)
    {
        $search = $request['search'];

        $intensions = Intension::where('order_no', 'like','%'.$search.'%')
                        ->orWhere('name','like','%'.$search.'%')
                        ->orWhere('phone','like','%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.intensions.help_order', compact('intensions'));

    }
}
