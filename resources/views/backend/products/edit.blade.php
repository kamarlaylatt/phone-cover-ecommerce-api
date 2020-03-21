@extends('layouts.backend')
@section('title','Products|Edit')

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
            <span class="m-nav__link-text">Edit</span>
        </a>
    </li>   
@endsection


@section('content')

        <!-- <p>{{json_encode($product->categories)}}</p> -->
            <product_edit-component 
                :edit_images="{{json_encode($images)}}"
                :product="{{json_encode($product)}}"
                :selected_categories="{{json_encode($product->categories)}}"
                :product_infos="{{json_encode($product->infos)}}"
                :product_additions="{{json_encode($product->additions)}}"
                :thumbnail_url="{{json_encode($thumbnail_url)}}"
                :categories="{{json_encode($category_array)}}">
            </product_edit-component>
        </div>

@endsection