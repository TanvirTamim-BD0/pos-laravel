				<!--begin::Aside-->
				<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
				    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
				    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
				    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
				   

				   
					 <!--begin::Brand-->
				    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
				        <!--begin::Logo-->

				          @php
				              $setting = DB::table('settings')->first();
				          @endphp

				        <a href="{{ route('home') }}">
				            <img alt="Logo" src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}" class="h-25px logo" style="width: 160px; height: 90px;" />
				        </a>
				        <!--end::Logo-->
				        <!--begin::Aside toggler-->
				        <div id="kt_aside_toggle"
				            class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle {{ request()->is('purchase/create') ? 'active' : '' }}"
				            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
				            data-kt-toggle-name="aside-minimize">
				            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
				            <span class="svg-icon svg-icon-1 rotate-180">
				                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				                    <path opacity="0.5"
				                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
				                        fill="black" />
				                    <path
				                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
				                        fill="black" />
				                </svg>
				            </span>
				            <!--end::Svg Icon-->
				        </div>
				        <!--end::Aside toggler-->
				    </div>
				    <!--end::Brand-->

				    <!--begin::Aside menu-->
				    <div class="aside-menu flex-column-fluid">
				        <!--begin::Aside Menu-->
				        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
				            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
				            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
				            data-kt-scroll-offset="0">
				            <!--begin::Menu-->
				            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
				                id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">


				                <div class="menu-item">
				                    <a class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}"
				                        href="{{ route('home') }}"
				                        title="Build your layout and export HTML for server side integration"
				                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
				                        data-bs-placement="right">
				                        <span class="menu-icon">
				                            <span class="svg-icon svg-icon-2">
				                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
				                                    fill="none">
				                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
				                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
				                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
				                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
				                                </svg>
				                            </span>
				                        </span>
				                        <span class="menu-title" style="font-size: 15px; color: white;">Dashboard</span>
				                    </a>
				                </div>

				               <!--  <div class="menu-item">
								    <div class="menu-content pt-8 pb-2">
								        <span class="menu-section text-muted text-uppercase fs-8 ls-1">SALE & PURCHASE
								    </div>
								</div> -->

				                @can('purchase-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('purchase*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('purchase*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                               <i class="las la-shopping-bag" style="font-size: 20px;"></i>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Purchases</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('purchase-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('purchase') ? 'active' : '' }}"
				                                        href="{{ route('purchase.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Purchase</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('purchase-create')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('purchase/create') ? 'active' : '' }}"
				                                        href="{{ route('purchase.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Purchase</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                         @can('purchase-create')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('purchase-due') ? 'active' : '' }}"
				                                        href="{{ route('purchase.due') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Due Purchases</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan

				                @can('sales-access')
									<div data-kt-menu-trigger="click"
										class="menu-item {{ request()->is('sell*') ? 'here show menu-accordion' : '' }}">
										<span
											class="menu-link {{ request()->is('sell*') ? 'active' : '' }}">
											<span class="menu-icon">
												<i class="las la-shopping-cart" style="font-size: 25px;"></i>
											</span>
											<span class="menu-title" style="font-size: 15px;">Sales</span>
											<span class="menu-arrow"></span>
										</span>

										@can('sales-list')
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link {{ request()->is('sell') ? 'active' : '' }}"
													href="{{ route('sell.index') }}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title" style="font-size: 13px;">Manage Sales</span>
												</a>
											</div>
										</div>
										@endcan


										@can('sales-create')
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link {{ request()->is('sell/create') ? 'active' : '' }}"
													href="{{ route('sell.create') }}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title" style="font-size: 13px;">POS</span>
												</a>
											</div>
										</div>
										@endcan


										@can('sales-create')
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link {{ request()->is('sell-due') ? 'active' : '' }}"
													href="{{ route('sell.due') }}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title" style="font-size: 13px;">Due Sale</span>
												</a>
											</div>
										</div>
										@endcan

									</div>
				                @endcan



								@can('stock-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('stock*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('stock*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <i class="las la-store-alt" style="font-size: 20px;"></i>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Stock</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('stock-access')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('stock') ? 'active' : '' }}"
				                                        href="{{ route('stock.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Stock</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('stock-access')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('stock-alert') ? 'active' : '' }}"
				                                        href="{{ route('stockAlert') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Stock Alert</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan


				                @can('stock-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('purchase-return*') ? 'here show menu-accordion' : '' }}
				                        {{ request()->is('sell-return*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('purchase-return*') ? 'active' : '' }}
				                            {{ request()->is('sell-return*') ? 'active' : '' }} ">
				                            <span class="menu-icon">
				                                <i class="las la-exchange-alt" style="font-size: 20px;"></i>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Return</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('stock-access')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('sell-return') ? 'active' : '' }}"
				                                        href="{{ route('sell-return.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Sell Return</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan
				                        

				                        @can('stock-access')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('purchase-return') ? 'active' : '' }}"
				                                        href="{{ route('purchase-return.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Purchase Return</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan


								@can('damage-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('damage*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('damage*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <i class="las la-house-damage" style="font-size: 20px;"></i>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Damage</span>
				                            <span class="menu-arrow"></span>
				                        </span>


				                        @can('damage-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('damage') ? 'active' : '' }}"
				                                        href="{{ route('damage.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Damage</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('damage-create')
				                            <div class="menu-sub menu-sub-accordion">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('damage/create') ? 'active' : '' }}"
				                                        href="{{ route('damage.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Damage</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan



				                <div class="menu-item">
				                    <div class="menu-content pt-8 pb-2">
				                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">PRODUCT INFORMATION</span>
				                    </div>
				                </div>

				                @can('category-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('category*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('category*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <span class="svg-icon svg-icon-2">
				                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
				                                        viewBox="0 0 24 24" fill="none">
				                                        <path
				                                            d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
				                                            fill="black" />
				                                        <path
				                                            d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
				                                            fill="black" />
				                                        <path opacity="0.3"
				                                            d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
				                                            fill="black" />
				                                    </svg>
				                                </span>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Category</span>
				                            <span class="menu-arrow"></span>
				                        </span>


				                        @can('category-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('category') ? 'active' : '' }}"
				                                        href="{{ route('category.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Category</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('category-create')
				                            <div class="menu-sub menu-sub-accordion">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('category/create') ? 'active' : '' }}"
				                                        href="{{ route('category.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Category</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan

				                @can('brand-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('brand*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('brand*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <span class="svg-icon svg-icon-2">
				                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
				                                        viewBox="0 0 24 24" fill="none">
				                                        <path
				                                            d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
				                                            fill="black" />
				                                        <path
				                                            d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
				                                            fill="black" />
				                                        <path opacity="0.3"
				                                            d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
				                                            fill="black" />
				                                        <path opacity="0.3"
				                                            d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
				                                            fill="black" />
				                                    </svg>
				                                </span>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Brand</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('brand-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('brand') ? 'active' : '' }}"
				                                        href="{{ route('brand.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Brand</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('brand-create')
				                            <div class="menu-sub menu-sub-accordion">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('brand/create') ? 'active' : '' }}"
				                                        href="{{ route('brand.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Brand</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan


				                @can('unit-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('unit*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('unit*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <span class="svg-icon svg-icon-2">
				                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
				                                        viewBox="0 0 24 24" fill="none">
				                                        <path opacity="0.3"
				                                            d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
				                                            fill="black" />
				                                        <path
				                                            d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z"
				                                            fill="black" />
				                                    </svg>
				                                </span>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Unit</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('unit-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('unit') ? 'active' : '' }}"
				                                        href="{{ route('unit.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Unit</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('unit-create')
				                            <div class="menu-sub menu-sub-accordion">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('unit/create') ? 'active' : '' }}"
				                                        href="{{ route('unit.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Unit</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan

		

				            @can('product-access')
				                <div data-kt-menu-trigger="click"
				                    class="menu-item {{ request()->is('product*') ? 'here show menu-accordion' : '' }}">
				                    <span
				                        class="menu-link {{ request()->is('product*') ? 'active' : '' }}">
				                        <span class="menu-icon">
				                            <span class="svg-icon svg-icon-2">
				                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
				                                    fill="none">
				                                    <path opacity="0.3"
				                                        d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
				                                        fill="black" />
				                                    <path
				                                        d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
				                                        fill="black" />
				                                </svg>
				                            </span>
				                        </span>
				                        <span class="menu-title" style="font-size: 15px;">Product</span>
				                        <span class="menu-arrow"></span>
				                    </span>

				                    @can('product-list')
				                        <div class="menu-sub menu-sub-accordion menu-active-bg">
				                            <div class="menu-item">
				                                <a class="menu-link {{ request()->is('product') ? 'active' : '' }}"
				                                    href="{{ route('product.index') }}">
				                                    <span class="menu-bullet">
				                                        <span class="bullet bullet-dot"></span>
				                                    </span>
				                                    <span class="menu-title" style="font-size: 13px;">Manage Product</span>
				                                </a>
				                            </div>
				                        </div>
				                    @endcan


				                    @can('product-create')
				                        <div class="menu-sub menu-sub-accordion">
				                            <div class="menu-item">
				                                <a class="menu-link {{ request()->is('product/create') ? 'active' : '' }}"
				                                    href="{{ route('product.create') }}">
				                                    <span class="menu-bullet">
				                                        <span class="bullet bullet-dot"></span>
				                                    </span>
				                                    <span class="menu-title" style="font-size: 13px;">Add Product</span>
				                                </a>
				                            </div>
				                        </div>
				                    @endcan

				                </div>
				            @endcan


				            <div class="menu-item">
								    <div class="menu-content pt-8 pb-2">
								        <span class="menu-section text-muted text-uppercase fs-8 ls-1">PEOPLES & EXPENSES
								    </div>
								</div>
								

				                 @can('customer-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('customer*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('customers*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
				                                <span class="svg-icon svg-icon-2">
				                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
				                                        viewBox="0 0 24 24" fill="none">
				                                        <path
				                                            d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
				                                            fill="black" />
				                                        <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
				                                    </svg>
				                                </span>
				                                <!--end::Svg Icon-->
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Customer</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('customer-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('customers') ? 'active' : '' }}"
				                                        href="{{ route('customers.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Customer</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                        @can('customer-create')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('customers/create') ? 'active' : '' }}"
				                                        href="{{ route('customers.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Customer</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                    </div>
				                @endcan

				                @can('supplier-access')
				                    <div data-kt-menu-trigger="click"
				                        class="menu-item {{ request()->is('supplier*') ? 'here show menu-accordion' : '' }}">
				                        <span
				                            class="menu-link {{ request()->is('supplier*') ? 'active' : '' }}">
				                            <span class="menu-icon">
				                                <i class="las la-user-plus" style="font-size: 20px;"></i>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">Supplier</span>
				                            <span class="menu-arrow"></span>
				                        </span>

				                        @can('supplier-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('supplier') ? 'active' : '' }}"
				                                        href="{{ route('supplier.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Manage Supplier</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                        @can('supplier-create')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('supplier/create') ? 'active' : '' }}"
				                                        href="{{ route('supplier.create') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Add Supplier</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan

				                @can('expense-access')
				                <div data-kt-menu-trigger="click"
				                    class="menu-item {{ request()->is('expense*') ? 'here show menu-accordion' : '' }}">
				            <span
				                class="menu-link {{ request()->is('expense*') ? 'active' : '' }}">
				                <span class="menu-icon">
				                    <span class="svg-icon svg-icon-2">
				                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
				                            fill="none">
				                            <path
				                                d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z"
				                                fill="black" />
				                            <path opacity="0.3"
				                                d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z"
				                                fill="black" />
				                        </svg>
				                    </span>
				                </span>
				                <span class="menu-title" style="font-size: 15px;">Expenses</span>
				                <span class="menu-arrow"></span>
				            </span>


				            @can('expense-category-list')
				                <div class="menu-sub menu-sub-accordion menu-active-bg">
				                    <div class="menu-item">
				                        <a class="menu-link {{ request()->is('expense-category') ? 'active' : '' }}"
				                            href="{{ route('expense-category.index') }}">
				                            <span class="menu-bullet">
				                                <span class="bullet bullet-dot"></span>
				                            </span>
				                            <span class="menu-title" style="font-size: 13px;">Expense Category</span>
				                        </a>
				                    </div>
				                </div>
				            @endcan


				            @can('expense-create')
				                <div class="menu-sub menu-sub-accordion menu-active-bg">
				                    <div class="menu-item">
				                        <a class="menu-link {{ request()->is('expense/create') ? 'active' : '' }}"
				                            href="{{ route('expense.create') }}">
				                            <span class="menu-bullet">
				                                <span class="bullet bullet-dot"></span>
				                            </span>
				                            <span class="menu-title" style="font-size: 13px;">Add Expense</span>
				                        </a>
				                    </div>
				                </div>
				            @endcan


				            @can('expense-list')
				                <div class="menu-sub menu-sub-accordion menu-active-bg">
				                    <div class="menu-item">
				                        <a class="menu-link {{ request()->is('expense') ? 'active' : '' }}"
				                            href="{{ route('expense.index') }}">
				                            <span class="menu-bullet">
				                                <span class="bullet bullet-dot"></span>
				                            </span>
				                            <span class="menu-title" style="font-size: 13px;">Manage Expense</span>
				                        </a>
				                    </div>
				                </div>
				            @endcan

				        </div>
				        @endcan


			    			<div class="menu-item">
				                <div class="menu-content pt-8 pb-2">
				                        <span class="menu-section text-muted text-uppercase fs-8 ls-1"> Reports and Settings</span>
				                   </div>
				               </div>
				

				@can('sales-report-access')
					<div data-kt-menu-trigger="click" class="menu-item 
									{{ request()->is('sale-*') ? 'here show menu-accordion' : '' }}
									">
						<span
							class="menu-link 
										{{ request()->is('sale-*') ? 'active' : '' }}">
							<span class="menu-icon">
				                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
				                            <span class="svg-icon svg-icon-2">
				                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
				                                    xmlns="http://www.w3.org/2000/svg">
				                                    <path
				                                        d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
				                                        fill="currentColor"></path>
				                                    <path opacity="0.3"
				                                        d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
				                                        fill="currentColor"></path>
				                                </svg>
				                            </span>
				                            <!--end::Svg Icon-->
				                        </span>
							<span class="menu-title" style="font-size: 15px;">Sales Reports</span>
							<span class="menu-arrow"></span>
						</span>

						@can('sale-todays-report-access')
							<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('sale-todays-report') ? 'active' : '' }}"
										href="{{ route('sale-todays-report') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Current Day Report</span>
									</a>
								</div>
							</div>
						@endcan
						
						@can('sale-weekend-report-access')
							<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('sale-weekend-report') ? 'active' : '' }}"
										href="{{ route('sale-weekend-report') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Current Weekend Report</span>
									</a>
								</div>
							</div>
						@endcan

						@can('sale-month-report-access')
							<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('sale-month-report') ? 'active' : '' }}"
										href="{{ route('sale-month-report') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Current Month Report</span>
									</a>
								</div>
							</div>
						@endcan

						@can('sale-daily-report-access')
							<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('sale-daily-report-with-date') ? 'active' : '' }}"
										href="{{ route('sale-daily-report-with-date') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Selected Daily Report</span>
									</a>
								</div>
							</div>
						@endcan

						@can('sale-monthly-report-access')
							<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('sale-monthly-report-with-month-name') ? 'active' : '' }}"
										href="{{ route('sale-monthly-report-with-month-name') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Selected Monthly Report</span>
									</a>
								</div>
							</div>
						@endcan

						@can('sale-between-report-access')
							<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('sale-report-with-between-date') ? 'active' : '' }}"
										href="{{ route('sale-report-with-between-date') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Selected Between Report</span>
									</a>
								</div>
							</div>
						@endcan


					</div>
				@endcan


								   @can('purchases-report-access')
				  <div data-kt-menu-trigger="click"  class="menu-item {{ request()->is('purchase-*') ? 'here show menu-accordion' : '' }}">
					<span
					    class="menu-link {{ request()->is('purchase-*') ? 'active' : '' }}">
					    <span class="menu-icon">
				                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
				                            <span class="svg-icon svg-icon-2">
				                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
				                                    xmlns="http://www.w3.org/2000/svg">
				                                    <path
				                                        d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
				                                        fill="currentColor"></path>
				                                    <path opacity="0.3"
				                                        d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
				                                        fill="currentColor"></path>
				                                </svg>
				                            </span>
				                            <!--end::Svg Icon-->
				                        </span>
					    <span class="menu-title" style="font-size: 15px;">Purchase Reports</span>
					    <span class="menu-arrow"></span>
					</span>


					@can('purchase-todays-report-access')
					<div class="menu-sub menu-sub-accordion menu-active-bg">
					    <div class="menu-item">
					        <a class="menu-link {{ request()->is('purchase-todays-report') ? 'active' : '' }}"
					            href="{{ route('purchase-todays-report') }}">
					            <span class="menu-bullet">
					                <span class="bullet bullet-dot"></span>
					            </span>
					            <span class="menu-title" style="font-size: 13px;">Purchase Today Report</span>
					        </a>
					    </div>
					</div>
					@endcan


					@can('purchase-weekend-report-access')
					<div class="menu-sub menu-sub-accordion menu-active-bg">
						<div class="menu-item">
							<a class="menu-link {{ request()->is('purchase-weekend-report') ? 'active' : '' }}"
								href="{{ route('purchase-weekend-report') }}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title" style="font-size: 13px;">Current Weekend Report</span>
							</a>
						</div>
					</div>
					@endcan

					@can('purchase-month-report-access')
					<div class="menu-sub menu-sub-accordion menu-active-bg">
						<div class="menu-item">
							<a class="menu-link {{ request()->is('purchase-month-report') ? 'active' : '' }}"
									href="{{ route('purchase-month-report') }}">
									<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
									</span>
								<span class="menu-title" style="font-size: 13px;">Current Month Report</span>
							</a>
						</div>
					</div>
					@endcan


					@can('purchase-daily-report-access')
					<div class="menu-sub menu-sub-accordion menu-active-bg">
							<div class="menu-item">
								<a class="menu-link {{ request()->is('purchase-daily-report-with-date') ? 'active' : '' }}"
									href="{{ route('purchase-daily-report-with-date') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title" style="font-size: 13px;">Selected Daily Report</span>
								</a>
							</div>
					</div>
					@endcan


					@can('purchase-monthly-report-access')
					<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('purchase-monthly-report-with-month-name') ? 'active' : '' }}"
										href="{{ route('purchase-monthly-report-with-month-name') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Selected Monthly Report</span>
									</a>
								</div>
							</div>
							@endcan


					@can('purchase-between-report-access')
					<div class="menu-sub menu-sub-accordion menu-active-bg">
								<div class="menu-item">
									<a class="menu-link {{ request()->is('purchase-report-with-between-date') ? 'active' : '' }}"
										href="{{ route('purchase-report-with-between-date') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title" style="font-size: 13px;">Selected Between Report</span>
									</a>
								</div>
							</div>
							@endcan

				</div> 
				@endcan 
		

				<!-- <div class="menu-item">
				    <div class="menu-content pt-8 pb-2">
				        <span class="menu-section text-muted text-uppercase fs-8 ls-1">SETTING & CUSTOMIZE</span>
				    </div>
				</div>
						
 -->

 							@can('user-access')
				                    <div data-kt-menu-trigger="click" class="menu-item 
										{{ request()->is('roles*') ? 'here show menu-accordion' : '' }}
										{{ request()->is('users*') ? 'here show menu-accordion' : '' }}
									">
				                        <span class="menu-link 
										{{ request()->is('roles*') ? 'active' : '' }}
										{{ request()->is('users*') ? 'active' : '' }}
										">
				                            <span class="menu-icon">
				                                <span class="svg-icon svg-icon-2">
				                                    <i class="las la-user-check" style="font-size: 20px;"></i>
				                                </span>
				                            </span>
				                            <span class="menu-title" style="font-size: 15px;">User Managerment</span>
				                            <span class="menu-arrow"></span>
				                        </span>


				                        @can('role-list')
				                            <div class="menu-sub menu-sub-accordion menu-active-bg">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('roles*') ? 'active' : '' }}"
				                                        href="{{ route('roles.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">Role</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan


				                        @can('user-list')
				                            <div class="menu-sub menu-sub-accordion">
				                                <div class="menu-item">
				                                    <a class="menu-link {{ request()->is('users*') ? 'active' : '' }}"
				                                        href="{{ route('users.index') }}">
				                                        <span class="menu-bullet">
				                                            <span class="bullet bullet-dot"></span>
				                                        </span>
				                                        <span class="menu-title" style="font-size: 13px;">User</span>
				                                    </a>
				                                </div>
				                            </div>
				                        @endcan

				                    </div>
				                @endcan

							@can('company-profile-access')
 							<div class="menu-item">
										<a class="menu-link {{ request()->is('setting') ? 'active' : '' }}"
											href="{{ route('setting') }}"
											title="Build your layout and export HTML for server side integration"
											data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
											data-bs-placement="right">
											<span class="menu-icon">
												<i class="las la-cog" style="font-size: 20px;"></i>
											</span>
											<span class="menu-title" style="font-size: 15px;">Shop Setting</span>
										</a>
									</div>
							@endcan
   


				</div>
				<!--end::Menu-->
				</div>
				<!--end::Aside Menu-->
				</div>
				<!--end::Aside menu-->

				</div>
				<!--end::Aside-->
