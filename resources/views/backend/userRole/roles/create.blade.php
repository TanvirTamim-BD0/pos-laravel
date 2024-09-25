@extends('backend.master')
@section('content')
@section('title') Role Create @endsection
@section('roles') active @endsection
@section('roles.create') active @endsection
@section('styles')
@endsection
@section('content')

		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">New Role</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-300 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="/metronic8/demo1/../demo1/index.html" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">Role Create</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								<!--begin::Card-->
								<div class="card">
									<!--begin::Card header-->
									<div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<h4>Role Create...</h4>
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

												@can('role-list')
												<a href="{{route('roles.index')}}" class="btn text-white" style="background-color: #2F4F4F">Roles List</a>
												@endcan

												<!--end::Add customer-->
											</div>
											
										</div>
										<!--end::Card toolbar-->
									</div><br>
									<!--end::Card header-->
									<!--begin::Card body-->

									<div class="card-body pt-0">
										<form action="{{route('roles.store')}}" method="post">
	                					@csrf	
														<!--begin::Scroll-->
														<div class="d-flex flex-column ">

															<div class="fv-row mb-10">
																<!--begin::Label-->
																<label class="fs-5 fw-bold form-label mb-2">
																	<span class="required">Role name</span>
																</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid" placeholder="Enter a role name" name="name" />
																<!--end::Input-->
															</div>


															<div class="fv-row">
																<!--begin::Label-->
																<label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
																<!--end::Label-->
																<!--begin::Table wrapper-->
																<div class="table-responsive">
																	<!--begin::Table-->
																	<table class="table align-middle table-row-dashed fs-6 gy-5">
																		<!--begin::Table body-->
																		<tbody class="text-gray-600 fw-semibold">
																			<!--begin::Table row-->
																			<tr>
																				<td class="text-gray-800">Administrator Access 
																				</td>
																				<td>
																					<!--begin::Checkbox-->
																					<label class="form-check form-check-custom form-check-solid me-9" for="checkPermissionAll">
																						<input class="form-check-input" type="checkbox" value="1"
                                														onclick="checkPermissionByGroup('allInput', this)"  id="checkPermissionAll" />
																						<span class="form-check-label" >Select all</span>
																					</label>
																					<!--end::Checkbox-->
																				</td>
																			</tr>


																			@php $i = 1; @endphp
                           													@foreach ($permission_groups as $group)
																			<tr class="allInput">

																				<td class="text-gray-800 d-flex">{{ $group->name }} <label class="form-check form-check-sm form-check-custom form-check-solid" style="margin-left: 5px;" for="{{ $i }}Management">
																							<input class="form-check-input" type="checkbox"
																							 name="permissions[]" id="{{ $i }}Management" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" />
																							<span class="form-check-label"></span>
																						</label> 
																				</td>


																				<td>
																					<!--begin::Wrapper-->
																					<div class="role-{{ $i }}-management-checkbox">

																						@php
												                                        $permissions = App\Models\User::getpermissionsByGroupName($group->name);
												                                        $j = 1;
												                                        @endphp
												                                        @foreach ($permissions as $permission)
																						<label class="form-check form-check-sm form-check-custom form-check-solid me-2 me-lg-20 mt-1" for="{{$permission->id}}">

																							 <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}" id="{{$permission->id}}">

																							<span class="form-check-label">{{ $permission->name }}</span>
																						</label>

																		
																						@php $j++; @endphp
                                        												@endforeach
																				
																					</div>
																				</td>

																
																			</tr>
																			@php $i++; @endphp
                            												@endforeach

							
																		</tbody>
																		<!--end::Table body-->
																	</table>
																	<!--end::Table-->
																</div>
																<!--end::Table wrapper-->
															</div>
															<!--end::Permissions-->
														</div>
														<!--end::Scroll-->
														<!--begin::Actions-->
														<div class="text-center pt-15" style="float: left;">
															<button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
															<button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
																<span class="indicator-label">Submit</span>
																<span class="indicator-progress">Please wait... 
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
															</button>
														</div>
														<!--end::Actions-->
													</form>
													<!--end::Form-->
									</div>
									<!--end::Card body-->
								</div>

							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>



		<script>
         function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');

            if(groupIdName.is(':checked')){
                 classCheckBox.prop('checked', true);
             }else{
                 classCheckBox.prop('checked', false);
             }
         }

         function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.'+groupClassName+ ' input');
            const groupIDCheckBox = $("#"+groupID);

            // if there is any occurance where something is not selected then make selected = false
            if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
                groupIDCheckBox.prop('checked', true);
            }else{
                groupIDCheckBox.prop('checked', false);
            }
         }

         function checkPermissionAll(allInput, checkThis) {
            const allId = $("#"+checkThis.id);
            const allInputCheck = $('.'+allInput+' input');

            if(allId.is(':checked')){
                 allInputCheck.prop('checked', true);
             }else{
                 allInputCheck.prop('checked', false);
             }
         }

		</script>

@endsection