@extends('layouts.backend')
@section('title','Categories|Create')

@section('head_title','Administrator')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.edit', $admin->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Edit</span>
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
                        Admin Edit
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('admins.update', $admin->id)}}" class="m-form m-form--fit m-form--label-align-right">
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
                    <label>Name</label>
                    <input type="text" name="name" value="{{$admin->name}}" class="form-control m-input m-input--air" placeholder="Enter name" required>
                </div>
                <div class="form-group m-form__group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{$admin->email}}" class="form-control m-input m-input--air" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                    <span class="m-form__help">We'll never share your email with anyone else.</span>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleSelect1">Select Role</label>
                    <select name="role" class="form-control m-input m-input--air">
                        <option selected value="{{$admin->role}}">{{$admin->role}}</option>
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                    </select>
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">Change Password</label>
                    <input type="password" name="password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group m-form__group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control m-input m-input--air" id="exampleInputPassword1" placeholder="Password">
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <button type="submit" class="btn btn-danger">Update</button>
                    <button type="reset" class="btn btn-priamary">Reset</button>
                    <a href="{{route('admins.index')}}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->




@endsection