@extends('layouts.backend')
@section('title','UL | Recruitments')

@section('head_title','Recruitment')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('recruitments.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Recruitment</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('recruitments.index')}}" class="m-nav__link">
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
                        Recruitment Table
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <form method="POST" action="{{route('recruitments.search')}}">
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
                                        <a href="{{route('recruitments.index')}}"class="btn btn-primary">Show All</a>
                                    </div>                                                                        
                                </div>
                            </div>
                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <a href="{{route('recruitments.create')}}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
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
                                <th class="text-center"> Image </th>
                                <th> Title </th>
                                <th> Description </th>
                                <th class="text-center"> Sort Index </th>
                                <th class="text-center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($recruitments->count() < 1)
                                <td colspan=6 class="text-center">
                                    There is no recruitment
                                </td>
                            @endif
                            @foreach($recruitments as $key=>$recruitment)
                                <tr>
                                    <td class="align-middle">{{ $key+ $recruitments->firstItem() }}</td>
                                    <td class="text-center align-middle">
                                        @if(is_file(\Storage::path('public/uploads/recruitment_imgs/'.$recruitment->image)))
                                            <img src="{{url(Storage::url('public/uploads/recruitment_imgs/'.$recruitment->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="60" height="60">
                                        @else
                                            <img src="{{asset('images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="60" height="60">                                           
                                        @endif
                                    </td>
                                    <td class="align-middle">{{$recruitment->infos[0]->title}}</td>
                                    <td class="align-middle">
                                        {!! Str::limit(strip_tags($recruitment->infos[0]->description),100) !!}
                                    </td>
                                    <td class="align-middle text-center">{{$recruitment->sort_index}}</td>                              
                                    <td class="text-center align-middle">
                                        <a class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('recruitments.show', $recruitment->id)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('recruitments.edit', $recruitment->id)}}"><i class="fa fa-edit"></i></a>

                                        <form action="{{route('recruitments.destroy', $recruitment->id)}}" method="POST" style="display:inline;">
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
                    {{ $recruitments->links() }}
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