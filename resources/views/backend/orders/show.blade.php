@extends('layouts.backend')
@section('title','Order | Show ')

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
            <span class="m-nav__link-text">Show</span>
        </a>
    </li>   
@endsection

@section('content')
<div class="container col-md-12">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Order Detail</div>

            <div class="card-body">
                <p class="h5"><strong>No - #{{$order->order_no}}</strong></p>
                <p class="h5"><strong>Ordered at - {{$order->created_at->format('d/M/Y h:i A')}}</strong></p>
                <p class="h5"><strong>Status - {{$order->order_status->name}}</strong></p>
                <p class="h5"><strong>Customer Name - {{$order->user->name}}</strong></p>
                <p class="h5"><strong>Total Item - {{$order->item_count}}</strong></p>
                <p class="h5"><strong>Total Amount - {{$order->total_amount}}</strong></p>
                <p class="h5"><strong>Remark - {{$order->remark}}</strong></p>
                <br>
                <h4>Order Items</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
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