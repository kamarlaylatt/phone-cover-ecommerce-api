@extends('layouts.backend')
@section('title','Phone Model|View')

@section('head_title','Phone Models')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('phone_models.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Phone Modell</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('phone_models.show', $phone_model->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Show</span>
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
                        <th> Name </th>
                        <td>                             
                            {{$phone_model->name}}
                        </td>
                    </tr>    

                    <tr>
                        <th> Image </th>
                        <td>                             
                            {{$phone_model->image}}
                        </td>
                    </tr>                    
                </table>
            </div>

        </div>
    </div>
</div>
@endsection