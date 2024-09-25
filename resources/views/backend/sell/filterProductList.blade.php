                                        


                <div class="product_item_wrap">
                        <div class="d-flex flex-wrap">


                             @foreach($products as $key=>$purchaseProduct)
                                @if(isset($purchaseProduct))

                                         @php
                                            $lastProductId = $purchaseProduct->id;

                                            if($key == 0){
                                                $firstProductId = $purchaseProduct->id;
                                            }
                                        @endphp

                                    <div class="single_product">
                                        <a onclick="addSellProductDetails({{$purchaseProduct->id}})">
                                            <img
                                                src="{{ asset('uploads/product_image/'.$purchaseProduct->product_image) }}"
                                                alt="" style="height: 60px; width: 80px;">
                                            <h4 class="mt-1">{{ $purchaseProduct->product_name }}</h4>


                                            @php
                                                $productStockData = App\Models\Stock::getProductStockCount($purchaseProduct->id);
                                            @endphp


                                            @if($productStockData != null)
                                                <h4>Qty - {{ $productStockData }} {{ $purchaseProduct->unitData->unit_name }}</h4>
                                            @else
                                                <h4>Qty - 0 {{ $purchaseProduct->unitData->unit_name }}</h4>
                                            @endif

                                        </a>
                                    </div>

                                    {{-- //To store prodctId into hidden field... --}}
                                    <input type="hidden" value="{{ $purchaseProduct->id }}"
                                        id="purchaseProductId{{$purchaseProduct->id}}" name="purchaseProductId{{$purchaseProduct->id}}">

                                @endif
                            @endforeach

                            @if(isset($lastProductId) && isset($firstProductId))
                                    <input type="hidden" id="firstProductId" value="{{$firstProductId}}">
                                    <input type="hidden" id="lastProductId" value="{{$lastProductId}}">
                                @endif
                           
                        </div>
                    </div>


    @section('scripts')
        <script src="{{ asset('/backend/assets/js/custom/apps/projects/settings/settings.js') }}"></script>
        <script>
            $("#purchase_date").flatpickr()
            $(".producut_menufacture_date").flatpickr()
            $(".product_expire_date").flatpickr()
        </script>


        <script>
        //To fetch nextPageProductData....
        function nextProductData() {
            event.preventDefault();
            var lastProductId = $("#lastProductId").val();

            var url = "{{ route('sell.next-page-product-data') }}";
            if (lastProductId != null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        lastProductId: lastProductId,
                    },
                    success: function (data) {
                        if(data.error){
                            alert(data.error);
                        }else{
                            $("#filterProductList").html(data);
                        }
                    }
                });
            } 
        }
       
        //To fetch previousPageProductData....
        function previousProductData() {
            event.preventDefault();
            var lastProductId = $("#firstProductId").val();

            var url = "{{ route('sell.previous-page-product-data') }}";
            if (lastProductId != null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        lastProductId: lastProductId,
                    },
                    success: function (data) {
                        if(data.error){
                            alert(data.error);
                        }else{
                            $("#filterProductList").html(data);
                        }
                    }
                });
            } 
        }
    </script>
    @endsection
