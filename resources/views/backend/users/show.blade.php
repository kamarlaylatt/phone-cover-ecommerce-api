@extends('layouts.backend')
@section('title','User | View')

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
                <div class="col-xl-4 card-title text-center mt-4 h3">User Detail</div>
                {{-- <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('users.edit', $user->id)}}"><i class="fa fa-edit"></i></a>
                </div> --}}
            </div>
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
                    @if($user->provider_id)
                     @php
                         $facebook_url = "https://www.facebook.com/".$user->provider_id;
                     @endphp
                    <tr>
                        <th> Facebook </th>
                        <td> <a href="{{$facebook_url}}" class="fa fa-facebook">Facebook</a></td>
                    </tr>
                    @endif
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