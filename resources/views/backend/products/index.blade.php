@extends('layouts.backend')
@section('title','Sample | Products')

@section('head_title','Product')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('products.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Product</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('products.index')}}" class="m-nav__link">
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
                            Product Table
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('products.search')}}">
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
                                        <a href="{{route('products.index')}}"class="btn btn-danger">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="{{route('products.create')}}" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
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
                                <th title="Field #4" data-field="Role">Image</th>
                                <th title="Field #2" data-field="Name">Name</th>
                                <th title="Field #3" data-field="Email">Price</th>
                                <th title="Field #3" data-field="Role">Code No</th>
                                <th title="Field #5" data-field="Action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($products->count() < 1)
                                <td colspan=6 class="text-center">
                                    There is no product
                                </td>
                            @endif
                            @foreach($products as $key=>$product)
                                <tr>
                                    <td>{{ $key+ $products->firstItem() }}</td>
                                    <td>
                                        @if(is_file(\Storage::path('public/uploads/product_imgs/thumbnail/'.$product->image)))
                                            <img src="{{url(\Storage::url('uploads/product_imgs/thumbnail/'.$product->image))}}" class="img-rounded" alt="Cinque Terre" width="60" height="60">
                                        @else
                                            <img src="{{asset('/images/default.png')}}" class="img-rounded" alt="Cinque Terre" width="60" height="60"> 
                                        @endif
                                    </td>
                                    <td>{{$product->infos->where('language_id',1)->first()->name}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->code_number}}</td>                                    
                                    <td>
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('products.show', $product->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('products.edit', $product->id)}}"><i class="fa fa-edit"></i></a>

                                        <form action="{{route('products.destroy', $product->id)}}" method="POST" style="display:inline;">
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
                    {{ $products->links() }}               
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