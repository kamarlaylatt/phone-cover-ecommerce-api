<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrderStatus;
use App\Intension;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::sortable()->orderBy('created_at','desc')->paginate(10);
        return view('backend.orders.index', compact('orders'));
    }

    public function filter()
    {
        $orders = Order::paginate(10);
        return view('backend.orders.filter', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order_statuses = OrderStatus::all();
        return view('backend.orders.show', compact('order','order_statuses'));
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
        $order->save();
        return view('backend.orders.show', compact('order'));
    }

    public function updateShow(Request $request,$id)
    {
        
        $order = Order::findOrFail($id);
        $order->remark = $request->remark;
        $order->delivery_cost = $request->delivery_cost;
        $order->total_net = $request->delivery_cost+$order->total_amount;
        $order->pay_amount = $request->pay_amount;
        $order->remain_amount= $request->remain_amount;
        $order->order_status_id = $request->order_status_id;

        $order->update();
        return response()->json([
            'status' => 200,
            'message' => "Successfully Update Order",
            'data' => $order,
            'order_status' => $order->order_status,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $orders = Order::where('order_no', 'like','%'.$search.'%')
                        ->orWhereHas('user',function ($query) use ($search){
                            $query->where('name','like', '%'.$search.'%');
                        })
                        ->orWhereHas('order_status',function ($query) use ($search){
                            $query->where('name','like', '%'.$search.'%');
                        })
                        ->orderBy('id', 'asc')->paginate(20);


        return view('backend.orders.index', compact('orders'));
    }

    public function filterOrder(Request $request)
    {
        $order_type = $request->order_type;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $orders = null;
        if($order_type == 1)
        {
            $orders = Order::where(function ($query) use ($from_date,$to_date){
                                    $query->whereDate('created_at', '>=' ,$from_date)
                                        ->whereDate('created_at', '<=', $to_date);
                                })->get()->map(function($order){
                                    return [
                                        'id' => $order->id,
                                        'no' => 1,
                                        'order_no' => $order->order_no,
                                        'customer_name' => $order->user->name,
                                        'phone' => $order->phone,
                                        'address' => $order->address,
                                        'order_status' => $order->order_status->name,
                                        'order_status_color' => $order->order_status->color,
                                        'total_item' => $order->item_count,
                                        'total_price' => $order->total_amount,
                                        'date' => date('d/m/Y h:i a', strtotime($order->created_at)),
                                        'order_type' => 1
                                    ];
                                });
        }
        elseif($order_type == 2)
        {
            $orders = Intension::where(function ($query) use ($from_date,$to_date){
                                    $query->whereDate('created_at', '>=' ,$from_date)
                                        ->whereDate('created_at', '<=', $to_date);
                                })->where('type',1)
                                ->get()->map(function($order){
                                    return [
                                        'id' => $order->id,
                                        'no' => 1,
                                        'order_no' => $order->order_no,
                                        'customer_name' => $order->name,
                                        'phone' => $order->phone,
                                        'address' => $order->address,
                                        'order_status' => $order->order_status->name,
                                        'order_status_color' => $order->order_status->color,
                                        'total_item' => 1,
                                        'total_price' => null,
                                        'date' => date('d/m/Y h:i a', strtotime($order->created_at)),
                                        'order_type' => 2
                                    ];
                                });
        }else{
            $orders = Intension::where(function ($query) use ($from_date,$to_date){
                                    $query->whereDate('created_at', '>=' ,$from_date)
                                        ->whereDate('created_at', '<=', $to_date);
                                })->where('type',2)
                                ->get()->map(function($order){
                                    return [
                                        'id' => $order->id,
                                        'no' => 1,
                                        'order_no' => $order->order_no,
                                        'customer_name' => $order->name,
                                        'phone' => $order->phone,
                                        'address' => $order->address,
                                        'order_status' => $order->order_status->name,
                                        'order_status_color' => $order->order_status->color,
                                        'total_item' => 1,
                                        'total_price' => null,
                                        'date' => date('d/m/Y h:i a', strtotime($order->created_at)),
                                        'order_type' => 3
                                    ];
                                });
        }

        $responseBody = [
            'status' => 1,
            'message' => "Successfully retrieve orders",
            'data' => $orders,
        ];

        return response()->json($responseBody);
    }
}
