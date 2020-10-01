@extends('layouts.backend')
@section('title','UL | Managers')

@section('head_title','Dashboard')

@section('content')
<!--Begin::Section-->
<div class="m-portlet">
    <div class="m-portlet__body m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-12 col-xl-4">

                <!--begin:: Widgets/Stats2-1 -->
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('admins.profile')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">User Profile</h3>
                                    <span class="m-widget1__desc">User account management</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="fa fa-user"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('phone_brands.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Phone Brands</h3>
                                    <span class="m-widget1__desc">Phone Brand Lists</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-responsive"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('phone_models.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Phone Models</h3>
                                    <span class="m-widget1__desc">Phone Model Lists</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-responsive"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!--end:: Widgets/Stats2-1 -->
            </div>
            <div class="col-md-12 col-lg-12 col-xl-4">

                <!--begin:: Widgets/Stats2-2 -->
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('categories.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Category</h3>
                                    <span class="m-widget1__desc">List of categories</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-map"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('products.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Product</h3>
                                    <span class="m-widget1__desc">List of products</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-business"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('banners.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Banner</h3>
                                    <span class="m-widget1__desc">List of banners</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-web"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!--begin:: Widgets/Stats2-2 -->
            </div>
            <div class="col-md-12 col-lg-12 col-xl-4">

                <!--begin:: Widgets/Stats2-3 -->
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('recruitments.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Recruitment</h3>
                                    <span class="m-widget1__desc">List of recruitments</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-list-2"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('order_statuses.index')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Order Status</h3>
                                    <span class="m-widget1__desc">List of order statuses</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-menu-button"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="m-widget1__item">
                        <a style="color: #525672;" href="{{route('orders.filter')}}">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Filtering Orders</h3>
                                    <span class="m-widget1__desc">Filtering Orders</span>
                                </div>
                                <div class="col m--align-right">
                                    <span style="font-size: 40px" class="flaticon-users-1"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!--begin:: Widgets/Stats2-3 -->
            </div>
        </div>
    </div>
</div>

<!--End::Section-->

@endsection