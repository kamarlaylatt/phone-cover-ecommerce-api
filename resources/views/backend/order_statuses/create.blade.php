@extends('layouts.backend')
@section('title','Order Status | Create')

@section('head_title','Order Status')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('order_statuses.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Order Status</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('order_statuses.create')}}" class="m-nav__link">
            <span class="m-nav__link-text">Create</span>
        </a>
    </li>   
@endsection


@section('content')



<!--begin::Portlet-->
    <div class="container" style="max-width:800px">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Order Status Create
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <div class="m-portlet__body">
                <!--begin::Form-->
                <form method="POST" action="{{route('order_statuses.store')}}" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">
                    @csrf
                    <div class="m-portlet__body">
                        @if ($errors->any())
                            <div class="form-group m-form__group m--margin-top-10">   
                                <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                </div>  
                            </div>
                        @endif
                        <div class="form-group m-form__group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control m-input m-input--air" placeholder="Enter name" value="{{ old('name') }}"  required autocomplete="name">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Sort Index</label>
                            <input type="number" name="sort_index" class="form-control m-input m-input--air" placeholder="Enter sort index" value="{{ old('name') }}"  required autocomplete="sort_index">
                        </div>
                        <div class="form-group m-form__group">
                            <label for="comment">Description</label>
                            <textarea name="description" class="form-control m-input m-input--air" rows="5" id="comment"></textarea>
                        </div>
                        <div class="form-group m-form__group">
                            <label>Color</label>
                            <input type="color" name="color" class="col-lg-2 form-control m-input m-input--air" placeholder="Enter color code" value="{{ old('color') }}"  required autocomplete="text_color">
                        </div>
                        {{-- <div class="form-group m-form__group">
                            <label>Icon</label><br>
                            <div class="col-md-12 mb-2">
                                <img class="img-rounded img-thumbnail" id="image_preview_container" src="{{ asset('images/default.png') }}"
                                    alt="preview image" style="max-height: 150px;">
                            </div>
                            <input type="file" name="icon" id="image">
                        </div> --}}
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{route('order_statuses.index')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>

            <!--end::Form-->
        </div>
    </div>

    <!--end::Portlet-->

@endsection

@section('script')
    <script>
        $('#image').change(function(){
            
            let reader = new FileReader();
            reader.onload = (e) => { 
                $('#image_preview_container').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
    
        });
    </script>
    
@endsection