@extends('layouts.backend')
@section('title','Region | Edit')

@section('head_title','Region')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('regions.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Region</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('regions.edit', $region->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Edit</span>
        </a>
    </li>   
@endsection

@section('content')



<!--begin::Portlet-->
<div class="container" style="max-width:800px">
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                    Region Edit
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('regions.update', $region->id)}}" class="m-form m-form--fit m-form--label-align-right">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                @if ($errors->any())
                    <div class="form-group m-form__group m--margin-top-10">   
                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                        </div>
                    </div>
                @endif
                <div class="form-group m-form__group">
                    <label>English Name</label>
                    <input type="text" name="english_name" value="{{$region->region_infos->where('language_id',1)->first()->name}}" class="form-control m-input m-input--air" placeholder="Enter name" required>
                </div>
                <div class="form-group m-form__group">
                    <label>Myanmar Name</label>
                    <input type="text" name="myanmar_name" value="{{$region->region_infos->where('language_id',2)->first()->name}}" class="form-control m-input m-input--air" placeholder="Enter name" required>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                    <a href="{{route('regions.index')}}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>

    <!--end::Portlet-->
@endsection