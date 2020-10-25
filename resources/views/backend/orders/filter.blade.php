@extends('layouts.backend')
@section('title','Order | Filter')

@section('head_title','Order Filter')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('orders.filter')}}" class="m-nav__link">
            <span class="m-nav__link-text">Order Filter</span>
        </a>
    </li>
@endsection


@section('content')
<div class="container col-md-12" id='app'>
    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4 card-title text-center mt-4 h3">Filtering Orders</div>
            </div>

            <div class="card-body">
                <filter_order-component :base_url="{{json_encode(URL::to('/'))}}"></filter_order-component>
            </div>
        </div>
    </div>
</div>
@endsection