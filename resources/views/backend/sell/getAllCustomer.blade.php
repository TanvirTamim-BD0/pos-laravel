

@if(isset($getAllCustomers))
    @foreach($getAllCustomers as $customer)
        <option value="{{$customer->id}}" {{ $customer->id == $currentCustomerId ? 'selected' : '' }}>{{$customer->customer_name}}</option>
    @endforeach
@endif

<input type="hidden" name="" id="currentCustomerId" value="{{ $currentCustomerId }}">