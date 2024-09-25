<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Parcel;
use App\Models\Sell;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{   

    function __construct()
    {
         $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','show']]);
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('backend.customer.index' ,compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('backend.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if(Customer::create($data)){

           return redirect(route('customers.index'))->with('message','Successfully Customer Added');
        }else{

             return redirect()->back()->with('error','Error !! Added Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $customer = Customer::find($id);
        return view('backend.customer.edit' , compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $customer = Customer::find($id);

        if($customer->update($data)){

            return redirect(route('customers.index'))->with('message','Successfully Customer Updated');
        }else{

            return redirect()->back()->with('error','Error !! Update Failed');;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if($customer->delete()){

            return redirect(route('customers.index'))->with('message','Successfully Customer Deleted');
        }else{

            return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }


    public function search(Request $request)
    {
        $customers = Customer::where('customer_name' , 'like' ,'%'.$request->customer_name.'%')
                    ->where('customer_phone', 'like' ,'%'.$request->customer_phone.'%')
                    ->paginate(5);

        return view('backend.customer.index' ,compact('customers'));
    }

    //To get customer profile...
    public function getCustomerProfile($id)
    {
        $data = Customer::getSingleCustomer($id);
        //To fetch all the ordered data of customer...
        $sellingIds = Sell::where('customer_id', $id)->pluck('id');
        $orderData = Parcel::whereIn('order_id', $sellingIds)->get();

        $totalParcelProducts = 0;
        $totalParcelProductPrice = 0;
        if(!empty($orderData)){
            foreach($orderData as $result){
                $totalParcelProducts += 1; 
                $totalParcelProductPrice += $result->courierPackageData->package_price;
            }
        }

        return view('backend.customer.profile.index', compact('data','orderData','totalParcelProducts','totalParcelProductPrice'));
    }
    
}
