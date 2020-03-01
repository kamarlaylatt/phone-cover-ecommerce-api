@extends('layouts.backend')
@section('title','Sample | Banners')

@section('head_title','Banner')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('banners.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Banner</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('banners.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Table</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="box">

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                        Banner Table
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('banners.search')}}">
                        <div class="row align-items-center">
                            <div class="col-xl-8 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-4">                                    
                                            @csrf
                                            <div class="m-input-icon m-input-icon--left">
                                                <input type="text" name="search" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch" required>
                                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>                                           
                                            </div>                                        
                                        
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-danger">Search</button>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{route('banners.index')}}"class="btn btn-danger">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="{{route('banners.create')}}" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>Create</span>
                                    </span>
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--end: Search Form -->

                <!--begin: Datatable -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="html_table" width="100%">
                        <thead>
                            <tr>
                                <th title="Field #1" data-field="No">No</th>
                                <th> Title </th>
                                <th> Sub Title </th>
                                <th> Button Text </th>
                                <th> Show Status </th>
                                <th> Image </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($banners->count() < 1)
                                <td colspan=6 class="text-center">
                                    There is no banner
                                </td>
                            @endif
                            @foreach($banners as $key=>$banner)
                                <tr>
                                    <td>{{ $key+ $banners->firstItem() }}</td>
                                    <td>{{$banner->infos[0]->title}}</td>
                                    <td>{{$banner->infos[0]->subtitle}}</td>
                                    <td>{{$banner->infos[0]->button_text}}</td>
                                    <td class="text-center">
                                        @if($banner->show_status == 1)
                                            <span style="color:green;"><b>On</b></span>
                                        @else
                                            <span style="color:red;"><b>Off</b></span>
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('banners.show', $banner->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('banners.edit', $banner->id)}}"><i class="fa fa-edit"></i></a>

                                        <form action="{{route('banners.destroy', $banner->id)}}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')                                            
                                            <button type="submit" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" onclick="return confirm('Are you sure to delete it?')"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                                     
                    </table>         
                    {{ $banners->links() }}
                </div>

                <!--end: Datatable -->
            </div>
            
        </div>
</div>
@endsection

@section('head')
    <style>
        .col-width{
            text-align: center;
            width: 50px;
        }

        th{
            text-align: center;
        }

        td{
            text-align: center;
        }
    </style>
@endsection