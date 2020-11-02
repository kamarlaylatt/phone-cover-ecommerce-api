@extends('layouts.backend')
@section('title','UL | Orders')

@section('head_title','Order')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('orders.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Order</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('orders.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Table</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="box">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                        Orders Table<small>Control all of order lists</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('orders.search')}}">
                        <div class="row align-items-center">
                            <div class="col-xl-8 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-4">                                    
                                            @csrf
                                            <div class="m-input-icon m-input-icon--left">
                                                <input type="text" name="search" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch" required>
                                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>                                           
                                            </div>                                        
                                        
                                    </div>
                                    <div class="col-md-1 mr-1">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{route('orders.index')}}"class="btn btn-primary">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            {{-- <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>Create</span>
                                    </span>
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div> --}}
                        </div>
                    </form>
                </div>

                <!--end: Search Form -->

                <!--begin: Datatable -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="html_table" width="100%">
                       <thead>
                            <tr class="table-font">
                                <th title="Field #1" data-field="No">No</th>
                                <th title="Field #2" data-field="Name">@sortablelink('order_no','Order No')</th>
                                <th title="Field #3" data-field="Email">@sortablelink('total_amount','Total Amount')</th>
                                <th title="Field #3" data-field="Role">@sortablelink('name','Customer Name')</th>
                                <th title="Field #3" data-field="Role">@sortablelink('order_status.name','Order Status')</th>
                                <th title="Field #4" data-field="Action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key=>$order)
                                <tr>
                                    <td>{{ $key+ $orders->firstItem() }}</td>
                                    <td>{{$order->order_no}}</td>
                                    <td>{{$order->total_amount}}</td>
                                    <td>{{$order->user->name}}</td>
                                    <td class="text-center"><h5><span style="background-color: {{$order->order_status->color}}" class="badge badge-pill text-white">{{$order->order_status->name}}</span></h5></td>
                                    <td>
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('orders.show', $order->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        {{-- <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('orders.edit', $order->id)}}"><i class="fa fa-edit"></i></a> --}}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody> 
                    </table>   
                    {!! $orders->appends(\Request::except('page'))->render() !!}      
                    {{-- {{ $orders->links() }}      --}}
                </div>

                <!--end: Datatable -->
            </div>
            
        </div>
</div>
@endsection

@section('head')
    <style>
        .col-width{
            text-align: center;
            width: 50px;
        }

        th{
            text-align: center;
        }

        td{
            text-align: center;
        }
    </style>
@endsection