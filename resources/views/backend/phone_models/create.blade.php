@extends('layouts.backend')
@section('title','Phone Model|Create')

@section('head_title','Phone Model')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('phone_models.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Phone Model</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('phone_models.create')}}" class="m-nav__link">
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
                            Phone Model Create
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <div class="m-portlet__body">
                <!--begin::Form-->
                <form method="POST" action="{{route('phone_models.store')}}" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">
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
                            <label>Name</label>
                            <input type="text" name="name" class="form-control m-input m-input--air" placeholder="Enter name" value="{{ old('name') }}"  required autocomplete="name">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Image</label>
                            <input type="number" name="image" class="form-control m-input m-input--air" placeholder="Enter price" value="{{ old('image') }}"  required autocomplete="image">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Brand</label>
                            <input type="number" name="brand_id" class="form-control m-input m-input--air" placeholder="Enter price" value="{{ old('brand_id') }}"  required autocomplete="brand_id">
                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{route('phone_models.index')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>

            <!--end::Form-->
        </div>
    </div>

    <!--end::Portlet-->

@endsection

@section('script')
    <script>

    </script>
    
@endsection