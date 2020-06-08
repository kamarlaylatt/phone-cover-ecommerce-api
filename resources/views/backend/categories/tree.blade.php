@extends('layouts.backend')
@section('title','UL | Categories')

@section('head_title','Category')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Tree</span>
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
                        Category Tree
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <!-- Tree Dialog Start -->
            <div class="row">
                <div class="mb-4 mr-4">
                    <a href="{{route('categories.index')}}"  type="button" class="btn btn-primary">Grid View</a>
                </div>
                <div class="mb-4">
                    <a href="{{route('categories.create')}}" class="btn btn-success">
                        <span>
                            <i class="la la-plus"></i>
                            <span>Create</span>
                        </span>
                    </a>
                </div>
            </div>
            <!-- Tree Dialog End -->

            <tree-component :categories="{{json_encode($category_array)}}"></tree-component>

        </div>
        
    </div>
</div>
@endsection