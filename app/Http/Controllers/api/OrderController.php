<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Http\Resources\OrderListResourceCollection;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\IntensionResource;
use App\Order;
use App\OrderItem;
use App\Product;
use App\Intension;
use App\IntensionImage;
use App\ShellMaterial;
use DB;
use Auth;
use Storage;

class OrderController extends BaseController
{
    public function productOrder(Request $request)
    {
        $rules = [
            'order_items' => 'required',
            'phone' => 'string|max:20',
            'address' => 'string|max:191'
        ];
        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
		}

        $order_items = $request->order_items;

        //check valid item_id
        foreach($order_items as $item)
        {
            $check_order = Product::find($item['item_id']);
            if(!$check_order)
            {
                $error = [
                    [
                        'fieldCode' => 'invalid',
                        'errorMessage' => 'item_id ' . $item['item_id'] . ' not have in item list.',
                    ],                    
                ];

                return $this->failResponse($error);
            }
        }
        //end check

        //item count
        $item_count = count($order_items);

        //total amount
        $total_amount = 0;
        foreach($order_items as $item)
        {
            $product = Product::find($item['item_id']);
            if($product->discount_price > 0){
                $product_price = $product->discount_price;
            }else{
                $product_price =  $product->price;
            }
            $sub_total = $item['quantity']*$product_price;
            $total_amount += $sub_total;
        }
        
        //check unique order no
        $check = false;
        $order_no = 0;
        while($check == false){
            $order_no = time();
            $check_no = Order::where('order_no',$order_no)->first();
            if(!$check_no)
            {
                $check = true;
            }
            else{
                $check = false;
            }
        }
        //end check


        $order_transaction = DB::transaction(function () use($order_items,$item_count,$total_amount,$order_no,$request) {

            $order = Order::Create([
                'order_status_id' => 1,
                'user_id' => Auth::user()->id,
                'item_count' => $item_count,
                'total_amount' => $total_amount,
                'total_net' => $total_amount,
                'order_no' => $order_no,
                'phone' => $request->phone,
                'address' => $request->address,
                'total_net' => $total_amount,
                'delivery_cost' => $request->delivery_amount,
                'payment_method' => $request->payment_method,
            ]);

            foreach($order_items as $item)
            {
                $product = Product::find($item['item_id']);
                if($product->discount_price > 0){
                    $product_price = $product->discount_price;
                }else{
                    $product_price =  $product->price;
                }
                $sub_total = $item['quantity']*$product_price;

                OrderItem::Create([
                    'order_id' => $order->id,
                    'item_id' => $item['item_id'],
                    'item_type' => 'App\Product',
                    'quantity' => $item['quantity'],
                    'sub_total' => $sub_total,
                ]);
            }

            return $order;
        });
        

        $responseBody = [
            'orderId' => $order_transaction->id,
            'orderNo' => $order_transaction->order_no,
            'phone' => $order_transaction->phone,
            'address' => $order_transaction->address,
            'item_count' => $order_transaction->item_count,
            'total_amount' => $order_transaction->total_amount,
            'total_net' => $order_transaction->total_amount,
            'order_status' => $order_transaction->order_status->name,
            'orderDate' => $order_transaction->created_at->format('d/m/Y'),
            'orderTime' => $order_transaction->created_at->format('H:i A'),
            'order_time' => date($order_transaction->created_at),
            'delivery_amount' => $order_transaction->delivery_cost,
            'payment_method' => $order_transaction->payment_method,
        ];

        return $this->successResponse($responseBody, 'Success Order');

    }

    public function confirmOrder(Request $request)
    {
        $order_type = $request->order_type;

        if($order_type == 'order')
        {
            $order = Order::findOrFail($request->order_id);
            $order->order_status_id = 2;
            $order->save();
        }else{
            $order = Intension::findOrFail($request->order_id);
            $order->order_status_id = 2;
            $order->save();
        }
            $responseBody = [];
            return $this->successResponse($responseBody, 'Successfully update order confirmed');

    }

    public function orderList()
    {
        $intensions = Intension::select('id','user_id','order_status_id','order_no',DB::raw('1 as item_count'),DB::raw('"intension" as type'),'price as total_amount','delivery_cost','total_net','created_at')
                                ->where('user_id', Auth::user()->id)
                                ->with('order_status','user');

        $orders = Order::select('id','user_id','order_status_id','order_no','item_count',DB::raw('"order" as type'),'total_amount','delivery_cost','total_net','created_at')
                                ->where('user_id', Auth::user()->id)
                                ->with('order_status','user');

        $order_history = $orders->union($intensions)->orderBy('created_at','desc')->paginate(10);
        return new OrderListResourceCollection($order_history);
    }

    public function orderDetail(Request $request)
    {
        $user_orders = Order::where('user_id', Auth::user()->id)->where('id', $request->order_id)->first();
        if(isset($user_orders))
        {
            $responseBody = new OrderDetailResource(Order::findOrFail($request->order_id));
            return $this->successResponse($responseBody, 'Success retrieve Order Detail');
        }{
            $error = [
                [
                    'fieldCode' => 'invalid',
                    'errorMessage' => 'Sorry, this order detail is not for '.Auth::user()->name,
                ],    
            ];
            return response()->json($error);
        }
        
    }

    public function imageUpload(Request $request)
    {
        $files = $request->file('images');
        if(is_array($files))
        {
            $image_array = array();
            foreach($files as $file)
            {
                $filename = uniqid().'_'.$file->getClientOriginalName();
                Storage::disk('public')->putFileAs('/orders/images/', $file, $filename);
                $obj = [
                    'image_url' => url(\Storage::url('orders/images/'.$filename)),
                    'image_name' => $filename,
                ];
                array_push($image_array,$obj);
            }
            $responseBody = $image_array;
        }
        else{
            $filename = uniqid().'_'.$files->getClientOriginalName();
            Storage::disk('public')->putFileAs('/orders/images/', $files, $filename);
            $responseBody = [
                'image_url' => url(\Storage::url('orders/images/'.$filename)),
                'image_name' => $filename,
            ];
        }
        
        return $this->successResponse($responseBody, 'Success upload Image');
    }

    public function intensionOrder(Request $request)
    {
        //check unique order no
        $check = false;
        $order_no = 0;
        while($check == false){
            $order_no = time();
            $check_no = Order::where('order_no',$order_no)->first();
            if(!$check_no)
            {
                $check = true;
            }
            else{
                $check = false;
            }
        }
        //end check

        $shell_material = ShellMaterial::findOrFail($request->shell_material_id);
        $intension = Intension::Create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'order_no' => $order_no,
            'type' => $request->type,
            'phone_model_id' => $request->phone_model_id,
            'shell_material_id' => $request->shell_material_id,
            'preview' => $request->preview,
            'price' => $shell_material->price,
            'total_net' => $shell_material->price,
            'order_status_id' => 1,
        ]);
        
        if($request->images != null)
        {
            foreach($request->images as $image)
            {
                IntensionImage::Create([
                    'intension_id' => $intension->id,
                    'image' => $image,
                ]);
            }
        }
        

        $responseBody = [
            'intension_id' => $intension->id,
            'name' => $intension->name,
            'phone' => $intension->phone,
            'address' => $intension->address,
            'order_no' => $intension->order_no,
            'type' => $intension->type,  
            'phone_model' => $intension->phone_model->name,
            'shell_material' => $intension->shell_material->name, 
            'price' => $intension->price,
            'total_net' => $intension->price,    
            'order_status' => $intension->order_status->name,   
        ];

        return $this->successResponse($responseBody, 'Success upload Intension Order');
        
    }

    public function intensionDetail(Request $request)
    {
        $intension = Intension::findOrFail($request->intension_id);
        $responseBody =  new IntensionResource($intension);

        return $this->successResponse($responseBody, 'Successfully retrieve Intension Detail');
    }
}
