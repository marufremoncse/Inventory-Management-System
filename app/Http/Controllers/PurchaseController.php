<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Product;
use App\Purchase;
use App\Purchase_detail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = 50;
        $page_name = "Purchase History";
        $purchase_all = DB::table('purchases')->orderBy('id','desc')->paginate($items);
        return view('admin.purchase.purchase_manage',compact('page_name','purchase_all','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Add Purchase";
        $all_supplier = Supplier::all();
        $all_product = Product::all();
        return view('admin.purchase.purchase_create',compact('page_name','all_supplier','all_product'));
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

        $purchase = new Purchase();
        $purchase->supplier_id = $request->supplier_id;
        $purchase->employee_id = Auth::id();
        $purchase->purchase_date = $request->purchase_date;
        $purchase->total_amount = $request->grand_total_price;
        $purchase->total_paid = $request->total_paid;
        $purchase->due = $request->due;
        $purchase->save();
        $purchase_id = Purchase::all()->last()->id;

        for($i = 0; $i <$count; $i++){
            $purchase_detail = new Purchase_detail();
            $purchase_detail->purchase_id = $purchase_id;
            $purchase_detail->product_id = $request->product_id[$i];
            $purchase_detail->first_weight = $request->first_weight[$i];
            $purchase_detail->second_weight = $request->second_weight[$i];
            $purchase_detail->less = $request->less[$i];
            $purchase_detail->main_weight = $request->main_weight[$i];
            $purchase_detail->rate = $request->rate[$i];
            $purchase_detail->total_price = $request->total_price[$i];
            $purchase_detail->save();

            $product_amount = Product::where('id','=',$request->product_id[$i])->pluck('quantity_available')->first();
            $product = Product::find($request->product_id[$i]);
            $product->quantity_available = $product_amount + $request->main_weight[$i];
            $product->save();
        }
        if($request->add_purchase=='Submit')
            return redirect()->route('purchase.index')->with('success','Success!!! Your Purchase has been Confirmed...');
        return redirect()->route('purchase.create')->with('success','Success!!! Your Purchase has been Confirmed...');
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
        $purchase_details = Purchase_detail::where('purchase_id','=',$id)->orderBy('purchase_id','desc')->paginate($items);
        return view('admin.purchase.purchase_details',compact('page_name','purchase_details','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = "Edit Purchase";
        $purchase = Purchase::find($id);
        return view('admin.purchase.purchase_edit',compact('page_name','purchase'));
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
        $purchase = Purchase::find($id);
        $purchase->total_amount = $request->total_amount;
        $purchase->total_paid = $request->total_paid;
        $purchase->due = $request->due;
        $purchase->save();

        return redirect()->route('purchase.index')->with('success','Success!!! Your Purchase has been Updated...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $all_purchase_detail = Purchase_detail::where('purchase_id','=',$id)->get();

        foreach ($all_purchase_detail as $purchase_detail) {
            $product_amount = $purchase_detail->main_weight;
            $product = Product::find($purchase_detail->product_id);
            $product->quantity_available -= $product_amount;
            $product->save();
        }
        Purchase_detail::where('purchase_id','=',$id)->delete();
        Purchase::find($id)->delete();
        return redirect()->route('purchase.index')->with('success',"Purchase has been deleted...");
    }
}
