@extends('layouts.backend')
@section('title','Recruitments | Create')

@section('head_title','Recruitment')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('recruitments.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Recruitment</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('recruitments.create')}}" class="m-nav__link">
            <span class="m-nav__link-text">Create</span>
        </a>
    </li>   
@endsection


@section('content')



<!--begin::Portlet-->
    <div class="container" style="max-width:800px">
        {{-- <div class="m-portlet m-portlet--tab"> --}}
            {{-- <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Recruitment Create
                        </h3>
                    </div>
                </div>
            </div> --}}
            <!--begin::Form-->
            {{-- <div class="m-portlet__body">
                <!--begin::Form-->
                <form method="POST" action="{{route('recruitments.store')}}" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">
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
                            <label>Image</label><br>
                            <div class="col-md-12 mb-2">
                                <img class="img-rounded img-thumbnail" id="image_preview_container" src="{{ asset('images/default.png') }}"
                                    alt="preview image" style="max-height: 150px;">
                            </div>
                            <input type="file" name="image" id="image">
                        </div>
                        <div class="form-group m-form__group">
                            <label>Sort Index</label>
                            <input type="number" name="sort_index" class="form-control m-input m-input--air" placeholder="Enter Sort Index" value="{{ old('sort_index') }}"  required autocomplete="sort_index">
                        </div>

                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#" data-target="#m_tabs_1_1">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#m_tabs_1_2">Myanmar</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                                <div class="form-group m-form__group">
                                    <label>Title</label>
                                    <input type="text" name="english_title" class="form-control m-input m-input--air" placeholder="Enter title" value="{{ old('english_title') }}"  required autocomplete="english_title">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>Description</label>
                                    <input type="text" name="english_description" class="form-control m-input m-input--air" placeholder="Enter Description" value="{{ old('english_description') }}"  required autocomplete="english_description">
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                                <div class="form-group m-form__group">
                                    <label>Title</label>
                                    <input type="text" name="myanmar_title" class="form-control m-input m-input--air" placeholder="Enter title" value="{{ old('myanmar_title') }}"  required autocomplete="title">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>Description</label>
                                    <input type="text" name="myanmar_description" class="form-control m-input m-input--air" placeholder="Enter Description" value="{{ old('myanmar_description') }}"  required autocomplete="myanmar_description">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{route('recruitments.index')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div> --}}

            <recruitment_create-component></recruitment_create-component>

            <!--end::Form-->
        {{-- </div> --}}
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