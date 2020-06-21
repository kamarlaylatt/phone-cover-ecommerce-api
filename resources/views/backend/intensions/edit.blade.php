@extends('layouts.backend')
@section('title','Intension | Edit')

@section('head_title','Intension')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="#" class="m-nav__link">
            <span class="m-nav__link-text">Intension</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('intensions.edit', $intension->id)}}" class="m-nav__link">
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
                            Intension Edit
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <div class="m-portlet__body">
                <!--begin::Form-->
                <form method="POST" action="{{route('intensions.update',$intension->id)}}" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">
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
                            <label for="exampleSelect1">Intension Status</label>
                            <select name="order_status_id" class="form-control m-input m-input--air">
                                @foreach($order_statuses as $order_status)
                                    <option 
                                        @if($order_status->id == $intension->order_status_id)
                                        selected="selected"
                                        @endif
                                        value="{{$order_status->id}}"
                                    >
                                        {{$order_status->name}}
                                    </option>
                                @endforeach                        
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="comment">Remark</label>
                            <textarea name="remark" class="form-control m-input m-input--air" rows="5" id="comment"> {{$intension->remark}}</textarea>
                        </div>                        
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
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

        $('#frame').change(function(){
            
            let reader = new FileReader();
            reader.onload = (e) => { 
                $('#frame_preview_container').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
    
        });
    </script>
@endsection