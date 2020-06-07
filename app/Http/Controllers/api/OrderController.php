<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Http\Resources\OrderListResourceCollection;
use App\Http\Resources\OrderDetailResource;
use App\Order;
use App\OrderItem;
use App\Product;
use DB;
use Auth;
use Storage;

class OrderController extends BaseController
{
    public function productOrder(Request $request)
    {
        $rules = [
            'order_items' => 'required',
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
            $sub_total = $item['quantity']*$product->price;
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


        $order_transaction = DB::transaction(function () use($order_items,$item_count,$total_amount,$order_no) {

            $order = Order::Create([
                'order_status_id' => 1,
                'user_id' => Auth::user()->id,
                'item_count' => $item_count,
                'total_amount' => $total_amount,
                'order_no' => $order_no,
            ]);

            foreach($order_items as $item)
            {
                $product = Product::find($item['item_id']);
                $sub_total = $item['quantity']*$product->price;

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
            'item_count' => $order_transaction->item_count,
            'total_amount' => $order_transaction->total_amount,
            'order_status' => $order_transaction->order_status->name,
            'orderDate' => $order_transaction->created_at->format('d/m/Y'),
            'orderTime' => $order_transaction->created_at->format('H:i A'),
            'order_time' => date($order_transaction->created_at),
        ];

        return $this->successResponse($responseBody, 'Success Order');

    }

    public function orderList()
    {
        return new OrderListResourceCollection(Order::where('user_id', Auth::user()->id)->paginate(20));
    }

    public function orderDetail(Request $request)
    {
        $responseBody = new OrderDetailResource(Order::findOrFail($request->order_id));
        return $this->successResponse($responseBody, 'Success retrieve Order Detail');
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
}
