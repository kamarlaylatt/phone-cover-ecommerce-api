<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Intension;
use App\OrderStatus;
use File;
use ZipArchive;
use Storage;

class IntensionController extends Controller
{
    public function diyOrder()
    {
        $intensions = Intension::sortable()->where('type',1)->orderBy('created_at','desc')->paginate(10);
        return view('backend.intensions.diy_order', compact('intensions'));
    }

    public function helpOrder()
    {
        $intensions = Intension::sortable()->where('type',2)->orderBy('created_at','desc')->paginate(10);
        return view('backend.intensions.help_order', compact('intensions'));
    }

    public function show($id)
    {
        $intension = Intension::findOrFail($id);
        $order_statuses = OrderStatus::all();
        return view('backend.intensions.show', compact('intension','order_statuses'));
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

    public function updateShow(Request $request,$id)
    {
        
        $intension = Intension::findOrFail($id);
        $intension->remark = $request->remark;
        $intension->delivery_cost = $request->delivery_cost;
        $intension->total_net = $request->delivery_cost+$intension->price;
        $intension->pay_amount = $request->pay_amount;
        $intension->remain_amount= $request->remain_amount;
        $intension->order_status_id = $request->order_status_id;

        $intension->update();
        return response()->json([
            'status' => 200,
            'message' => "Successfully Update Intension",
            'data' => $intension,
            'order_status' => $intension->order_status,
        ]);
    }

    public function download($id)
    {
        $intension = Intension::findOrFail($id);
        // return $intension->order_no;
        $fileName = "intensionNo-".$intension->order_no.".zip";
   
        $zip = new ZipArchive;
        if ($zip->open(storage_path('app/public/'.$fileName), ZipArchive::CREATE) === TRUE)
        {
            

            if(is_file(Storage::path('public/orders/images/'.$intension->preview)))
            {
                $zip->addFile(storage_path('app/public/orders/images/'.$intension->preview), $intension->preview);
            }
            
            foreach ($intension->intension_images as $image) {
                if(is_file(Storage::path('public/orders/images/'.$image->image)))
                {
                    $zip->addFile(storage_path('app/public/orders/images/'.$image->image), $image->image);
                }
                else if(is_file(Storage::path('public/uploads/charlet_imgs/'.$image->image)))
                {
                    $zip->addFile(storage_path('app/public/uploads/charlet_imgs/'.$image->image), $image->image);
                }
                else if(is_file(Storage::path('public/uploads/mask_imgs/'.$image->image)))
                {
                    $zip->addFile(storage_path('app/public/uploads/mask_imgs/'.$image->image), $image->image);
                }
            }
             
            $zip->close();

        }
    
        if(is_file(storage_path('app/public/'.$fileName)))
        {
            return response()->download(storage_path('app/public/'.$fileName))->deleteFileAfterSend(true);   
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
