@extends('layouts.backend')
@section('title','Banner|View')

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
            <span class="m-nav__link-text">Show</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Banner Detail</div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Image </th>
                        <td> 
                            <img src="{{url(Storage::url('public/uploads/banner_imgs/'.$banner->image))}}" class="img-rounded" alt="Cinque Terre" width="200" height="150">
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
                                <span style="color:green;"><b>On</b></span>
                            @else
                                <span style="color:red;"><b>Off</b></span>
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