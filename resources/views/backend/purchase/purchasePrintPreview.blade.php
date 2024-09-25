
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05)
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6
        }

        thead {
            background: #abe18b;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            text-align: left;
            text-transform: uppercase;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6
        }

        .table .table {
            background-color: #fff
        }


        .table-bordered {
            border: 1px solid #dee2e6
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px
        }
        
       * {
    padding: 0;
    margin: 0;
    font-family: sans-serif;
}
.container{
    width: 796px;
    display: block;
    margin: auto;
    padding: 10px;
    box-sizing: border-box;
}
.header{
    width: 100%;
    padding-bottom: 60px;
}
p{
    font-weight: 400;
}
h1{
    font-size: 45px !important;
    padding-bottom: 10px;
}
.header h1,.header h3,h2{
    text-transform: uppercase;
    font-size: 25px;
    font-weight: 500;
    margin-bottom: 5px;
}
.width-5{
    width: 49%;
    display: inline-block;
}
.number{
    float: left;
    padding-right: 25px;
}
.text-uppercase{
    text-transform: uppercase;
}
tr{
    border-bottom: 1px solid #ddd;
}
.total{
    position: relative;
}
.position{
    position: absolute;
    right: -116px;

}

.total .position h4{
    font-weight: 400;
    display: inline-block;
}
.pr-p{
    padding-right: 25px;
}
.pr-t{
    padding-right: 55px;
}
.pr {
    padding-right: 35px;
}

h4,h5{
    font-weight: 400;
    margin-bottom: 5px;
}
.footer{
    padding: 60px;
    background: #ddd;
    margin-top: 15px;
}
.float-right{
    float: right;
}

.total-info {
            display: flex;
            justify-content: flex-end;
        }

        .table-total-info {
            width: 30%;
        }

        .table-total-info p {
            position: relative;
            color: #000000;
        }

        .terms {
            width: 60%;
        }

        .table-total-info p span {
            position: absolute;
            right: 50px;
            color: #000;
        }


    </style>

</head>
						@php
                        	$setting = App\Models\Setting::first();
                        @endphp


<body>
    <br>
    <div class="container">
        <div class="header">
            <div class="width-5" style="padding-right: 2%;margin-bottom: 20px;">
                <div class="element" style="width: 80%;">
                    <h1 style="text-align: center; margin-left: 250px;">invoice</h1>

                     @if(isset($setting->logo_image))
                        <img src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}" style="height: 60px; width: 200px; margin-bottom: 10px;">
                    @endif
                    
                    
                    <div class="numdate">
                        <div class="number">
                            <p>Invoice Number</p>
                            <p>{{$purchaseData->purchase_id}}</p>
                        </div>
                        <div class="date">
                            <p> Dte Of Issue</p>
                            <p>{{ $purchaseData->created_at->toDateString() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="width-5" style="padding-right: 2%;width: 48%;">
                <div class="element" style="width: 80%;">
                    <h3 style="font-size: 19px;">Shop Details:</h3>
                    <p>{{$setting->company_name}}</p>
                    <p>{{$setting->mobile}}</p>
                    <p>{{$setting->address_line_1}}</p>
                </div>
            </div>
            <div class="width-5">
                <div class="element" style="width: 80%;position: relative;top: 18px;">
                    <h3 style="font-size: 19px;">Issued By:</h3>
                    <p style="margin-bottom: 4px;">{{ $supplierData->supplier_name }}</p>
                    <p style="margin-bottom: 4px;">{{ $supplierData->supplier_phone }}</p>
                    <p style="margin-bottom: 4px;">{{ $supplierData->supplier_email }}</p>
                    <p style="margin-bottom: 4px;"> {{ $supplierData->supplier_address }}</p>

                </div>
            </div>
            
        </div>
        <div class="info-tbl" style="padding-bottom: 45px;">
            <table class="table"  style="border: 1px solid gray;">
                <thead>
                    <tr>
                    	<th class="text-uppercase">No</th>
                        <th class="text-uppercase">Product</th>
                        <th class="text-uppercase">Qty</th>
                        <th class="text-uppercase">Free Qty</th>
                        <th class="text-uppercase">Total Qty</th>
                        <th class="text-uppercase">Total Price</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($purchaseProducts as $key=>$productData)
                                                            @if(isset($productData))
                                                                <tr>
                                                          			<td>{{ $key+1 }}</td>
                                                                    
                                                                    <td>{{ $productData->productData->product_name }}
                                                                    </td>
                                                                    <td>{{ $productData->product_qty }} {{ $productData->productData->unitData->unit_name }} </td>
                                                                    <td>{{ $productData->free_product }} {{ $productData->productData->unitData->unit_name }} </td>
                                                                    <td>{{ $productData->total_product }} {{ $productData->productData->unitData->unit_name }}</td>
                                                                    <td class="fw-bolder fs-6 text-gray-800" style="text-align: center;">
                                                                    {{ number_format($productData->total_product_price ) }} </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                   
                </tbody>
            </table>

            <div class="total-info">
            <div class="terms">
                <h5>invoice terms</h5>
                <p>please pay your invoice by.....</p>
            </div>
            <div class="table-total-info">
                <p style="margin-bottom: 4px;">Subtotal <span> {{ number_format($totalPurchaseAmount) }} </span></p>
                <p style="margin-bottom: 4px;">Paid <span> {{ number_format($paidAmount) }} tk</span></p>
                <p style="margin-bottom: 4px;">Due <span> {{ number_format($dueAmount) }} tk</span></p>
                
            </div>
        </div>

        </div>
        
    </div>
    </div>
</body>

</html>




