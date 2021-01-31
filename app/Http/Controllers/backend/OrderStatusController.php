<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrderStatus;
use Storage;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_statuses = OrderStatus::orderBy('sort_index')->paginate(10);
        return view('backend.order_statuses.index', compact('order_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.order_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_index' => 'required',
            // 'icon' => 'required|image',
            'color' => 'required'
        ]);

        $order_status = OrderStatus::create([
            'name' => $request['name'],
            'sort_index' => $request['sort_index'],
            'description' => $request['description'],
            'color' => $request['color']
        ]);

        // if($request->file('icon'))
        // {
        //         $file = $request->file('icon');
        //         $filename = uniqid().'_'.$file->getClientOriginalName();
        //         Storage::disk('public')->putFileAs('/uploads/order_status_imgs/', $file, $filename);
        //         $order_status->icon = $filename;
        //         $order_status->save();
        // }

        return redirect()->route('order_statuses.index')->with('success','Successfully Create Order Status');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order_status = OrderStatus::find($id);
        return view('backend.order_statuses.show', compact('order_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order_status = OrderStatus::find($id);
        return view('backend.order_statuses.edit', compact('order_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order_status = OrderStatus::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_index' => 'required',
        ]);         
        
        $order_status->name = $request['name'];
        $order_status->sort_index = $request['sort_index'];
        $order_status->description = $request['description'];
        $order_status->color = $request['color'];
        // if($request->file('icon'))
        // {
        //     Storage::delete('public/uploads/order_status_imgs/'.$order_status->icon); 
        //     $file = $request->file('icon');
        //     $filename = uniqid().'_'.$file->getClientOriginalName();
        //     Storage::disk('public')->putFileAs('/uploads/order_status_imgs/', $file, $filename);
        //     $order_status->icon = $filename;
        //     $order_status->save();
        // }

        $order_status->update();

        return redirect()->route('order_statuses.index')->with('success','Successfully Update Order Status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order_status = OrderStatus::find($id);
        if($order_status->orders()->exists())
        {
            return redirect()->route('order_statuses.index')->with('error','Sorry, you cannot delete this status, related to order informations');
        }
        Storage::delete('public/uploads/order_status_imgs/'.$order_status->icon);
        $order_status->delete();

        return redirect()->route('order_statuses.index')->with('success','Successfully Delete Order Status');
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $order_statuses = OrderStatus::where('name', 'like','%'.$search.'%')
                        ->orWhere('description','like','%'.$search.'%')
                        ->orWhere('sort_index','like','%'.$search.'%')
                        ->orderBy('id', 'asc')->paginate(20);
        $order_statuses->appends(['search'=> $request->search]);      

        return view('backend.order_statuses.index', compact('order_statuses'));
    }
}
