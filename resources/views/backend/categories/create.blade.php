@extends('layouts.backend')
@section('title','Admins|Create')

@section('head_title','Administrator')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('categories.create')}}" class="m-nav__link">
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
                        Category Create
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <div class="m-portlet__body">
            <tree_edit-component :categories="{{json_encode($category_array)}}"></tree_edit-component>
        </div>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->

@endsection