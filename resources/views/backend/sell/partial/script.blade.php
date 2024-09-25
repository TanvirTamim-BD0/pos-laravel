<script>

    //To fetch all the product data with category and brand...
    $("#categoryID").change(function () {
        var categoryId = $(this).val();
        var brandId = $("#brandId").val();

        var url = "{{ route('sell.filter.product-list') }}";
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

        var url = "{{ route('sell.filter.product-list') }}";
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
        var url = "{{ route('sell.search.product-list') }}";

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

        //value empty .....
        $("#search").val('');
        $('#categoryID').val(null).trigger("change");
        $('#brandId').val(null).trigger("change");
        
        var url = "{{ route('sell.reset.product-list') }}";
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


   
    //For purchase product add to the sell product list...
    function addSellProductDetails(id) {
        event.preventDefault();

        var sellId = $("#sellId").val();
        var purchaseProductId = $("#purchaseProductId" + id).val();

        var url = "{{ route('add.sell.product-deatils') }}";
        if(sellId != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    sellId: sellId,
                    purchaseProductId: purchaseProductId,
                },

                success: function (data) {
                    if(data.error){
                        alert(data.error);
                    }else{
                        $("#updateSellList").html(data);
                        $("#sellProductDetailsModal"+id).modal('hide');

                    }
                }
            });
        }else{
            //
        }
       
    }


</script>