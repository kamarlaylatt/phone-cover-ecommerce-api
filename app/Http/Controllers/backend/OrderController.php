<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

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
