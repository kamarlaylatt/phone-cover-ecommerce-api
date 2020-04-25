<!-- BEGIN: Aside Menu -->

	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<!-- <li class="m-menu__item " aria-haspopup="true"><a href="../../index.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Dashboard</span>
							<span class="m-menu__link-badge">
								<span class="m-badge m-badge--danger">2</span>
							</span> </span></span></a></li> -->
			<!-- <li class="m-menu__section ">
				<h4 class="m-menu__section-text">Menu List</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li> -->
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">User Management</span><i
					 class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('admins.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-businesswoman"></i><span class="m-menu__link-text">Managers</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('admin_roles.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-text">Roles</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('users.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i><span class="m-menu__link-text">Users</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('users.block_list')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-cancel"></i><span class="m-menu__link-text">Block List</span></a>
						</li>
					</ul>
				</div>
			</li>

			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-business"></i><span class="m-menu__link-text">Products</span><i
					 class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">		
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('categories.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Category</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('products.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-business"></i><span class="m-menu__link-text">Product</span></a>
						</li>
					</ul>
				</div>
			</li>
			<!-- Phone Brand & Model -->
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-responsive"></i><span class="m-menu__link-text">Brands & Models</span><i
					 class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">		
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('phone_brands.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-box-1"></i><span class="m-menu__link-text">Phone Brand</span></a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('phone_models.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-responsive"></i><span class="m-menu__link-text">Phone Model</span></a>
						</li>
					</ul>
				</div>
			</li>
			<!-- Banner -->
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('banners.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-web"></i><span class="m-menu__link-text">Banner</span></a>
			</li>

			
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('shell_materials.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-background"></i><span class="m-menu__link-text">Shell Material</span></a>
			</li>
			
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('recruitments.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-list-2"></i><span class="m-menu__link-text">Recruitment</span></a>
			</li>
		</ul>
	</div>

<!-- END: Aside Menu -->