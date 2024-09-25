<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Auth;
use Carbon\Carbon;

class PurchaseReportController extends Controller
{

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


    public function purchaseTodaysReport()
    {
       //To get user id..
        $userId = $this->getUserId();

        //To catch today date...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', $todayDate)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }


        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }



    //To fetch all the selling reports of this weekend...
    public function currentWeekendReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch today date...
        $selectedDate = Carbon::now()->today()->subDays(7)->toDateString();
       
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', '>=', $selectedDate)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }

       
       if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }



    //To fetch all the selling reports of this month...
    public function currentMonthReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch current month...
        $currentMonth = Carbon::now()->format('m');
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
         ->whereMonth('created_at', $currentMonth)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }

        
         if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }


    //To fetch daily report with current date...
    public function dailyReport()
    {
       //To get user id..
        $userId = $this->getUserId();

        //To catch today date...
        $todayDate = Carbon::now()->today()->toDateString();
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', $todayDate)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }

        
        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }



    //To fetch daily report with selected date...
    public function dailyReportWithDate(Request $request)
    {
       //To get user id..
        $userId = $this->getUserId();

        //To get selected date...
        $selectedDate = $request->selected_from_date;
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereDate('created_at', $selectedDate)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }

        
        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }



    //To fetch all the selling reports of current month...
    public function monthlyReport()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch current month...
        $currentMonth = Carbon::now()->format('m');
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
         ->whereMonth('created_at', $currentMonth)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
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


        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
                'monthNames'   =>  $monthNames,
                'years'   =>  $years,

            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

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
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
         ->whereYear('created_at', $selectedYear)->whereMonth('created_at', $currentMonth)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
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


        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
                'monthNames'   =>  $monthNames,
                'years'   =>  $years,
                
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }



    //To fetch report with current date...
    public function reportWithBetweenDates()
    {
        //To get user id..
        $userId = $this->getUserId();

        //To catch current month...
        $currentMonth = Carbon::now()->format('m');
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
         ->whereMonth('created_at', $currentMonth)->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }

        
        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }


    //To fetch report with current date...
    public function reportWithBetweenTwoDates(Request $request)
    {
        //To get user id..
        $userId = $this->getUserId();

         //To get selected date...
        $selectedFromDate = $request->selected_from_date;
        $selectedToDate = $request->selected_to_date;
        
        //To fetch all the selling data from table...
        $purchaseData = Purchase::orderBy('id', 'desc')->where('user_id', $userId)
        ->whereBetween('created_at', [$selectedFromDate,$selectedToDate])->where('purchase_status',1)->with(['supplierData'])->get();
        
        //To calculate total product price and selling price...
        $totalProductPrice = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        foreach($purchaseData as $data){
            if(isset($data)){
                $totalProductPrice += $data->purchasePaymentData->purchase_amount;
                $paidAmount += $data->purchasePaymentData->paid_amount;
                $dueAmount += $data->purchasePaymentData->due_amount;
            }
        }

       
       if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
                'totalProductPrice'   =>  $totalProductPrice,
                'paidAmount'   =>  $paidAmount,
                'dueAmount'   =>  $dueAmount,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }
    

}
