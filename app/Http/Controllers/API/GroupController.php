<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $groupData=Group::orderBy('id','desc')->get();

        if(!empty($groupData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'groupData'   =>  $groupData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
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
        $request->validate([
            'group_name'=>'required',
        ]);

        $data=$request->all();
        // check User role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(Group::create($data)){
            return response()->json([
                'message' => 'Data saved successfully.',
                'groupData'   =>  $data
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groupData = Group::find($id);
        if(!empty($groupData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'groupData'   =>  $groupData
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry there have no data.'
			], 500);
        }
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
            'group_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        //To fetch single group data...
        $groupData = Group::find($id);

        if($groupData->update($data)){
            return response()->json([
                'message' => 'Data updated successfully.',
                'groupData' =>  $data
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
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
        $groupdData = Group::find($id);
        if($groupdData->delete()){
            return response()->json([
                'message' => 'Data deleted successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    public function activeDefaultGroup($id){
        //To get all the group ids...
        $getAllgroupIds = Group::pluck('id');
        Group::whereIn('id', $getAllgroupIds)->update(['is_default' => false]);

        if(Group::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'Group default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    //To inactive default group...
    public function inActiveDefaultGroup($id)
    {
        if(Group::where('id', $id)->update(['is_default' => false])){
            return response()->json([
                'message' => 'group non-default set successfully.'
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.!'
            ], 500);
        }
    }
}
