<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyInvoiceProfile;
use DB;
use Spatie\Permission\Models\Permission;

class CompanyInvoiceProfileController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:company-invoice-access', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyInvoiceProfile = CompanyInvoiceProfile::first();
        return view('backend.companyInvoiceProfile.index',compact('companyInvoiceProfile'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=> 'required',
            'mobile'=> 'required',
        ]);

        $companyInvoiceProfile = CompanyInvoiceProfile::find($id);

        $data = $request->all();

        if($request->shop_logo){
            //To remove previous file...
            $destinationPath = public_path('uploads/shop_logo/');
            if(file_exists($destinationPath.$companyInvoiceProfile->shop_logo)){
                if($companyInvoiceProfile->shop_logo != ''){
                    unlink($destinationPath.$companyInvoiceProfile->shop_logo);
                }
            }

            $file = $request->file('shop_logo');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['shop_logo'] = $fileName;
        }

        if($request->billing_seal){
            //To remove previous file...
            $destinationPath = public_path('uploads/billing_seal/');
            if(file_exists($destinationPath.$companyInvoiceProfile->billing_seal)){
                if($companyInvoiceProfile->billing_seal != ''){
                    unlink($destinationPath.$companyInvoiceProfile->billing_seal);
                }
            }

            $file = $request->file('billing_seal');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['billing_seal'] = $fileName;
        }


        if($request->billing_signature){
            //To remove previous file...
            $destinationPath = public_path('uploads/billing_signature/');
            if(file_exists($destinationPath.$companyInvoiceProfile->billing_signature)){
                if($companyInvoiceProfile->billing_signature != ''){
                    unlink($destinationPath.$companyInvoiceProfile->billing_signature);
                }
            }

            $file = $request->file('billing_signature');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['billing_signature'] = $fileName;
        }


        if($request->trade_license){
            //To remove previous file...
            $destinationPath = public_path('uploads/trade_license/');
            if(file_exists($destinationPath.$companyInvoiceProfile->trade_license)){
                if($companyInvoiceProfile->trade_license != ''){
                    unlink($destinationPath.$companyInvoiceProfile->trade_license);
                }
            }

            $file = $request->file('trade_license');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['trade_license'] = $fileName;
        }

        if($companyInvoiceProfile->update($data)){

            return redirect(route('companyInvoiceProfile'))->with('message','Successfully Updated');
        }else{

            return redirect()->back()->with('error','Error !! Update Failed');;
        }
    }

    
}
