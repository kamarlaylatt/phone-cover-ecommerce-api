@extends('layouts.backend')
@section('title','Order Status | View')

@section('head_title','Order Statuses')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('order_statuses.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Order Status</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('order_statuses.show', $order_status->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Order Status Detail</div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Icon </th>
                        <td>                             
                            @if(is_file(\Storage::path('public/uploads/order_status_imgs/'.$order_status->icon)))
                                <img src="{{url(Storage::url('public/uploads/order_status_imgs/'.$order_status->icon))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">
                            @else
                                <img src="{{asset('images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">                                           
                            @endif
                        </td>
                    </tr>    
                    <tr>
                        <th> Name </th>
                        <td>                             
                            {{$order_status->name}}
                        </td>
                    </tr>   
                    <tr>
                        <th> Sort Index </th>
                        <td>                             
                            {{$order_status->sort_index}}
                        </td>
                    </tr>        
                    <tr>
                        <th> Description </th>
                        <td>                             
                            {{$order_status->description}}
                        </td>
                    </tr>                        
                </table>
            </div>

        </div>
    </div>
</div>
@endsection