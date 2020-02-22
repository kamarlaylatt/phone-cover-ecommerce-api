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



<!--begin::Portlet-->
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Product Edit
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <div class="m-portlet__body">
        <!-- <p>{{json_encode($images)}}</p> -->
            <product_edit-component 
                :images="{{json_encode($images)}}"
                :product="{{json_encode($product)}}"
                :selected_categories="{{json_encode($product->categories)}}"
                :product_infos="{{json_encode($product->infos)}}"
                :product_additions="{{json_encode($product->additions)}}"
                :thumbnail_url="{{json_encode($thumbnail_url)}}"
                :categories="{{json_encode($category_array)}}">
            </product_edit-component>
        </div>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->

@endsection