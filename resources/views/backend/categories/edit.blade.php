@extends('layouts.backend')
@section('title','Categories | Edit')

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
        <div id='app'>
            <category_edit-component 
                :img_url="{{json_encode($img_url)}}" 
                :category="{{json_encode($category)}}" 
                :category_infos="{{json_encode($category->category_infos)}}" 
                :categories="{{json_encode($category_array)}}"
                :base_url="{{json_encode(URL::to('/'))}}"
            >
            </category_edit-component>
        </div>

@endsection