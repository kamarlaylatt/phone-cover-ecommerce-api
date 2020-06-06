@extends('layouts.backend')
@section('title','Shell Meterial | View')

@section('head_title','Shell Materials')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('shell_materials.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Shell Material</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('shell_materials.show', $shell_material->id)}}" class="m-nav__link">
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
                <div class="col-xl-4 card-title text-center mt-4 h3">Shell Material Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('shell_materials.edit', $shell_material->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Name </th>
                        <td>                             
                            {{$shell_material->name}}
                        </td>
                    </tr>    

                    <tr>
                        <th> Price </th>
                        <td>                             
                            {{$shell_material->price}}
                        </td>
                    </tr>

                    <tr>
                        <th> Sort No </th>
                        <td>                             
                            {{$shell_material->sort_index}}
                        </td>
                    </tr>
                    
                </table>
            </div>

        </div>
    </div>
</div>
@endsection