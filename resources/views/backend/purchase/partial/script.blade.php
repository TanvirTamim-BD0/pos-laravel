

<script>

    //To fetch all the product data with category and brand...
    $("#categoryID").change(function () {
        var categoryId = $(this).val();
        var brandId = $("#brandId").val();

        var url = "{{ route('filter.product-list') }}";
        if (categoryId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    categoryId: categoryId,
                    brandId: brandId,
                },
                success: function (data) {
                    $("#filterProductList").html(data);
                }
            });
        } else {
            $('#filterProductList').html('');
        }
    });

    //To fetch all the product data with category and brand...
    $("#brandId").change(function () {
        var brandId = $(this).val();
        var categoryId = $("#categoryID").val();

        var url = "{{ route('filter.product-list') }}";
        if (brandId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    categoryId: categoryId,
                    brandId: brandId,
                },
                success: function (data) {
                    $("#filterProductList").html(data);
                }
            });
        } else {
            $('#filterProductList').html('');
        }
    });


    
    //search product data
   function searchProduct() {
        event.preventDefault();

        var searchValue = $("#search").val();
        var url = "{{ route('search.product-list') }}";

        if(searchValue != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    searchValue: searchValue,
                },
                success: function (data) {
                  $("#filterProductList").html(data);
                }
            });
        }else{
         //   
        }
    }

    //reset search 
    function resetSearch() {
        event.preventDefault();
        var searchValue = $("#search").val('');
        $('#categoryID').val(null).trigger("change");
        $('#brandId').val(null).trigger("change");

        var url = "{{ route('reset.product-list') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $("#filterProductList").html(data);
            }
        });
    }


 //For purchase product add to the list...
   function addProductDetails(id) {
        event.preventDefault();

        var purchaseId = $("#purchaseId").val();
        var productId = $("#productId" + id).val();
        var productQty = $("#product_qty" + id).val();
        var freeProduct = $("#free_product" + id).val();
        var totalProduct = $("#total_product" + id).val();

        var url = "{{ route('add.product-deatils') }}";
        if(productQty != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    purchaseId: purchaseId,
                    productId: productId,
                    productQty: productQty,
                    freeProduct: freeProduct,
                    totalProduct: totalProduct,
                },

                success: function (data) {
                    if(data.error){
                        alert(data.error);
                        $("#purchaseProductCreate" + productId).modal('hide');
                    }else{
                        
                        //To purchase modal to hide...
                        $("#purchaseProductCreate" + productId).modal('hide');
                        $("#updatePurchaseList").html(data);

                        //To purchase-product modal data null...
                        $("#product_qty" + id).val('');
                        $("#free_product" + id).val('');
                        $("#total_product" + id).val('');
                    }
                }
            });
        }else{
            alert('At first entry your purchase product quantity !')
        }

    }



    //productQuantity calculation singleProductPrice and totalProduct
    function productQuantity(id) {
        //get total product
        let productQty = parseFloat($("#product_qty" + id).val()); 
        let freeProduct = parseFloat($("#free_product" + id).val());
        let totalProduct = productQty + freeProduct;

        if (freeProduct >= 0) {
            $("#totalProduct" + id).text(totalProduct);
            $("#total_product" + id).val(totalProduct);
        } else {
            $("#totalProduct" + id).text(productQty);
            $("#total_product" + id).val(productQty);
        }

    }


    //freeProductQuantity calculation totalProduct
    function freeProductQuantity(id) {
        let productQty = parseFloat($("#product_qty" + id).val());
        let freeProduct = parseFloat($("#free_product" + id).val());
        let totalProduct = productQty + freeProduct;

        if (freeProduct >= 0) {
            $("#totalProduct" + id).text(totalProduct);
            $("#total_product" + id).val(totalProduct);
        } else {
            $("#totalProduct" + id).text(productQty);
            $("#total_product" + id).val(productQty);
        }

    }


    //To purchase product modal show...
    function purchaseProductCreate(productId) {
        var purchaseUniqueId = $("#purchaseId").val();

        var url = "{{ route('single-purchase-product-data') }}";
        if (purchaseUniqueId != null) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    purchaseUniqueId: purchaseUniqueId,
                    productId: productId
                },
                success: function (data) {
                   if(data.error){
                        alert(data.error);
                    }else{
                        $("#purchaseProductCreate"+productId).modal('show');
                    }
                }
            });
        }
    }

</script>