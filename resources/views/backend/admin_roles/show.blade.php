@extends('layouts.backend')
@section('title','Manager | View')

@section('head_title','Manager Role')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admin_roles.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Manager Role</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admin_roles.show', $admin_role->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Manager Role Detail</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Title </th>
                        <td> {{$admin_role->name}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {{$admin_role->description}} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection