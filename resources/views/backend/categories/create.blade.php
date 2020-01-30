@extends('layouts.backend')
@section('title','Sample | Categories')

@section('head_title','Category')

@section('breadcrumbs')
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Category</span>
        </a>
    </li>
    <li class="m-nav__separator">-</li>
    <li class="m-nav__item">
        <a href="{{route('admins.index')}}" class="m-nav__link">
            <span class="m-nav__link-text">Create</span>
        </a>
    </li>   
@endsection

@section('content')
    <div class="box">
        <div class="m-portlet m-portlet--full-height">

            <!--begin: Portlet Head-->
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Category Create
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" data-toggle="m-tooltip" class="m-portlet__nav-link m-portlet__nav-link--icon" data-direction="left" data-width="auto" title="Get help with filling up this form">
                                <i class="flaticon-info m--icon-font-size-lg3"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--end: Portlet Head-->

            <!--begin: Portlet Body-->
            <div class="m-portlet__body m-portlet__body--no-padding">

                <!--begin: Form Wizard-->
                <div class="m-wizard m-wizard--4 m-wizard--brand" id="m_wizard">
                    <div class="row m-row--no-padding">
                        <div class="col-xl-3 col-lg-12 m--padding-top-20 m--padding-bottom-15">

                            <!--begin: Form Wizard Head -->
                            <div class="m-wizard__head">

                                <!--begin: Form Wizard Nav -->
                                <div class="m-wizard__nav">
                                    <tree-component :categories="{{ json_encode($category_array) }}"></tree-component>
                                </div>
                                

                                <!--end: Form Wizard Nav -->
                            </div>

                            <!--end: Form Wizard Head -->
                        </div>
                        <div class="col-xl-9 col-lg-12">

                            <!--begin: Form Wizard Form-->
                            <div class="m-wizard__form">

                                <!--
            1) Use m-form--label-align-left class to alight the form input lables to the right
            2) Use m-form--state class to highlight input control borders on form validation
        -->
                            <div>
                                    <tree_edit-component :categories="{{ json_encode($category_array) }}"></tree_edit-component>
                                </div>
                                
                            </div>

                            <!--end: Form Wizard Form-->
                        </div>
                    </div>
                </div>

                <!--end: Form Wizard-->
            </div>

            <!--end: Portlet Body-->
        </div>       
    </div>
@endsection