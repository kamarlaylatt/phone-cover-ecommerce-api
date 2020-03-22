@extends('layouts.backend')
@section('title','Admins|Password')

@section('head_title','Password')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.edit.password')}}" class="m-nav__link">
            <span class="m-nav__link-text">Password</span>
        </a>
    </li>   
@endsection


@section('content')



<!--begin::Portlet-->
<div class="container" style="max-width:800px">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Change Password
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('admins.update.password')}}" class="m-form m-form--fit m-form--label-align-right">
            @csrf
            <div class="m-portlet__body">    
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">Old Password</label>
                    <input type="password" name="password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Password">
                </div>           
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" name="password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Confirm Password">
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
</div>

    <!--end::Portlet-->

@endsection