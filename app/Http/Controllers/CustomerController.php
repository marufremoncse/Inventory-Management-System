<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = 50;
        $page_name = "Customer Management";
        $customer_all = DB::table('customers')->orderBy('id','desc')->paginate($items);
        return view('admin.customer.customer_manage',compact('page_name','customer_all','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Customer Create";
        return view('admin.customer.customer_create',compact('page_name'));
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
        ],[
            'name.required'=>"Name is required",
            'mobile.required'=>"Mobile number is required",
            'address.required'=>"Address is required",
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customer.index')->with('success',"Customer created successfully");
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
        $page_name = "Edit Customer";
        $customer = Customer::find($id);
        return view('admin.customer.customer_edit',compact('page_name','customer'));
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
        ],[
            'name.required'=>"Name is required",
            'mobile.required'=>"Mobile number is required",
            'address.required'=>"Address is required",
        ]);

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customer.index')->with('success',"Customer updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customer.index')->with('success',"Customer deleted successfully");
    }
}
