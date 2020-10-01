@extends('layouts.backend')
@section('title','Order | View ')

@section('head_title','Orders')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('orders.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Order</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('orders.show', $order->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')
<div class="container col-md-12">
    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4 card-title text-center mt-4 h3">Order Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('orders.edit', $order->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>No</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>#{{$order->order_no}}</strong></div>
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Ordered at</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->created_at->format('d/M/Y h:i A')}}</strong></div>
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Status</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong><span class="badge badge-pill badge-info">{{$order->order_status->name}}</span></strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Customer Name</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->user->name}}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Total Item</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->item_count}}</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Total Amount</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->total_amount}}</strong></div>
                </div>
                <div class="row">
                    <div class="col-sm-3 h5"><strong>Remark</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$order->remark}}</strong></div>
                </div>
                <br>
                <h4>Order Items</h4>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-font">
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center">Product Image</th>
                            <th class="align-middle text-center">Product Name</th>
                            <th class="align-middle text-center">Quantity</th>
                            <th class="align-middle text-center">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->order_items as $key=>$item)
                            <tr>
                                <td class="align-middle text-center">{{$key+1}}</td>
                                <td class="align-middle text-center">
                                    @if(is_file(\Storage::path('public/uploads/product_imgs/thumbnail/'.$item->item->image)))
                                        <img src="{{url(\Storage::url('uploads/product_imgs/thumbnail/'.$item->item->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="100" height="100">
                                    @else
                                        <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                                    @endif
                                </td>
                                <td class="align-middle text-center">{{$item->item->infos->where('language_id',1)->first()->name}}</td>
                                <td class="align-middle text-center">{{$item->quantity}}</td>
                                <td class="align-middle text-center">{{$item->sub_total}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            


        </div>
    </div>
</div>
@endsection