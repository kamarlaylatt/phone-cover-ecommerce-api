@extends('layouts.backend')
@section('title','Banner | View')

@section('head_title','Banners')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('banners.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Banner</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('banners.show', $banner->id)}}" class="m-nav__link">
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
                <div class="col-xl-4 card-title text-center mt-4 h3">Banner Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('banners.edit', $banner->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Image </th>
                        <td> 
                            @if(is_file(\Storage::path('public/uploads/banner_imgs/'.$banner->image)))
                                <img src="{{url(Storage::url('public/uploads/banner_imgs/'.$banner->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">
                            @else
                                <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th> Link </th>
                        <td>                             
                            {{$banner->link}}
                        </td>
                    </tr>    
                    <tr>
                        <th> Show Status </th>
                        <td> 
                            @if($banner->show_status == 1)
                                <h5><span class="badge badge-pill badge-info">On</span></h5>
                            @else
                                <h5><span class="badge badge-pill badge-danger">Off</span></h5>
                            @endif
                        </td>
                    </tr>                     
                </table>
            </div>
            
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Language </th>
                        <th> English </th>
                    </tr>
                    <tr>
                        <th> Title </th>
                        <td> {{$banner->infos[0]->title}} </td>
                    </tr>
                    <tr>
                        <th> Subtitle </th>
                        <td> {{$banner->infos[0]->subtitle}} </td>
                    </tr>
                    <tr>
                        <th> Button Text </th>
                        <td> {{$banner->infos[0]->button_text}} </td>
                    </tr>
                </table>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Language </th>
                        <th> Myanmar </th>
                    </tr>
                    <tr>
                        <th> Title </th>
                        <td> {{$banner->infos[1]->title}} </td>
                    </tr>
                    <tr>
                        <th> Subtitle </th>
                        <td> {{$banner->infos[1]->subtitle}} </td>
                    </tr>
                    <tr>
                        <th> Button Text </th>
                        <td> {{$banner->infos[1]->button_text}} </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection