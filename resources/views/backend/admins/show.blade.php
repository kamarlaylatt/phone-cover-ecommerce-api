@extends('layouts.backend')
@section('title','Category|View')

@section('head_title','Administrator')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Admin</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.show', $admin->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Show</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Admin Detail</div>
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
                </table>
            </div>
        </div>
    </div>
</div>
@endsection