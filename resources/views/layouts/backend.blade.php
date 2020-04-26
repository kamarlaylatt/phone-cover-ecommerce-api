<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>@yield('title')</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="{{asset('backend_asset/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('backend_asset/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="{{asset('images/shortcut_icon.png')}}" />

		<link href=" {{ mix('css/app.css') }}" rel="stylesheet">
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div id='app'>
			<!-- begin:: Page -->
			<div class="m-grid m-grid--hor m-grid--root m-page">

				<!-- BEGIN: Header -->
				<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
					<div class="m-container m-container--fluid m-container--full-height">
						<div class="m-stack m-stack--ver m-stack--desktop">

							<!-- BEGIN: Brand -->
							<div class="m-stack__item m-brand  m-brand--skin-dark ">
								<div class="m-stack m-stack--ver m-stack--general">
									<div class="m-stack__item m-stack__item--middle m-brand__logo">
										<a href="{{url('/')}}" class="m-brand__logo-wrapper">
		  									<!-- <span class="h2" style="color: #7b7e9b;"><strong>Universitylife</strong></span> -->
											<!-- <img alt="" src="{{asset('backend_asset/demo/default/media/img/logo/logo_default_dark.png')}}" /> -->
											<img width="160" alt="" src="{{asset('images/universitylife_logo.png')}}" />

										</a>
									</div>
									<div class="m-stack__item m-stack__item--middle m-brand__tools">

										<!-- BEGIN: Left Aside Minimize Toggle -->
										<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
											<span></span>
										</a>

										<!-- END -->

										<!-- BEGIN: Responsive Aside Left Menu Toggler -->
										<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>

										<!-- END -->

										<!-- BEGIN: Responsive Header Menu Toggler -->
										<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>

										<!-- END -->

										<!-- BEGIN: Topbar Toggler -->
										<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
											<i class="flaticon-more"></i>
										</a>

										<!-- BEGIN: Topbar Toggler -->
									</div>
								</div>
							</div>

							<!-- END: Brand -->
							<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">


								<!-- BEGIN: Topbar -->
								<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
									<div class="m-stack__item m-topbar__nav-wrapper">
										<ul class="m-topbar__nav m-nav m-nav--inline">
											<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
											 m-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-topbar__userpic">
														<img src="{{asset('images/manager.png')}}" class="m--img-rounded m--marginless" alt="" />
													</span>
													<span class="m-topbar__username m--hide">Nick</span>
												</a>
												<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center" style="background: url(../../assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
															<div class="m-card-user m-card-user--skin-dark">
																<div class="m-card-user__pic">
																	<img src="{{asset('images/manager.png')}}" class="m--img-rounded m--marginless" alt="" />

																	<!--
							<span class="m-type m-type--lg m--bg-danger"><span class="m--font-light">S<span><span>
							-->
																</div>
																<div class="m-card-user__details">
																	<span class="m-card-user__name m--font-weight-500">{{Auth::user()->name}}</span>
																	<a href="" class="m-card-user__email m--font-weight-300 m-link">{{Auth::user()->email}}</a>
																</div>
															</div>
														</div>
														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="m-nav m-nav--skin-light">
																	<li class="m-nav__section m--hide">
																		<span class="m-nav__section-text">Section</span>
																	</li>
																	<li class="m-nav__item">
																		<a href="{{route('admins.profile')}}" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-profile-1"></i>
																			<span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">My Profile</span>
																					<!-- <span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span> -->
																				</span>
																			</span>
																		</a>
																	</li>
																	<li class="m-nav__item">
																		<a href="{{route('admins.edit.password')}}" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-safe-shield-protection"></i>
																			<span class="m-nav__link-text">Change Password</span>
																		</a>
																	</li>
																	<!-- <li class="m-nav__item">
																		<a href="../../header/profile.html" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-chat-1"></i>
																			<span class="m-nav__link-text">Messages</span>
																		</a>
																	</li>
																	<li class="m-nav__separator m-nav__separator--fit">
																	</li>
																	<li class="m-nav__item">
																		<a href="../../header/profile.html" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-info"></i>
																			<span class="m-nav__link-text">FAQ</span>
																		</a>
																	</li>
																	<li class="m-nav__item">
																		<a href="../../header/profile.html" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																			<span class="m-nav__link-text">Support</span>
																		</a>
																	</li> -->
																	<li class="m-nav__separator m-nav__separator--fit">
																	</li>
																	<li onclick="return confirm('Are you sure to logout?')" class="m-nav__item">
																		<a href="{{route('admin.logout')}}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>

								<!-- END: Topbar -->
							</div>
						</div>
					</div>
				</header>

				<!-- END: Header -->

				<!-- begin::Body -->
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

					<!-- BEGIN: Left Aside -->
					<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
					<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

						@include('layouts.backendmenulist')
					</div>

					<!-- END: Left Aside -->
					<div class="m-grid__item m-grid__item--fluid m-wrapper">

						<!-- BEGIN: Subheader -->
						<div class="m-subheader ">
							<div class="d-flex align-items-center">
								<div class="mr-auto">
									<h3 class="m-subheader__title m-subheader__title--separator">@yield('head_title')</h3>
									<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
										@yield('breadcrumbs')
									</ul>
								</div>
							</div>
						</div>

						<!-- END: Subheader -->
						<div class="m-content">
							@yield('content')
						</div>
					</div>
				</div>

				<!-- end:: Body -->

				<!-- begin::Footer -->
				<footer class="m-grid__item		m-footer ">
					<div class="m-container m-container--fluid m-container--full-height m-page__container">
						<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
							<div class="m-stack__item m-stack__item--center m-stack__item--middle m-stack__item--last">
								<span class="m-footer__copyright">
									2020 &copy; Universitylife Dashboard 
									<!-- <a href="https://keenthemes.com" class="m-link">Sample</a> -->
								</span>
							</div>
							{{-- <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
								<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">About</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">Privacy</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">T&C</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="#" class="m-nav__link">
											<span class="m-nav__link-text">Purchase</span>
										</a>
									</li>
									<li class="m-nav__item m-nav__item">
										<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
											<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
										</a>
									</li>
								</ul>
							</div> --}}
						</div>
					</div>
				</footer>

				<!-- end::Footer -->
			</div>

			<!-- end:: Page -->

			<!-- begin::Scroll Top -->
			<div id="m_scroll_top" class="m-scroll-top">
				<i class="la la-arrow-up"></i>
			</div>

			<!-- end::Scroll Top -->


			<!-- begin::Quick Nav -->

			<!--begin::Global Theme Bundle -->
			<script src="{{asset('backend_asset/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
			<script src="{{asset('backend_asset/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
			<!-- <script src="{{asset('backend_asset/demo/default/custom/crud/forms/widgets/summernote.js')}}" type="text/javascript"></script> -->
			

			<!--end::Global Theme Bundle -->
		</div>
		<script src="{{ mix('js/app.js') }}"></script>
	</body>

	@yield('script')

	<!-- end::Body -->
</html>