@extends('layouts.backend')
@section('title','Sample | Categories')

@section('head_title','Category')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
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
                            Admin Table<small>Control all of admin accounts</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div>
                    <tree-component></tree-component>
                </div>
            </div>
        </div>        
    </div>
@endsection