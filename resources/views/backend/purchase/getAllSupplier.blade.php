

@if(isset($getAllSuppliers))
    @foreach($getAllSuppliers as $supplier)
        <option value="{{$supplier->id}}" {{ $supplier->id == $currentSupplierId ? 'selected' : '' }}>{{$supplier->supplier_name}}</option>
    @endforeach
@endif

<input type="hidden" name="" id="currentSupplierId" value="{{ $currentSupplierId }}">