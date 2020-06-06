@extends('layouts.backend')
@section('title','Recruitment | View')

@section('head_title','Recruitments')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('recruitments.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Recruitment</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('recruitments.show', $recruitment->id)}}" class="m-nav__link">
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
                <div class="col-xl-4 card-title text-center mt-4 h3">Recruitment Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('recruitments.edit', $recruitment->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Image </th>
                        <td> 
                            @if(is_file(\Storage::path('public/uploads/recruitment_imgs/'.$recruitment->image)))
                                <img src="{{url(Storage::url('public/uploads/recruitment_imgs/'.$recruitment->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">
                            @else
                                <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th> Sort Index </th>
                        <td>                             
                            {{$recruitment->sort_index}}
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
                        <td> {{$recruitment->infos[0]->title}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {!!$recruitment->infos[0]->description!!} </td>
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
                        <td> {{$recruitment->infos[1]->title}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {!!$recruitment->infos[1]->description!!} </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection