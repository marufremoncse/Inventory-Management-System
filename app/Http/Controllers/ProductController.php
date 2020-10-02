<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = 50;
        $page_name = 'Products';
        $product_all = DB::table('products')->orderBy('id','desc')->paginate($items);
        return view('product.product_manage',compact('page_name','product_all','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = 'Product Create';
        return view('product.product_create',compact('page_name'));
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
            'product_code'=> 'required',
            'quantity_available'=> 'required',
        ],[
            'name.required'=>"Name is required",
            'product_code.required'=>"Product Code is required",
            'quantity_available.required'=>"Stock is required",
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->product_code = $request->product_code;
        $product->quantity_available = $request->quantity_available;
        $product->save();

        return redirect()->route('product.index')->with('success',"Product created successfully");
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
        $page_name = 'Product Edit';
        $product = Product::find($id);
        return view('product.product_edit',compact('page_name','product'));
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
            'product_code'=> 'required',
            'quantity_available'=> 'required',
        ],[
            'name.required'=>"Name is required",
            'product_code.required'=>"Product Code is required",
            'quantity_available.required'=>"Stock is required",
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->product_code = $request->product_code;
        $product->quantity_available = $request->quantity_available;
        $product->save();

        return redirect()->route('product.index')->with('success',"Product updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product.index')->with('success',"Product deleted successfully");
    }
}
