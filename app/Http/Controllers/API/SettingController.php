<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        if(!empty($setting)){
            return response()->json([
                'Messege' => 'Data load successfully',
                'Setting' => $setting,
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! Data load.',
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
        $request->validate([
            'company_name'=> 'required',
            'mobile'=> 'required',
        ]);

        $data = $request->all();
        $setting = Setting::find($id);

        if($request->logo_image){

            //To remove previous logo image...
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

            return response()->json([
                'success' => 'Update Setting Data successfully added',
                'Update Setting' => $data,
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'Error !! Update Failed.',
            ], 500);
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
        //
    }
}
