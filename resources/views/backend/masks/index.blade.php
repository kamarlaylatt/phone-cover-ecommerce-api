@extends('layouts.backend')
@section('title','UL | Mask')

@section('head_title','Mask')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('masks.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Mask</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('masks.index')}}" class="m-nav__link">
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
                        Mask Table
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('masks.search')}}">
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
                                        <a href="{{route('masks.index')}}"class="btn btn-primary">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="{{route('masks.create')}}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
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
                                <th class="text-center align-middle"> Image </th>
                                <th> Tab </th>
                                <th class="text-center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($masks->count() < 1)
                                <td colspan=6 class="text-center">
                                    There is no masks
                                </td>
                            @endif
                            @foreach($masks as $key=>$mask)
                                <tr>
                                    <td class="align-middle">{{ $key+ $masks->firstItem() }}</td>
                                    <td class="text-center align-middle">
                                        @if(is_file(\Storage::path('public/uploads/mask_imgs/'.$mask->image)))
                                            <img src="{{url(Storage::url('public/uploads/mask_imgs/'.$mask->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="60" height="60">
                                        @else
                                            <img src="{{asset('images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="60" height="60">                                           
                                        @endif
                                    </td>
                                    <td class="align-middle">{{$mask->tab->name}}</td>                      
                                    <td class="text-center align-middle">
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('masks.show', $mask->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('masks.edit', $mask->id)}}"><i class="fa fa-edit"></i></a>

                                        <form action="{{route('masks.destroy', $mask->id)}}" method="POST" style="display:inline;">
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
                    {{ $masks->links() }}
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