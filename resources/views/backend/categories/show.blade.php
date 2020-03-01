@extends('layouts.backend')
@section('title','Category|View')

@section('head_title','Categories')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('categories.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('categories.show', $category->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Show</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Category Detail</div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Image </th>
                        <td> 
                            @if(\Storage::exists('uploads/category_imgs/'.$category->image))
                                <img src="{{$img_url}}" class="img-rounded" alt="Cinque Terre" width="200" height="150"> 
                            @else
                            <img src="{{asset('/images/default.png')}}" class="img-rounded" alt="Cinque Terre" width="200" height="150"> 
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th> Path </th>
                        <td> 
                            @if($category->parents != 0)
                                @include('backend.categories.nested_parent', ['category' => $category->parent])
                            @endif
                            {{$category->category_infos[0]->name}}
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
                        <th> Name </th>
                        <td> {{$category->category_infos[0]->name}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {{$category->category_infos[0]->description}} </td>
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
                        <th> Name </th>
                        <td> {{$category->category_infos[1]->name}} </td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td> {{$category->category_infos[1]->description}} </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection