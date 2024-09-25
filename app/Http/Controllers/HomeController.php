<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Sell;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Damage;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
         //Sell today ...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('selling_status',1)->whereDate('created_at', $todayDate)->get();
        
        //To calculate total product price and selling price...
        $todaySellingPrice = 0;
        foreach($sellsData as $data){
            if($data != null){
                $todaySellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        //Total Sell ...
        $totalSellsData = Sell::orderBy('id', 'desc')->get();
        
        //To calculate total product price and selling price...
        $totalSellingPrice = 0;
        foreach($totalSellsData as $data){
            if(isset($data->sellPaymentData)){
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        //purchase today...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('purchase_status',1)->whereDate('created_at', $todayDate)->get();
        
        //To calculate total product price and selling price...
        $todaypurchasePrice = 0;
        foreach($purchaseData as $data){
            if(isset($data->purchasePaymentData)){
                $todaypurchasePrice += $data->purchasePaymentData->purchase_amount;
            }
        }

        //total purchase...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->whereDate('created_at', $todayDate)->get();
        
        //To calculate total product price and selling price...
        $totalpurchasePrice = 0;
        foreach($purchaseData as $data){
            if(isset($data->purchasePaymentData)){
                $totalpurchasePrice += $data->purchasePaymentData->purchase_amount;
            }
        }

         //purchase today date...
        $totalPurchaseData = Purchase::orderBy('id', 'desc')->get();
        
        //To calculate total product price and selling price...
        $totalpurchasePrice = 0;
        foreach($totalPurchaseData as $data){
            if(isset($data->purchasePaymentData)){
                $totalpurchasePrice += $data->purchasePaymentData->purchase_amount;
            }
        }


        //Sell today ...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $expenseData = Expense::orderBy('id', 'desc')->whereDate('created_at', $todayDate)->get();
        //To calculate total product price and selling price...
        $todayExpensePrice = 0;
        foreach($expenseData as $data){
                $todayExpensePrice += $data->amount;
        }


        //Total Sell ...
        $totalExpenseData = Expense::orderBy('id', 'desc')->get();
        
        //To calculate total product price and selling price...
        $totalExpensePrice = 0;
        foreach($totalExpenseData as $data){
            $totalExpensePrice += $data->amount;
        }



        $currentMonth = Carbon::now()->format('m');
        $month = date("F", strtotime('m'));

        //To fetch all the selling data from table...
        $sellsdData = Sell::orderBy('id', 'desc')->whereMonth('created_at', $currentMonth)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalMonthSellingPrice = 0;
        foreach($sellsdData as $data){
            if(isset($data)){
                $totalMonthSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }


        $purchasesData = Purchase::orderBy('id', 'desc')
         ->whereMonth('created_at', $currentMonth)->where('purchase_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalMonthPurchasePrice = 0;
        foreach($purchasesData as $data){
            if(isset($data)){
                $totalMonthPurchasePrice += $data->purchasePaymentData->purchase_amount;
            }
        }


        // total stock
        $totalStock = Stock::count();

        //total Damage
        $totalDamage = Damage::count();

         //total Customer
        $totalCustomer = Customer::count();

         //total Supplier
        $totalSupplier = Supplier::count();

        //total Product
        $totalProduct = Product::count();

        //total Product
        $totalUser = User::count();

        $totalCategory = Category::count();

        $totalBrand = Brand::count();


        return view('backend.dashboard', compact('todaySellingPrice','totalSellingPrice','todaypurchasePrice','totalpurchasePrice','totalStock','totalDamage','totalCustomer','totalSupplier','totalProduct','totalUser','totalExpensePrice','todayExpensePrice','totalMonthSellingPrice','totalMonthPurchasePrice','month','totalCategory','totalBrand'));
    }


    public function logout()
    {
         Auth::guard('web')->logout();
         return Redirect()->route('login');
    }

    
}
