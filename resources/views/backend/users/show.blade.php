@extends('layouts.backend')
@section('title','User|View')

@section('head_title','User')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('users.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">User</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('users.show', $user->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Show</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">User Detail</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Name </th>
                        <td> {{$user->name}} </td>
                    </tr>
                    <tr>
                        <th> Email </th>
                        <td> {{$user->email}} </td>
                    </tr>
                    <tr>
                        <th> Phone </th>
                        <td> {{$user->phone}} </td>
                    </tr>
                    <tr>
                        <th> Address </th>
                        <td> {{$user->address}} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection