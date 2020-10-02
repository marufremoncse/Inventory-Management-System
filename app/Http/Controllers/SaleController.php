<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Sale;
use App\Sale_detail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = 50;
        $page_name = "Sale History";
        $sale_all = DB::table('sales')->orderBy('id','desc')->paginate($items);
        return view('admin.sale.sale_manage',compact('page_name','sale_all','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Add Sale";
        $all_customer = Customer::all();
        $all_product = Product::all();
        return view('admin.sale.sale_create',compact('page_name','all_customer','all_product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = $request->row_count;

        $sale = new Sale();
        $sale->customer_id = $request->customer_id;
        $sale->employee_id = Auth::id();
        $sale->sale_date = $request->sale_date;
        $sale->fare = $request->fare;
        $sale->labour_charge = $request->labour_charge;
        $sale->other_expenses = $request->other_expenses;
        $sale->total_amount = $request->grand_total_price;
        $sale->total_paid = $request->total_paid;
        $sale->due = $request->due;
        $sale->save();
        $sale_id = Sale::all()->last()->id;

        for($i = 0; $i <$count; $i++){
            $sale_detail = new Sale_detail();
            $sale_detail->sale_id = $sale_id;
            $sale_detail->product_id = $request->product_id[$i];
            $sale_detail->quantity = $request->quantity[$i];
            $sale_detail->rate = $request->rate[$i];
            $sale_detail->total_price = $request->total_price[$i];
            $sale_detail->save();

            $product_amount = Product::where('id','=',$request->product_id[$i])->pluck('quantity_available')->first();
            $product = Product::find($request->product_id[$i]);
            $new_stock = $product_amount - $request->quantity[$i];
            if($new_stock<0)
                $new_stock = 0;
            $product->quantity_available = $new_stock;
            $product->save();
        }
        if($request->add_sale=='Submit')
            return redirect()->route('sale.index')->with('success','Success!!! Your Sale has been Confirmed...');
        return redirect()->route('sale.create')->with('success','Success!!! Your Sale has been Confirmed...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = 50;
        $page_name = $id;
        $sale_details = Sale_detail::where('sale_id','=',$id)->orderBy('sale_id','desc')->paginate($items);
        return view('admin.sale.sale_details',compact('page_name','sale_details','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = "Edit Sale";
        $sale = Sale::find($id);
        return view('admin.sale.sale_edit',compact('page_name','sale'));
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
        $sale = Sale::find($id);
        $sale->total_amount = $request->total_amount;
        $sale->total_paid = $request->total_paid;
        $sale->due = $request->due;
        $sale->save();

        return redirect()->route('sale.index')->with('success','Success!!! Your Sale has been Updated...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $all_sale_detail = Sale_detail::where('sale_id','=',$id)->get();

        foreach ($all_sale_detail as $sale_detail) {
            $product_amount = $sale_detail->quantity;
            $product = Product::find($sale_detail->product_id);
            $product->quantity_available += $product_amount;
            $product->save();
        }
        Sale_detail::where('sale_id','=',$id)->delete();
        Sale::find($id)->delete();
        return redirect()->route('sale.index')->with('success',"Sale has been deleted...");
    }
}
