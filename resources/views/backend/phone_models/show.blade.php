@extends('layouts.backend')
@section('title','Phone Model | View')

@section('head_title','Phone Models')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('phone_models.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Phone Model</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('phone_models.show', $phone_model->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Phone Model Detail</div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Image </th>
                        <td>                             
                            @if(is_file(\Storage::path('public/uploads/phone_model_imgs/'.$phone_model->image)))
                                <img src="{{url(Storage::url('public/uploads/phone_model_imgs/'.$phone_model->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">
                            @else
                                <img src="{{asset('images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">                                           
                            @endif
                        </td>
                    </tr> 
                    <tr>
                        <th> Name </th>
                        <td>                             
                            {{$phone_model->name}}
                        </td>
                    </tr>    
                    <tr>
                        <th> Brand </th>
                        <td>                             
                            {{$phone_model->phone_brand->name}}
                        </td>
                    </tr> 
                                       
                </table>
            </div>

        </div>
    </div>
</div>
@endsection