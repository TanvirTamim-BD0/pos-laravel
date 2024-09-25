<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Hash;
use Carbon\Carbon;
use Auth;

class ProfileController extends Controller
{
    public function getUserData(Request $request)
    {
        $userData = User::where('id', Auth::user()->id)->first();
        if(!empty($userData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'userData'   =>  $userData
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'nullable|min:11|max:11'
        ]);

        $data = $request->all();
        $userData = User::where('id', Auth::user()->id)->first();

        if($request->hasFile('image')) {

            $destinationPath = public_path('uploads/user_img/');
            if(file_exists($destinationPath.$userData->image)){
                if($userData->image != ''){
                    unlink($destinationPath.$userData->image);
                }
            }

            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/user_img'), $imageName);
            $data['image'] = $imageName;
        }else{
            $data['image'] = 'default.jpg';
        }
        
        if($userData->update($data)){
            return response()->json([
                'message' => 'Profile updated successfully.',
                'userData'   =>  $userData
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.'
            ], 500);
        }
    }

    public function profileMobileUpdate(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ]);

        $userData = User::where('id', Auth::user()->id)->first();
        $userData->verify_code = rand(100000, 999999);
        $userData->verify_expires_at = Carbon::now()->addMinutes(10);
        $contact = $request->mobile;
        $text = 'Congratulations! Your Login OTP code is: '. $userData->verify_code.' Send By WB SOFTWARES.Please do NOT share your OTP or PIN with others.';
        $this->sendSMS($contact,$text);
        $mobile = $request->mobile;
        Session::put('selectedMobile',$mobile);

        if($userData->save()){
            return response()->json([
                'message'   =>  'OTP has sent to your mobile, Please verify your mobile.',
                'verifyOtp'   =>  $userData->verify_code,
                'mobile'   =>  $request->mobile
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.'
            ], 500);
        }
    }

    //To Send Verify SMS...
    public function sendSMS($contact, $text){

    	$url = "https://esms.mimsms.com/smsapi";
		$data = [
		    "api_key" => "C20090626197dd85101bd7.34935998",
		    "type" => "text",
		    "contacts" => $contact,
		    "senderid" => "8809612436737",
		    "msg" => $text,
		 ];
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 $response = curl_exec($ch);
		 curl_close($ch);
		 return $response;
        
    }


    //To verify....
    public function profileMobileVerifyOtp(Request $request)
    {
        $verify_code_mas = User::where('verify_code', $request->verify_code)->first();
        $mobileNum = $request->mobile;
        if($verify_code_mas ){
            if( $verify_code_mas->verify_expires_at < (Carbon::now())){

                $verify_code_mas->verify_code = null;
                $verify_code_mas->verify_expires_at = null;
                $verify_code_mas->save();
              
                return response()->json([
                    'message'   =>  'Your Verify Opt has expired. Please Resend Code.'
                ], 500);
            
            }else{

                $verify_code_mas->verify_code = null;
                $verify_code_mas->verify_expires_at = null;
                $verify_code_mas->mobile = $mobileNum;
                $verify_code_mas->status = 1;
                $verify_code_mas->save();

                Session::forget('selectedMobile');
                return response()->json([
                    'message'   =>  'You are verified now, Please login..',
                ], 201);
            }
           
        }
         return response()->json([
                'message'   =>  'Your Opt you have entered does not match'
            ], 500);
       
    }

    public function securityUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        $currentUser = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->old_password,$currentUser->password)) {
            if ($request->password == $request->password_confirmation) {
                User::find($currentUser->id)->update([
                    'password' => Hash::make($request->password)
                ]);

                // $this->userLogout($currentUser->id);
                return response()->json([
                    'message'   =>  'Your password has changed successfully',
                ], 201);
            }else{
                return response()->json([
                    'message'   =>  'Password and Confirm Password do not match.',
                ], 500);
            }
        }else{
            return response()->json([
                'message'   =>  'Old Password do not match.',
            ], 500);
        }
    }


    //To logout...
    public function userLogout($userId)
    {
        $user = User::where('id', $userId)->first();
        $user->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
    }
}
