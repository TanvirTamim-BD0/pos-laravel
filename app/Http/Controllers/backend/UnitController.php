<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Product;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class UnitController extends Controller
{   

    function __construct()
    {
         $this->middleware('permission:unit-list|unit-create|unit-edit|unit-delete', ['only' => ['index','show']]);
         $this->middleware('permission:unit-create', ['only' => ['create','store']]);
         $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $units = Unit::orderBy('id', 'desc')->get();

        return view('backend.unit.index' ,compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.unit.create');
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
            'unit_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        $data['user_id'] = Auth::user()->id;

        if(Unit::create($data)){
           return redirect(route('unit.index'))->with('message','Successfully Unit Added');
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
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
        $unit = Unit::find($id);
        return view('backend.unit.edit' , compact('unit'));
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
            'unit_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $unit = Unit::find($id);
        if($unit->update($data)){
            return redirect(route('unit.index'))->with('message','Successfully Unit Updated');
        }else{
            return redirect()->back()->with('error','Error !! Update Failed');;
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
        $unit = Unit::find($id);

        $defaultUnit = Unit::where('is_default', true)->first();
        $defaultUnitId = $defaultUnit->id;

        if($unit->is_default == false){

            //To check product under this tax...
            $this->updateProductUnitId($unit->id, $defaultUnitId);

            if($unit->delete()){
                return redirect(route('unit.index'))->with('message','Successfully Unit Deleted');
            }else{
                return redirect()->back()->with('error','Error !! Delete Failed');
            }
        }else{
                return redirect()->back()->with('error','Error !! This is default Unit, so you can not delete.!');
            }
    }


    //To update default TaxId  into products....
    public function updateProductUnitId($UnitId,$defaultUnitId)
    {
        //To check product under this brand...
        $getAllProductIds = Product::where('unit_id', $UnitId)->pluck('id');
        Product::whereIn('id', $getAllProductIds)->update(['unit_id' => $defaultUnitId]);
    }


     //To active default unit...
    public function activeDefaultData($id)
    {
        //To get all the unit ids...
        $getAllUnitIds = Unit::pluck('id');

        Unit::whereIn('id', $getAllUnitIds)->update(['is_default' => false]);
        Unit::where('id', $id)->update(['is_default' => true]);
        return redirect()->route('unit.index');
    }
    
    //To inactive default unit...
    public function inDefaultActiveData($id)
    {
        Unit::where('id', $id)->update(['is_default' => false]);
        return redirect()->route('unit.index');
    }

}
