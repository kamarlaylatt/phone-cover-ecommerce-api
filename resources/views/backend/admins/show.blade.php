@extends('layouts.backend')
@section('title','Manager | Show')

@section('head_title','Manager')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Manager</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.show', $admin->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4 card-title text-center mt-4 h3">Manager Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('admins.edit', $admin->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Title </th>
                        <td> {{$admin->name}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {{$admin->email}} </td>
                    </tr>
                    <tr>
                        <th> Role </th>
                        <td> {{$admin->admin_role->name}} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection