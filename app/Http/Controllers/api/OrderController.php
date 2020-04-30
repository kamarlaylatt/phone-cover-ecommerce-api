<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Order;
use App\OrderItem;
use DB;

class OrderController extends BaseController
{
    public function productOrder(Request $request)
    {
        $rules = [
            'order_header.item_count' => 'required|numeric',
            'order_header.total_amount' => 'required|numeric',
            'order_body.order_items' => 'required',
        ];

        $order_header = $request->order_header;
        $order_body = $request->order_body;

        $item_count = $order_header['item_count'];
        $total_amount = $order_header['total_amount'];
        

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

        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
		}

        $order_transaction = DB::transaction(function () use($order_header,$order_body,$item_count,$total_amount,$order_no) {

            $order = Order::Create([
                'order_status_id' => 1,
                'user_id' => 1,
                'item_count' => $item_count,
                'total_amount' => $total_amount,
                'order_no' => $order_no,
            ]);

            foreach($order_body['order_items'] as $item)
            {
                OrderItem::Create([
                    'order_id' => $order->id,
                    'item_id' => $item['item_id'],
                    'item_type' => 'App\Product',
                    'quantity' => $item['quantity'],
                    'sub_total' => $item['sub_total'],
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
        ];

        return $this->successResponse($responseBody, 'Success Order');

    }
}
