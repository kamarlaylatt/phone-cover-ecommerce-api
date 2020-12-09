@extends('layouts.backend')
@section('title','Township | Create')

@section('head_title','Township')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('townships.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Township</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('townships.create')}}" class="m-nav__link">
            <span class="m-nav__link-text">Create</span>
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
                    Township Create
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('townships.store')}}" class="m-form m-form--fit m-form--label-align-right">
            @csrf
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
                    <input type="text" name="english_name" class="form-control m-input m-input--air" placeholder="Enter english name" value="{{ old('english_name') }}"  required autocomplete="english_name">
                </div>
                <div class="form-group m-form__group">
                    <label>Myanmar Name</label>
                    <input type="text" name="myanmar_name" class="form-control m-input m-input--air" placeholder="Enter myanmar name" value="{{ old('myanmar_name') }}"  required autocomplete="myanmar_name">
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleSelect1">Select Region</label>
                    <select name="region_id" class="form-control m-input m-input--air">
                        @foreach($regions as $region)
                            <option value="{{$region->id}}">{{$region->region_infos->where('language_id',1)->first()->name}}</option>
                        @endforeach                        
                    </select>
                </div>
                <div class="form-group m-form__group">
                    <label>Delivery Price</label>
                    <input type="number" name="delivery_price" class="form-control m-input m-input--air" placeholder="Enter Delivery Price" value="{{ old('delivery_price') }}"  required autocomplete="delivery_price">
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{route('townships.index')}}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
</div>

    <!--end::Portlet-->

@endsection