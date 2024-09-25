@extends('backend.master')
@section('content')
    @section('title') Product Create @endsection
    @section('product') active @endsection
    @section('product.create') active @endsection
@section('styles')
@endsection
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">New Product</h1>
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
                        <li class="breadcrumb-item text-muted">Product Create</li>
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
                                <h4>Product Create...</h4>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                                @can('product-create')
                                <a href="{{ route('product.index') }}" class="btn text-white"
                                    style="background-color: #2F4F4F">Product List</a>
                                    @endcan
                                <!--end::Add customer-->
                            </div>

                        </div>
                        <!--end::Card toolbar-->
                    </div><br>
                    <!--end::Card header-->
                    <!--begin::Card body-->

                    <div class="card-body pt-0">
                        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="product_name" class="form-label">Product Name <span class=" text-danger">(required)</span> </label>
                                        <input type="text" class="form-control" name="product_name"
                                            value="{{ old('product_name') }}" id="product_name" placeholder="Product Name" required>

                                        @error('product_name')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="product_code" class="form-label">Product Code Will Generate Autometically <span class=" text-danger">(required)</span> </label>
                                        <input type="product_code" class="form-control form-control-solid" name="product_code"
                                            value="{{ $randomProductId }}" id="product_code" placeholder="Product Code" readonly required >

                                        @error('product_code')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="category_id" class="form-label">Category <span class=" text-danger">(required)</span> </label>
                                        <select class="form-select" name="category_id" data-control="select2"
                                            data-placeholder="Select Category" required >
                                            <option value="" selected>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option required>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="brand_id" class="form-label">Brand <span class=" text-danger">(required)</span> </label>
                                        <select class="form-select" name="brand_id" data-control="select2"
                                            data-placeholder="Select Brand" required >
                                            <option value="" selected>Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                            @endforeach
                                        </select>

                                        @error('brand_id')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="purchase_price" class="form-label">Purchase Price <span class=" text-danger">(required)</span> </label>
                                        <input type="number" class="form-control" name="purchase_price"
                                            value="{{ old('purchase_price') }}" id="purchase_price" placeholder="0" required>

                                        @error('purchase_price')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="selling_price" class="form-label">Selling Price <span class=" text-danger">(required)</span> </label>
                                        <input type="number" class="form-control" name="selling_price"
                                            value="{{ old('selling_price') }}" id="selling_price" placeholder="0" required>

                                        @error('selling_price')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="unit_id" class="form-label">Unit <span class=" text-danger">(required)</span> </label>
                                        <select class="form-select" name="unit_id" data-control="select2"
                                            data-placeholder="Select Unit" required >
                                            <option value="" selected>Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                            @endforeach
                                        </select>

                                        @error('unit_id')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="stock_alert" class="form-label">Stock Alert <span class=" text-danger">(required)</span> </label>
                                        <input type="text" class="form-control" name="stock_alert"
                                            value="{{ old('stock_alert') }}" id="stock_alert" placeholder="Stock Alert" required >

                                        @error('stock_alert')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-5">
                                        <label for="description" class="form-label">Product Details</label>
                                        <textarea type="text" class="form-control" name="product_details"
                                            value="{{ old('product_details') }}" id="description"
                                            placeholder="Enter Product Details"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="d-block fw-bold fs-6 mb-5">Product Image <span class=" text-danger">(required)</span> </label>
                                            <!--end::Label-->
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                style="background-image: url('../backend/assets/media/svg/avatars/blank.svg')">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url(../backend/assets/media/avatars/Html5.png);">
                                                </div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Label-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="Image">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="product_image" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>

                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>

                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="Remove avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>

                                            </div>

                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>

                                            @error('product_image')
                                                <span class=text-danger>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                               
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <input type="submit" class="btn text-white" style="background-color: #2F4F4F">
                                </div>
                            </div>

                        </form>
                    </div>
                    <!--end::Card body-->
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="{{ asset('backend/tinymce.min.js') }}"></script>

    <script>
        var editor_config = {
            path_absolute: "/",
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>


@endsection
