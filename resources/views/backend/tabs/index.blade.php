@extends('layouts.backend')
@section('title','UL | Tab')

@section('head_title','Tab')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('tabs.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Tab</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('tabs.index')}}" class="m-nav__link">
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
                        Tab Table
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('tabs.search')}}">
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
                                    <div class="col-md-1 mr-1">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{route('tabs.index')}}"class="btn btn-primary">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="{{route('tabs.create')}}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
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
                            <tr class="table-font">
                                <th title="Field #1" data-field="No">No</th>
                                <th> Name </th>
                                <th class="text-center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tabs->count() < 1)
                                <td colspan=6 class="text-center">
                                    There is no tabs
                                </td>
                            @endif
                            @foreach($tabs as $key=>$tab)
                                <tr>
                                    <td class="align-middle">{{ $key+ $tabs->firstItem() }}</td>
                                    <td class="align-middle">{{$tab->name}}</td>                         
                                    <td class="text-center align-middle">
                                        {{-- <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('tabs.show', $tab->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a> --}}

                                        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('tabs.edit', $tab->id)}}"><i class="fa fa-edit"></i></a>

                                        <form action="{{route('tabs.destroy', $tab->id)}}" method="POST" style="display:inline;">
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
                    {{ $tabs->links() }}
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