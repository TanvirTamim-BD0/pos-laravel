<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;
use Carbon\Carbon;
use Auth;
use App\Models\Stock;
use App\Models\Product;
use App\Models\PurchaseBatch;
use Spatie\Permission\Models\Permission;

class SellReportController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sale-todays-report-access', ['only' => ['sellTodaysReport']]);
         $this->middleware('permission:sale-weekend-report-access', ['only' => ['currentWeekendReport']]);
         $this->middleware('permission:sale-month-report-access', ['only' => ['currentMonthReport']]);
         $this->middleware('permission:sale-daily-report-access', ['only' => ['dailyReport','dailyReportWithDate']]);
         $this->middleware('permission:sale-monthly-report-access', ['only' => ['monthlyReport','monthlyReportWithMonthName']]);
         $this->middleware('permission:sale-between-report-access', ['only' => ['reportWithBetweenDates','reportWithBetweenTwoDates']]);
    }

    //To fetch user id...
    public function getUserId()
    {
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager' || Auth::user()->role == 'staff'){
            $userId = Auth::user()->admin_id;
        }

        return $userId;
    }

    //To fetch all the selling reports of today...
    public function sellTodaysReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch today date...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', $todayDate)->where('selling_status',1)->get();

        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.todayReport', compact('sellsData','totalProductPrice','totalSellingPrice'));
    }
    
    //To fetch all the selling reports of this weekend...
    public function currentWeekendReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch today date...
        $selectedDate = Carbon::now()->today()->subDays(7)->toDateString();
       
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', '>=', $selectedDate)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.currentWeekendReport', compact('sellsData','totalProductPrice','totalSellingPrice'));
    }
   
    //To fetch all the selling reports of this month...
    public function currentMonthReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch current month...
        $currentMonth = Carbon::now()->format('m');
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereMonth('created_at', $currentMonth)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.currentMonthReport', compact('sellsData','totalProductPrice','totalSellingPrice'));
    }



    //To fetch daily report with current date...
    public function dailyReport(Request $request)
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch today date...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', $todayDate)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.dailyReport', compact('sellsData','totalProductPrice','totalSellingPrice'));
    }
    
    
    //To fetch daily report with selected date...
    public function dailyReportWithDate(Request $request)
    {
        //To get user id..
        $userId = $this->getUserId();

        //To get selected date...
        $selectedDate = $request->selected_from_date;
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', $selectedDate)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.dailyReport', compact('selectedDate','sellsData','totalProductPrice','totalSellingPrice'));
    }

    //To fetch all the selling reports of current month...
    public function monthlyReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch current month...
        $currentMonth = Carbon::now()->format('m');
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereMonth('created_at', $currentMonth)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        //To get twelve month name...
        $monthNames = [];
        for($i = 01; $i <= 12; $i++){
            $monthNames[] = Carbon::now()->month($i)->format('F');
        }
        
        //To get year from 2000 to 2100 name...
        $years = [];
        for($i = 2000; $i <= 2100; $i++){
            $years[] = $i;
        }

        return view('backend.report.sell.monthlyReport', compact('monthNames','years','sellsData','totalProductPrice','totalSellingPrice'));
    }
    
    //To fetch all the selling reports with selected month names...
    public function monthlyReportWithMonthName(Request $request)
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch selected month...
        $selectedMonth = $request->selected_month_name;
        $currentMonth = Carbon::parse('1 '.$selectedMonth)->month;
        
        //To catch selected year...
        $selectedYear = $request->selected_year_name;
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereYear('created_at', $selectedYear)->whereMonth('created_at', $currentMonth)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        //To get twelve month name...
        $monthNames = [];
        for($i = 01; $i <= 12; $i++){
            $monthNames[] = Carbon::now()->month($i)->format('F');
        }

        //To get year from 2000 to 2100 name...
        $years = [];
        for($i = 2000; $i <= 2100; $i++){
            $years[] = $i;
        }

        return view('backend.report.sell.monthlyReport', compact('monthNames','years','selectedMonth','selectedYear','sellsData','totalProductPrice','totalSellingPrice'));
    }

    //To fetch report with current date...
    public function reportWithBetweenDates(Request $request)
    {
        //To get user id..
        $userId = $this->getUserId();

       //To catch current month...
       $currentMonth = Carbon::now()->format('m');
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereMonth('created_at', $currentMonth)->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.betweenWithDatesReport', compact('sellsData','totalProductPrice','totalSellingPrice'));
    }

    //To fetch daily report with selected two date...
    public function reportWithBetweenTwoDates(Request $request)
    {
        //To get user id..
        $userId = $this->getUserId();

        //To get selected date...
        $selectedFromDate = $request->selected_from_date;
        $selectedToDate = $request->selected_to_date;
        
        //To fetch all the selling data from table...
        $sellsData = Sell::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereBetween('created_at', [$selectedFromDate,$selectedToDate])->where('selling_status',1)->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $totalSellingPrice = 0;
        foreach($sellsData as $data){
            if(isset($data) && $data->customer_id != null){
                $totalProductPrice += $data->sellPaymentData->total_amount;
                $totalSellingPrice += $data->sellPaymentData->selling_amount;
            }
        }

        return view('backend.report.sell.betweenWithDatesReport', compact('selectedFromDate','selectedToDate','sellsData','totalProductPrice','totalSellingPrice'));
    }



   /* public function stockAlertReport(){
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $productData = Product::where('user_id', $userId)->get();

        return view('backend.report.stock_alert_report' , compact('productData'));
     
    }


    public function stockAlertReportSearch(Request $request){

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        //To get selected date...
        $selectedFromDate = $request->selected_from_date;
        $selectedToDate = $request->selected_to_date;

        $productData = Product::whereBetween('created_at', [$selectedFromDate,$selectedToDate])->get();

        return view('backend.report.stock_alert_report' , compact('productData'));
    }*/



}
