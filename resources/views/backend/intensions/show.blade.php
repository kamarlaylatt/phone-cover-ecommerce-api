@extends('layouts.backend')
@section('title','Intension | View ')

@section('head_title','Orders')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="#" class="m-nav__link">
            <span class="m-nav__link-text">Intension</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('intensions.show', $intension->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">View</span>
        </a>
    </li>   
@endsection

@section('content')
<div class="container col-md-12">
    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4 card-title text-center mt-4 h3">Intension Detail</div>
                <div class="col-xl-4 m--align-right">
                    <a class="mt-3 btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" href="{{route('intensions.edit', $intension->id)}}"><i class="fa fa-edit"></i></a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>No</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>#{{$intension->order_no}}</strong></div>
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Ordered at</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$intension->created_at->format('d/M/Y h:i A')}}</strong></div>
                </div> 
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Status</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong><span class="badge badge-pill badge-info">{{$intension->order_status->name}}</span></strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Customer Name</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><a href="{{route('users.show', $intension->user->id)}}"><strong>{{$intension->name}}</strong></a></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Total Item</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>1</strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Total Amount</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$intension->price}}</strong></div>
                </div>
                @if($intension->remark)   
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Remark</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5"><strong>{{$intension->remark}}</strong></div>
                </div>
                @endif
                @if($intension->preview)         
                <div class="row mb-2">
                    <div class="col-sm-3 h5"><strong>Preview</strong></div>
                    <div class="col-sm-1 h5"><strong>-</strong></div>
                    <div class="col-sm-8 h5">
                        @if(is_file(\Storage::path('public/orders/images/'.$intension->preview)))
                            <img src="{{url(\Storage::url('orders/images/'.$intension->preview))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="100" height="100">
                        @else
                            <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                        @endif
                    </div>
                </div>   
                @endif
                @if($intension->intension_images->count() > 0)         
                <div class="row mb-2">
                    <div class="col-xl-2 h5"><strong>Images</strong></div>
                    <div class="col-xl-1 h5"><strong>-</strong></div>
                    <div class="col-xl-9 h5">
                        @foreach($intension->intension_images as $image)
                        @if(is_file(\Storage::path('public/orders/images/'.$image->image)))
                            <img src="{{url(\Storage::url('orders/images/'.$image->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="100" height="100">
                        @elseif(is_file(\Storage::path('public/uploads/charlet_imgs/'.$image->image)))
                            <img src="{{url(\Storage::url('uploads/charlet_imgs/'.$image->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="100" height="100">
                        @elseif(is_file(\Storage::path('public/uploads/mask_imgs/'.$image->image)))
                            <img src="{{url(\Storage::url('uploads/mask_imgs/'.$image->image))}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="100" height="100">
                        @else
                            <img src="{{asset('/images/default.png')}}" class="img-rounded img-thumbnail" alt="Cinque Terre" width="200" height="150"> 
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="row mb-2">
                    <a href="{{route('intensions.download', $intension->id)}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span>
                            <i class="fa fa-download"></i>
                            <span>Images</span>
                        </span>
                    </a>
                </div>         
            </div>        
        </div>
    </div>
</div>
@endsection