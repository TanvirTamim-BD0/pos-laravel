<?php

namespace App\Http\Controllers\backend\userRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use DB;
use Hash;
use Auth;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('id','DESC')->paginate(10);
        return view('backend.userRole.users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 'superadmin'){
            $roles = Role::whereNotIn('name', ['superadmin'])->get();
        }elseif(Auth::user()->role == 'admin'){
            $roles = Role::whereNotIn('name', ['superadmin','admin'])->get();
        }elseif(Auth::user()->role == 'manager'){
            $roles = Role::whereNotIn('name', ['superadmin','admin','manager'])->get();
        }else{
            $roles[] = null;
        }

        return view('backend.userRole.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);
    
        $data = $request->all();
        $userRole = Role::where('id', $request->roles)->first();

        //To set user role..
        if($userRole->name == 'admin'){
            $data['role'] = 'admin';
        }
        if($userRole->name == "manager"){
            $data['role'] = 'manager';
        }
        if($userRole->name == "staff"){
            $data['role'] = 'staff';
        }

        $data['password'] = Hash::make($data['password']);
    
        $user = User::create($data);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')->with('message','Successfully User Added');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == 'superadmin'){
            $roles = Role::whereNotIn('name', ['superadmin'])->get();
        }elseif(Auth::user()->role == 'admin'){
            $roles = Role::whereNotIn('name', ['superadmin','admin'])->get();
        }elseif(Auth::user()->role == 'manager'){
            $roles = Role::whereNotIn('name', ['superadmin','admin','manager'])->get();
        }else{
            $roles[] = null;
        }

        $user = User::find($id);
    
        return view('backend.userRole.users.edit',compact('user','roles'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required'
        ]);
    
        $data = $request->all();
        $userRole = Role::where('id', $request->roles)->first();

        //To set user role..
        if($userRole->name == 'admin'){
            $data['role'] = 'admin';
        }
        if($userRole->name == "manager"){
            $data['role'] = 'manager';
        }
        if($userRole->name == "staff"){
            $data['role'] = 'staff';
        }

        
        $user = User::find($id);
        if($user->update($data)){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));
            return redirect()->route('users.index')->with('message','Successfully User Updated');
        }else{
            return redirect()->back()->with('message','Something is wrong.!');
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
        $user = User::findOrFail($id);
        if($user->delete()){
            return redirect()->back()->with('message','Successfully User Deleted');
        }else{
            return redirect()->back()->with('message','Something is wrong.!');;
        }
    }



    //To active user...
    public function userActive($id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        return redirect()->route('users.index')->with('message','Successfully User Active');
    }
    
    //To active user...
    public function userInactive($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return redirect()->route('users.index')->with('error','User Inactive');
    }


    public function userPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

            if ($request->new_password == $request->confirm_password) {

                User::find($id)->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return redirect()->route('users.index')->with('message','Successfully Password Updated');

            }else{
                return redirect()->back()->with('error','Something is wrong.!');
            }

        
    }

}
