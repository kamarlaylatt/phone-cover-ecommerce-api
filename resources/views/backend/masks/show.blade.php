@extends('layouts.backend')
@section('title','Mask | View')

@section('head_title','Charlets')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('masks.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Mask</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('masks.show', $mask->id)}}" class="m-nav__link">
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
                <div class="col-xl-4 card-title text-center mt-4 h3">Mask Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('masks.edit', $mask->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Image </th>
                        <td>                             
                            @if(is_file(\Storage::path('public/uploads/mask_imgs/'.$mask->image)))
                                <img src="{{url(Storage::url('public/uploads/mask_imgs/'.$mask->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">
                            @else
                                <img src="{{asset('images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">                                           
                            @endif
                        </td>
                    </tr> 
                    <tr>
                        <th> Tab </th>
                        <td>                             
                            {{$mask->tab->name}}
                        </td>
                    </tr> 
                                       
                </table>
            </div>

        </div>
    </div>
</div>
@endsection