@extends('layouts.backend')
@section('title','Products|Create')

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



<!--begin::Portlet-->
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Product Create
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <div class="m-portlet__body">
            <product_create-component></product_create-component>
        </div>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->

@endsection