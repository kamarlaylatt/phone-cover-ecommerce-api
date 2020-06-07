<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrderStatus;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10);
        return view('backend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $order_statuses = OrderStatus::all();
        return view('backend.orders.edit', compact('order','order_statuses'));
    }

    public function update(Request $request,$id)
    {
        $order = Order::findOrFail($id);
        $order->remark = $request->remark;
        $order->order_status_id = $request->order_status_id;
        $order->update();
        return redirect()->route('orders.index');
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $orders = Order::where('order_no', 'like','%'.$search.'%')
                        ->orWhereHas('user',function ($query) use ($search){
                            $query->where('name','like', '%'.$search.'%');
                        })
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.orders.index', compact('orders'));
    }
}
