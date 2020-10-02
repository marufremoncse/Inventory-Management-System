<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = 50;
        $page_name = "Supplier Management";
        $supplier_all = DB::table('suppliers')->orderBy('id','desc')->paginate($items);
        return view('admin.supplier.supplier_manage',compact('page_name','supplier_all','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Supplier Create";
        return view('admin.supplier.supplier_create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'mobile'=> 'required|numeric|min:11',
            'address'=>'required',
            'shop_name'=>'required',
        ],[
            'name.required'=>"Name is required",
            'mobile.required'=>"Mobile number is required",
            'address.required'=>"Address is required",
            'shop_name.required'=>"Shop Name is required",
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->mobile = $request->mobile;
        $supplier->address = $request->address;
        $supplier->shop_name = $request->shop_name;
        $supplier->save();

        return redirect()->route('supplier.index')->with('success',"Supplier created successfully");
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
        $page_name = "Edit Supplier";
        $supplier = Supplier::find($id);
        return view('admin.supplier.supplier_edit',compact('page_name','supplier'));
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
        $this->validate($request,[
            'name'=>'required',
            'mobile'=> 'required|numeric|min:11',
            'address'=>'required',
            'shop_name'=>'required',
        ],[
            'name.required'=>"Name is required",
            'mobile.required'=>"Mobile number is required",
            'address.required'=>"Address is required",
            'shop_name.required'=>"Shop Name is required",
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->mobile = $request->mobile;
        $supplier->address = $request->address;
        $supplier->shop_name = $request->shop_name;
        $supplier->save();

        return redirect()->route('supplier.index')->with('success',"Supplier updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::find($id)->delete();
        return redirect()->route('supplier.index')->with('success',"Supplier deleted successfully");
    }
}
