@extends('layouts.backend')
@section('title','Sample | users')

@section('head_title','User')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('users.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">User</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('users.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Table</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="box">

        {{-- <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
            <div class="m-alert__icon">
                <i class="flaticon-exclamation m--font-brand"></i>
            </div>
            <div class="m-alert__text">
                The Metronic Datatable component supports local or remote data source. For the local data you can pass javascript array as data source. In this example the grid fetches its data from a javascript array data source. It also defines the schema
                model of the data source. In addition to the visualization, the Datatable provides built-in support for operations over data such as sorting, filtering and paging performed in user browser(frontend).
            </div>
        </div> --}}
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            User Table<small>Control all of user accounts</small>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('users.block_search')}}">
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
                                        <a href="{{route('users.block_list')}}"class="btn btn-danger">Show All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="{{route('users.create')}}" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>Create</span>
                                    </span>
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div> -->
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
                                <th title="Field #1" data-field="No">ID</th>
                                <th title="Field #2" data-field="Name">Name</th>
                                <th title="Field #2" data-field="Name">Phone</th>
                                <th title="Field #3" data-field="Email">Email</th>
                                <th title="Field #4" data-field="Action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{ $key+ $users->firstItem() }}</td>
                                    <td>{{$user->uuid}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('users.show', $user->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('users.edit', $user->id)}}"><i class="fa fa-edit"></i></a> -->

                                        <form action="{{route('users.unblock', $user->id)}}" method="POST" style="display:inline;">
                                            @csrf                                          
                                            <button type="submit" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" onclick="return confirm('Are you sure to unblock this user?')"><i class="fa fa-arrow-up"></i>
                                            </button>
                                        </form>
                                        <form action="{{route('users.destroy', $user->id)}}" method="POST" style="display:inline;">
                                            @csrf         
                                            @method('delete')                                 
                                            <button type="submit" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                                     
                    </table>         
                    {{ $users->links() }}              
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