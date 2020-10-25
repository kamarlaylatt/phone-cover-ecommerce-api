@extends('layouts.backend')
@section('title','Products | Create')

@section('head_title','Product')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('products.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Product</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('products.create')}}" class="m-nav__link">
            <span class="m-nav__link-text">Create</span>
        </a>
    </li>   
@endsection


@section('content')
<div id='app'>
    <product_create-component 
    :categories="{{json_encode($category_array)}}"
    :base_url="{{json_encode(URL::to('/'))}}"
    ></product_create-component>
</div>
@endsection