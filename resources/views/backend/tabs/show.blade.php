@extends('layouts.backend')
@section('title','Tab | View')

@section('head_title','Phone Brands')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('tabs.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Phone Brandl</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('tabs.show', $tab->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Tab Detail</div>

            <div class="card-body">
                <table class="table table-bordered"> 
                    <tr>
                        <th> Name </th>
                        <td>                             
                            {{$tab->name}}
                        </td>
                    </tr>                   
                </table>
            </div>

        </div>
    </div>
</div>
@endsection