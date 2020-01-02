@extends('layouts.backend')
@section('title','Category|View')

@section('head_title','User')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('users.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">user</span>
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
            <div class="card-title text-center mt-4 h3">user Detail</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Title </th>
                        <td> {{$user->name}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {{$user->email}} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection