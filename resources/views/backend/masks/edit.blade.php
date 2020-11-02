@extends('layouts.backend')
@section('title','Mask | Edit')

@section('head_title','Mask')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('masks.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Mask</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('masks.edit', $mask->id)}}" class="m-nav__link">
            <span class="m-nav__link-text">Edit</span>
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
                            Mask Edit
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <div class="m-portlet__body">
                <!--begin::Form-->
                <form method="POST" action="{{route('masks.update',$mask->id)}}" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">
                    @csrf
                    @method('put')
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
                                <img class="img-rounded img-thumbnail" id="image_preview_container" src="{{url(\Storage::url('uploads/mask_imgs/'.$mask->image))}}"
                                    alt="preview image" style="max-height: 150px;">
                            </div>
                            <input type="file" name="image" id="image">
                        </div>
                        <div class="form-group m-form__group">
                            <label for="exampleSelect1">Select Brand</label>
                            <select name="tab_id" class="form-control m-input m-input--air">
                                @foreach($tabs as $tab)
                                    <option 
                                        @if($tab->id == $mask->tab_id)
                                        selected="selected"
                                        @endif
                                        value="{{$tab->id}}"
                                    >
                                        {{$tab->name}}
                                    </option>
                                @endforeach                        
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group">
                        <label>Sort Index</label>
                        <input type="number" name="sort_index" class="form-control m-input m-input--air" placeholder="Enter sort index" value="{{ $mask->sort_index }}"  required autocomplete="sort_index">
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{route('masks.index')}}" class="btn btn-danger">Cancel</a>
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