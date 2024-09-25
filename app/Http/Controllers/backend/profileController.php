<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Auth;
use Hash;
use Carbon\Carbon;
use Validator;
use Session;
use Spatie\Permission\Models\Permission;

class profileController extends Controller
{   
    public function index(){
    	return view('backend.profile.index');
    }

     public function Update(Request $request)
    {
    	$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required',
        ]);

        $id = Auth::user()->id;

        $User = User::find($id);
        $User->name = $request->name;
        $User->email = $request->email;
        $User->mobile = $request->mobile;

        if($request->hasFile('image')) {
            $destinationPath = public_path('uploads/user_img/');
            if(file_exists($destinationPath.$User->image)){
                if($User->image != ''){
                    unlink($destinationPath.$User->image);
                }
            }

            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/user_img'), $imageName);
            $User->image = $imageName;

        }

        $User->save();

        return redirect(route('profile'))->with('message','Successfully Profile Updated');;
    }


    public function security()
    {
    	return view('backend.profile.security');
    }

    public function securityUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        $current_user = Auth()->user();

        if (Hash::check($request->old_password,$current_user->password)) {

            if ($request->new_password == $request->confirm_password) {

                User::find($current_user->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);

                Auth::logout();
                return Redirect()->route('login');

            }else{
                return redirect()->route('security')->with('error','Password and Confirm Password do not match');
            }

        }else{
            return redirect()->route('security')->with('error','Old Password do not match');
        }
    }


}
