<!-- BEGIN: Aside Menu -->

	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__item {{ request()->is('admin/dashboard')? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('admins.dashboard')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Dashboard</span>
							<span class="m-menu__link-badge">
								{{-- <span class="m-badge m-badge--danger">2</span> --}}
							</span> </span></span></a></li>
			
			<!-- user admin management -->
			@if(Auth::user()->admin_role_id == 1)
				<li class="m-menu__section ">
					<h4 class="m-menu__section-text">Adminstration</h4>
					<i class="m-menu__section-icon flaticon-more-v2"></i>
				</li>

				<li style="margin-top: -5px" class="m-menu__item {{ request()->is('admin/admins') || request()->is('admin/admins/*') || request()->is('admin/admin_roles') || request()->is('admin/admin_roles/*') || request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/block_list') || request()->is('admin/block_list/*') ? 'm-menu__item--open m-menu__item--active':''}} m-menu__item--submenu" 
					aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">User Management</span><i
						class="m-menu__ver-arrow la la-angle-right" style="color: white"></i></a>
					<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
						<ul class="m-menu__subnav">
							<li class="m-menu__item {{ request()->is('admin/admins') ||  request()->is('admin/admins/*')? 'm-menu__item--active' : '' }}  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('admins.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-businesswoman"></i><span class="m-menu__link-text">Managers</span></a>
							</li>
							<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/admin_roles') ||  request()->is('admin/admin_roles/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('admin_roles.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-text">Roles</span></a>
							</li>
							<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/users') ||  request()->is('admin/users/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('users.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">Users</span></a>
							</li>
							<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/block_list') ||  request()->is('admin/block_list/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('users.block_list')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-cancel"></i><span class="m-menu__link-text">Block List</span></a>
							</li>
						</ul>
					</div>
				</li>
			@endif

			<li class="m-menu__section " style="margin-top: -5px">
				<h4 class="m-menu__section-text">Location</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>

			<!-- Location -->
			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/regions') ||  request()->is('admin/regions/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('regions.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-paper-plane-1"></i><span class="m-menu__link-text">Region</span></a>
			</li>

			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/townships') ||  request()->is('admin/townships/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('townships.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-placeholder"></i><span class="m-menu__link-text">Township</span></a>
			</li>
			

			<li class="m-menu__section " style="margin-top: -5px">
				<h4 class="m-menu__section-text">DIY Related</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>

			<!-- Phone Brand & Model -->
			<li style="margin-top: -5px" class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/phone_brands') ||  request()->is('admin/phone_brands/*') || request()->is('admin/phone_models') ||  request()->is('admin/phone_models/*')? 'm-menu__item--open m-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-responsive"></i><span class="m-menu__link-text">Brands & Models</span><i
					 class="m-menu__ver-arrow la la-angle-right" style="color: white"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">		
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/phone_brands') ||  request()->is('admin/phone_brands/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('phone_brands.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-box-1"></i><span class="m-menu__link-text">Phone Brand</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/phone_models') ||  request()->is('admin/phone_models/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('phone_models.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-responsive"></i><span class="m-menu__link-text">Phone Model</span></a>
						</li>
					</ul>
				</div>
			</li>

			<!-- DIY -->
			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/tabs') ||  request()->is('admin/tabs/*') || request()->is('admin/charlets') ||  request()->is('admin/charlets/*') || request()->is('admin/masks') ||  request()->is('admin/masks/*')? 'm-menu__item--open m-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-squares"></i><span class="m-menu__link-text">DIY</span><i
				class="m-menu__ver-arrow la la-angle-right" style="color: white"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">		
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/tabs') ||  request()->is('admin/tabs/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('tabs.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-menu-button"></i><span class="m-menu__link-text">Tab</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/charlets') ||  request()->is('admin/charlets/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('charlets.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-confetti"></i><span class="m-menu__link-text">Charlet</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/masks') ||  request()->is('admin/masks/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('masks.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-theater-masks"></i><span class="m-menu__link-text">Mask</span></a>
						</li>
					</ul>
				</div>
			</li>

			<!-- shell material -->
			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/shell_materials') ||  request()->is('admin/shell_materials/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('shell_materials.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-background"></i><span class="m-menu__link-text">Shell Material</span></a>
			</li>

			<li class="m-menu__section " style="margin-top: -5px">
				<h4 class="m-menu__section-text">Products</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>

			<!-- Category -->
			<li style="margin-top: -5px" class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/categories') ||  request()->is('admin/categories/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('categories.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Category</span></a>
			</li>

			<!-- Product -->
			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/products') ||  request()->is('admin/products/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('products.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-business"></i><span class="m-menu__link-text">Product</span></a>
			</li>

			<li class="m-menu__section " style="margin-top: -5px">
				<h4 class="m-menu__section-text">Informations</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>

			<!-- Banner -->
			<li style="margin-top: -5px" class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/banners') ||  request()->is('admin/banners/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('banners.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-web"></i><span class="m-menu__link-text">Banner</span></a>
			</li>	
			
			<!-- recruitment -->
			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/recruitments') ||  request()->is('admin/recruitments/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('recruitments.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-list-2"></i><span class="m-menu__link-text">Recruitment</span></a>
			</li>

			<li class="m-menu__section " style="margin-top: -5px">
				<h4 class="m-menu__section-text">Reports</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>

			<!-- order -->
			<li style="margin-top: -5px" class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/order_statuses') ||  request()->is('admin/order_statuses/*')|| request()->is('admin/orders') ||  request()->is('admin/orders/*') ||  request()->is('admin/order_statuses/*')|| request()->is('admin/intensions') ||  request()->is('admin/intensions/*') || request()->is('admin/help-order') ||  request()->is('admin/help-order/*') ? 'm-menu__item--open m-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">Order</span><i
				class="m-menu__ver-arrow la la-angle-right" style="color: white"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">		
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/order_statuses') ||  request()->is('admin/order_statuses/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('order_statuses.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-menu-button"></i><span class="m-menu__link-text">Order Status</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/orders') ||  request()->is('admin/orders/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('orders.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">Product Orders</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/intensions') ||  request()->is('admin/intensions/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('intensions.diy')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">DIY Orders</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/help-order') ||  request()->is('admin/help-order/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('intensions.help')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">Help Me Design Orders</span></a>
						</li>
						{{-- <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('masks.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-theater-masks"></i><span class="m-menu__link-text">Mask</span></a> --}}
						</li>
					</ul>
				</div>
			</li>
			<li class="m-menu__item  m-menu__item--submenu {{ request()->is('admin/order-filter') ||  request()->is('admin/order-filter/*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('orders.filter')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-list-2"></i><span class="m-menu__link-text">Filtering Orders</span></a>
			</li>
		</ul>
	</div>

<!-- END: Aside Menu -->