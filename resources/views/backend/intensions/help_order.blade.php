@extends('layouts.backend')
@section('title','UL | Help Me Design Orders')

@section('head_title','Help Me Design')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('intensions.help')}}" class="m-nav__link">
            <span class="m-nav__link-text">Help Me Design</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('intensions.help')}}" class="m-nav__link">
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
                        Help Me Design Orders Table
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('intensions.help.search')}}">
                        <div class="row align-items-center">
                            <div class="col-xl-8 intension-2 intension-xl-1">
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
                                    <div class="col-md-1 mr-1">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{route('intensions.help')}}"class="btn btn-primary">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            {{-- <div class="col-xl-4 intension-1 intension-xl-2 m--align-right">
                                <a href="" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>Create</span>
                                    </span>
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div> --}}
                        </div>
                    </form>
                </div>

                <!--end: Search Form -->

                <!--begin: Datatable -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="html_table" width="100%">
                       <thead>
                            <tr class="table-font">
                                <th title="Field #1" data-field="No">No</th>
                                <th title="Field #2" data-field="Name">Order No</th>
                                <th title="Field #3" data-field="Email">Customer Name</th>
                                <th title="Field #3" data-field="Role">Phone No</th>
                                <th title="Field #3" data-field="Role">Order Status</th>
                                <th title="Field #4" data-field="Action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($intensions as $key=>$intension)
                                <tr>
                                    <td>{{ $key+ $intensions->firstItem() }}</td>
                                    <td>{{$intension->order_no}}</td>
                                    <td>{{$intension->name}}</td>
                                    <td>{{$intension->phone}}</td>
                                    <td class="text-center"><h5><span class="badge badge-pill badge-info">{{$intension->order_status->name}}</span></h5></td>
                                    <td>
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('intensions.show', $intension->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('intensions.edit', $intension->id)}}"><i class="fa fa-edit"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody> 
                    </table>         
                    {{ $intensions->links() }}     
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