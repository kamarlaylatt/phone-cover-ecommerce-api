@extends('layouts.backend')
@section('title','Users|Create')

@section('head_title','User')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('users.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('users.index')}}" class="m-nav__link">
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
                        User Create
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('users.store')}}" class="m-form m-form--fit m-form--label-align-right">
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
                    <label>Email</label>
                    <input type="email" name="email" class="form-control m-input m-input--air" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required value="{{ old('email') }}" autocomplete="email">
                    <span class="m-form__help">We'll never share your email with anyone else.</span>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Confirm Password">
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <button type="submit" class="btn btn-danger">Create</button>
                    <a href="{{route('users.index')}}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->

@endsection