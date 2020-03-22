@extends('layouts.backend')
@section('title','Product|View')

@section('head_title','Products')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('products.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Product</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('products.show', $product->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Show</span>
        </a>
    </li>   
@endsection

@section('content')

<div class="container col-md-8">
    <div class="card">
        <div class="container">
            <div class="card-title text-center mt-4 h3">Product Detail</div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th> Thumbnail </th>
                        <td> 
                        @if(is_file(\Storage::path('public/uploads/product_imgs/thumbnail/'.$product->image)))
                            <img src="{{url(\Storage::url('uploads/product_imgs/thumbnail/'.$product->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">
                        @else
                            <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                        @endif
                        </td>
                    </tr>   
                    <tr>
                        <th>Images</th>
                        <td>
                            @foreach($product->images as $image)
                                @if(\Storage::exists('uploads/product_imgs/images/'.$image->image))
                                    <img src="{{$img_url}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                                @else
                                <img src="{{url(\Storage::url('uploads/product_imgs/images/'.$image->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150">                                 
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th> Code Number </th>
                        <td> 
                            {{$product->code_number}}
                        </td>
                    </tr>
                    <tr>
                        <th> Categories </th>
                        <td> 
                            @foreach($product->categories as $category)
                                {{$category->category_infos->where('language_id', 1)->first()->name}},
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th> Price </th>
                        <td> 
                            {{$product->price}}
                        </td>
                    </tr> 
                    <tr>
                        <th> Quantity </th>
                        <td> 
                            {{$product->qty}}
                        </td>
                    </tr> 
                    <tr>
                        <th> Minimum Order </th>
                        <td> 
                            {{$product->min_order}}
                        </td>
                    </tr> 
                    <tr>
                        <th> Maximum Order </th>
                        <td> 
                            {{$product->max_order}}
                        </td>
                    </tr>     
                    <tr>
                        <th> Recommend </th>
                        <td> 
                            @if($product->recommend == 0)
                                false
                            @else
                                true
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
                        <th> Name </th>
                        <td>{{$product->infos->where('language_id',1)->first()->name}}</td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td>{{$product->infos->where('language_id',1)->first()->description}}</td>
                    </tr>
                    @foreach($product->additions->where('language_id',1) as $addition)
                        <tr>
                            <th>{{$addition->key}}</th>
                            <td>{{$addition->value}}</td>
                        </tr>
                    @endforeach
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
                        <td>{{$product->infos->where('language_id',2)->first()->name}}</td>
                    </tr>
                    <tr>
                        <th> Description </th>
                        <td>{{$product->infos->where('language_id',2)->first()->description}}</td>
                    </tr>
                    @foreach($product->additions->where('language_id',2) as $addition)
                        <tr>
                            <th>{{$addition->key}}</th>
                            <td>{{$addition->value}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
    </div>
</div>
@endsection