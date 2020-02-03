@extends('layouts.backend')
@section('title','Categories|Edit')

@section('head_title','Category')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('categories.create')}}" class="m-nav__link">
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
                        Category Edit
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <div class="m-portlet__body">
            <category_edit-component :img_url="{{json_encode($img_url)}}" :category="{{json_encode($category)}}" :categories="{{json_encode($category_array)}}"></category_edit-component>
        </div>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->

@endsection