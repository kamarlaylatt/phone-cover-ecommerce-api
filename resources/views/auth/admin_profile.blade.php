@extends('layouts.backend')
@section('title','Admins|Profile')

@section('head_title','My Profile')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.profile')}}" class="m-nav__link">
            <span class="m-nav__link-text">Profile</span>
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
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
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
                        My Profile
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('admins.profile.update')}}" class="m-form m-form--fit m-form--label-align-right">
            @csrf
            <div class="m-portlet__body">               
                <div class="form-group m-form__group">
                    <label>Name</label>
                    <input type="text" value="{{$admin->name}}" name="name" class="form-control m-input m-input--air" placeholder="Enter name" value="{{ old('name') }}"  required autocomplete="name">
                </div>
                <div class="form-group m-form__group">
                    <label>Email</label>
                    <input type="email" value="{{$admin->email}}" name="email" class="form-control m-input m-input--air" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required value="{{ old('email') }}" autocomplete="email">
                    <span class="m-form__help">We'll never share your email with anyone else.</span>
                </div>
                <div class="form-group m-form__group">
                    <label>Address</label>
                    <input type="text" value="{{$admin->address}}" name="address" class="form-control m-input m-input--air" placeholder="Enter name" value="{{ old('name') }}" autocomplete="name">
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleSelect1">Select Role</label>
                    <select name="role" class="form-control m-input m-input--air">
                        <option selected value="{{$admin->admin_role->id}}">{{$admin->admin_role->name}}</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach    
                    </select>
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