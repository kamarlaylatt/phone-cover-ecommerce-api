@extends('layouts.backend')
@section('title','Tab | Create')

@section('head_title','Tab')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('tabs.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Tab</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('tabs.create')}}" class="m-nav__link">
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
                            Tab Create
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <div class="m-portlet__body">
                <!--begin::Form-->
                <form method="POST" action="{{route('tabs.store')}}" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">
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
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{route('tabs.index')}}" class="btn btn-danger">Cancel</a>
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