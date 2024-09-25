<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseBatch;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::orderBy('id', 'desc')->get();
        if(!empty($stocks)){
            return response()->json([
                'Messege' => 'Data load successfully',
                'stocks' => $stocks
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! error to data loaded'
            ], 500);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function stockAlert()
    {
        $stocks = Stock::orderBy('id', 'desc')->get();
        // $productData = Product::orderBy('id','desc')->get();
        if(!empty($stocks)){
            return response()->json([
                'Messege' => 'Data load successfully',
                'stocks' => $stocks
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! error to data loaded'
            ], 500);
        }

    }
}
