<?php

namespace App\Http\Controllers\API;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //To User Register...
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = $request->all();
        $data['verify_code'] = rand(100000, 999999);
        $data['verify_expires_at'] = Carbon::now()->addMinutes(10);

        if(!User::where('mobile', $request->mobile)->first()){
            if($request->password == $request->password_confirmation){
                $data['password'] = Hash::make($request->password);
                if($newUser = User::create($data)){
                    $userRole = Role::where('name', 'admin')->pluck('id');
                    $newUser->assignRole($userRole);

                    $user = User::where('mobile', $request->mobile)->first();
                    // dd($user);
                    $accessToken = $user->createToken('Fcommerce2022')->accessToken;
                    // dd($accessToken);
                    /*mobile send SMS*/
                    $contact = $request->mobile;
                    $text = 'Congratulations! Your Login OTP code is: '. $user->verify_code.' Send By WB SOFTWARES.Please do NOT share your OTP or PIN with others.';
                    $this->sendSMS($contact,$text);

                    /*user id Session*/
                    $id=$user->id;
                    Session::put('user_id',$id);
                
                    $data = [
                        'message' => 'Registration completed, Please verify your account.',
                        'access_token' => $accessToken,
                        'userData' => $user,
                    ];
            
                    return response()->json($data);
                }else{
                    return response()->json([
                        'message'   =>  'Something is wrong.!'
                    ], 500);
                }
            }
            else{
                return response()->json([
                    'message'   =>  'Password and confirm password not matching.!'
                ], 500);
            }
        }else{
            return response()->json([
                'message'   =>  'This number had already taken.!'
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

    //To User Login...
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if($user->status == 1){
                    $tokenData = $user->createToken('Testpaper2022');
                    $token = $tokenData->token;

                    if($token->save()){
                        $data = [
                            'message' => 'Login successfully done.',
                            'access_token' => $tokenData->accessToken,
                            'userData' => $user
                        ];

                        return response()->json($data);
                    }
                }else{
                    return response()->json([
                        'message'   =>  'Sorry, Your number is not verified.!'
                    ], 500);
                }
                
            }else {
                return response()->json([
                    'message'   =>  'Sorry, Password not matching.!'
                ], 500);
            }
        }
        else {
            return response()->json([
                'message'   =>  'Sorry, You are not registered.!'
            ], 500);
        }
    }

    //To Reset Password...
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
        ]);

        if ($validator->fails()) {
        	return response(['errors'=>$validator->errors()->all()], 422);
        }

        $data = $request->all();
        $data['verify_code'] = rand(100000, 999999);
        $data['verify_expires_at'] = Carbon::now()->addMinutes(10);

        $email = $request->email;
        $text = 'Congratulations! Your Login OTP code is: '.$data['verify_code'].' Send By WB SOFTWARES.Please do NOT share your OTP or PIN with others.';
        
        $userData = User::where('email', $request->email)->first();
        if(isset($userData)){
            $this->sendSMSToEmail($email,$text);
            if($userData->update($data)){
                return response()->json([
                    'message'   =>  'OTP has sent to your email, Please verify your email.',
                    'verifyOtp'   =>  $userData->verify_code,
                    'email'   =>  $userData->email
                ], 201);
            }else{
                return response()->json([
                    'message'   =>  'The opt has been sent not again!.'
                ], 500);
            }
        }else{
            return response()->json([
                'message'   =>  'Sorry, You are not registered.!'
            ], 500);
        }
        
    }

    //For send sms to email..
    public function sendSMSToEmail($email,$text)
    {
        $mail_details = [
            'subject' => 'WB SOFTWARES SMS',
            'body' => $text
        ];

        \Mail::to($email)->send(new sendEmail($mail_details));
    }

    //To password update...
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required'],
            'password' => ['required', 'confirmed']
        ]);

        if ($validator->fails()) {
        	return response(['errors'=>$validator->errors()->all()], 422);
        }

        $data = $request->all();
        if($request->password == $request->password_confirmation){
            $data['password'] = Hash::make($request->password);

            $user = User::where('mobile', $request->mobile)->first();
            if($user->update($data)){
                $data = [
                    'message' => 'Password changed successfully, Please login.',
                    'userData' => $user,
                ];
        
                return response()->json($data);
            }else{
                return response()->json([
                    'message'   =>  'Sorry, Password not matching.!'
                ], 500);
            }
        }
        else{
            return response()->json([
				'message'   =>  'Sorry, Something is wrond.!'
			], 500);
        }
    }


    //To logout...
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout successfully done.'
        ]);
    }


    //To verify....
    public function verifyOtp(Request $request)
    {
        $verify_code_mas = User::where('verify_code', $request->verify_code)->first();

        if($verify_code_mas ){
            if( $verify_code_mas->verify_expires_at < (Carbon::now())){

                $verify_code_mas->verify_code = null;
                $verify_code_mas->verify_expires_at = null;
                $verify_code_mas->save();
              
                return response()->json([
                    'message'   =>  'OTP verification time expired, Please resend OTP again.!'
                ], 500);
            
            }else{

                $verify_code_mas->verify_code = null;
                $verify_code_mas->verify_expires_at = null;
                $verify_code_mas->status = 1;
                $verify_code_mas->save();
                return response()->json([
                    'message'   =>  'You are now verified, Please login.',
                ], 201);
            }
           
        }
         return response()->json([
                'message'   =>  'Sorry, OTP not matching.!'
            ], 500);
       
    }

    //To again resend otp...
    public function resendOtp(Request $request)
    {
        $user = User::find($request->user_id);
        $user->verify_code = rand(100000, 999999);
        $user->verify_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        /*mobile send SMS*/
        $text = 'Congratulations! Your Verify Opt. '. $user->verify_code;
        $this->sendSMS($user->mobile,$text);

        if($user){
            return response()->json([
                'message'   =>  'OTP send to your number, Please verify your OTP.!',
                'data'   =>  $user
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry, You are not registered.!'
            ], 500);
        }

    }


    protected function guard()
    {
        return Auth::guard();
    }
}
