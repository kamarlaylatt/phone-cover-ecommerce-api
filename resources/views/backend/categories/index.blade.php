@extends('layouts.backend')
@section('title','Sample | Categories')

@section('head_title','Category')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
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
                        Category Table<small>Control all of admin accounts</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <form method="POST" action="">
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
                            </form>
                            <div class="col-md-1">
                                <a href="{{route('categories.index')}}"><button class="btn btn-danger">Show All</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="{{route('categories.create')}}" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus"></i>
                                <span>Create</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>

            <!--end: Search Form -->

            <!--begin: Datatable -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="html_table" width="100%">
                    <thead>
                        <tr>
                            <th title="Field #1" data-field="No">No</th>
                            <th title="Field #2" data-field="Name">Name</th>
                            <th title="Field #3" data-field="Email">Description</th>
                            <th title="Field #3" data-field="Role">Photo</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr>
                    		<td>1</td>
                    		<td>Category1</td>
                    		<td>Description1</td>
                    		<td>img1</td>
                    	</tr>
                    </tbody>                                     
                </table>                    
            </div>

            <!--end: Datatable -->
        </div>
        
    </div>
</div>
@endsection