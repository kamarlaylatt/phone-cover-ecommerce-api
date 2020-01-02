@extends('layouts.backend')
@section('title','Admin Role|Edit')

@section('head_title','Admin Role')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admin_roles.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin Role</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admin_roles.edit', $admin_role->id)}}" class="m-nav__link">
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
                        Admin Role Edit
                    </h3>
                </div>
            </div>
        </div>

        

        <!--begin::Form-->
        <form method="POST" action="{{route('admin_roles.update', $admin_role->id)}}" class="m-form m-form--fit m-form--label-align-right">
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
                    <input type="text" name="name" value="{{$admin_role->name}}" class="form-control m-input m-input--air" placeholder="Enter name" required>
                </div>
                <div class="form-group m-form__group">
                    <label>Description</label>
                    <input type="text" name="description" value="{{$admin_role->description}}" class="form-control m-input m-input--air" placeholder="Enter name" required>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <button type="submit" class="btn btn-danger">Update</button>
                    <button type="reset" class="btn btn-priamary">Reset</button>
                    <a href="{{route('admin_roles.index')}}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->




@endsection