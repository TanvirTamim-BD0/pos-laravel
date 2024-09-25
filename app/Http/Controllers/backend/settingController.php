<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use DB;
use Spatie\Permission\Models\Permission;

class settingController extends Controller
{   

    function __construct()
    {
        $this->middleware('permission:company-profile-access', ['only' => ['index']]);
    }

    public function index()
    {	
    	$setting = Setting::first();
    	return view('backend.setting.index',compact('setting'));
    }

    public function update(Request $request, $id)
    {
    	$request->validate([
            'company_name'=> 'required',
            'mobile'=> 'required',
        ]);

        $data = $request->all();
        $setting = Setting::find($id);

        if($request->logo_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/logo_image/');
            if(file_exists($destinationPath.$setting->logo_image)){
                if($setting->logo_image != ''){
                    unlink($destinationPath.$setting->logo_image);
                }
            }

            $file = $request->file('logo_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['logo_image'] = $fileName;
        }

        if($setting->update($data)){

            return redirect(route('setting'))->with('message','Successfully Updated');
        }else{

            return redirect()->back()->with('error','Error !! Update Failed');;
        }

    }

}
