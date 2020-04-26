<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Order;
use App\OrderItem;

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

        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
		}

        $order = Order::Create([
            'order_status_id' => 1,
            'user_id' => 1,
            'item_count' => $item_count,
            'total_amount' => $total_amount,
            'order_no' => 134739,
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

        return 'success';
    }
}
