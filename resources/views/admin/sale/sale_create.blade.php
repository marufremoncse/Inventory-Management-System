@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @if($message = Session::get('success'))
                <div class="alert alert-info">
                    {{$message}}
                </div>
            @endif
            @if(count($errors)>0)
                <div class="alert alert-danger"  role="alert">
                    <ul>
                        @foreach($errors->all() as $errors)
                            <li>{{$errors}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$page_name}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{$page_name}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{$page_name}} Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form enctype="multipart/form-data" action="{{route('sale.store')}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="customer_sss" class="col-sm-3 col-form-label">Customer<i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-6">
                                                    <select name="customer_id" id="customer_sss" class="form-control " required="" tabindex="1">
                                                        <option value="">Select One</option>
                                                        @foreach($all_customer as $customer)
                                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="col-sm-3">
                                                    <a href="{{route('customer.create')}}">Add Customer</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-4 col-form-label">Sale Date<i class="text-danger">*</i></label>
                                                <div class="col-sm-8">
                                                    <input type="text" tabindex="2" class="form-control" data-inputmask-alias="datetime"
                                                           data-inputmask-inputformat="dd/mm/yyyy" data-mask name="sale_date" value="" id="date" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="margin-top: 10px">
                                        <table class="table table-bordered table-hover" id="saleTable">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Product<i class="text-danger">*</i></th>
                                                <th class="text-center">Quantity<i class="text-danger">*</i></th>
                                                <th class="text-center">Rate<i class="text-danger">*</i></th>
                                                <th class="text-center">Total Amount<i class="text-danger">*</i></th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="addSaleItem">
                                                <tr id="invoice_row">
                                                    <td class="span3 Customer_load">
                                                        <select class="form-control" name="product_id[]" required="">
                                                            <option value="">Select One</option>
                                                            @foreach($all_product as $product)
                                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td class="text-right">
                                                        <input type="number" step="any" name="quantity[]" required="" id="quantity" class="form-control quantity" placeholder="0.00" min="0">
                                                    </td>

                                                    <td class="text-right">
                                                        <input type="number" step="any" name="rate[]" required="" id="rate" class="form-control rate" placeholder="0.00" min="0">
                                                    </td>
                                                    <td class="text-right">
                                                        <input class="form-control total_price" type="number" step="any" name="total_price[]" id="total_price" placeholder="0.00" readonly="readonly">
                                                    </td>
                                                    <td>
                                                        <button style="text-align: right;" class="btn btn-danger delete_row" type="button" value="Delete" tabindex="8">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>
                                                        <input type="button" class="btn btn-info add-invoice-item" name="add-item" value="Add New Item">
                                                    </td>
                                                    <td style="border:none;" colspan="1"></td>
                                                    <td style="text-align:right;"><b>Fare:</b></td>
                                                    <td class="text-right">
                                                        <input type="number" step="any" id="fare" tabindex="-1" class="form-control fare" name="fare" placeholder="0.00">
                                                    </td>
                                                    <td>
                                                        <input type="button" class="btn btn-warning calculate_price" id = "calculate_price" name="calculate_price" value="Calculate">
                                                    </td>   
                                                </tr>
                                                <tr>
                                                    <td style="border:none;" colspan="2"></td>
                                                    <td style="text-align:right;"><b>Labour Charge:</b></td>
                                                    <td class="text-right">
                                                        <input type="number" step="any" id="labour_charge" tabindex="-1" class="form-control labour_charge" name="labour_charge" placeholder="0.00">
                                                    </td>  
                                                </tr>
                                                <tr>
                                                    <td style="border:none;" colspan="2"></td>
                                                    <td style="text-align:right;"><b>Other Expenses:</b></td>
                                                    <td class="text-right">
                                                        <input type="number" step="any" id="other_expenses" tabindex="-1" class="form-control other_expenses" name="other_expenses" placeholder="0.00">
                                                    </td>
                                                </tr>
                                                <tr>                                                    
                                                    <td style="border:none;" colspan="2"></td>
                                                    <td style="text-align:right;"><b>Grand Total:</b></td>
                                                    <td class="text-right">
                                                        <input type="number" id="grand_total_price" tabindex="-1" class="form-control grand_total_price" name="grand_total_price" placeholder="0.00" readonly="readonly">
                                                    </td>                             
                                                    <input type="hidden" name="row_count" id="row_count" value="1">
                                                </tr>
                                                <tr>
                                                    <td style="border:none;" colspan="2"></td>
                                                    <td style="text-align:right;"><b>Total Paid:</b></td>
                                                    <td class="text-right">
                                                        <input type="number" step="any" id="total_paid" tabindex="-1" class="form-control total_paid" name="total_paid" required="" placeholder="0.00">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border:none;" colspan="2"></td>
                                                    <td style="text-align:right;"><b>Due:</b></td>
                                                    <td class="text-right">
                                                        <input type="number" step="any" id="due" tabindex="-1" class="form-control due" name="due" placeholder="0.00" readonly="">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <input type="submit" id="add_sale" class="btn custom_btn custom_fontcolor btn-large" name="add_sale" value="Submit" tabindex="10">
                                            <input type="submit" value="Submit & Add Sale" name="add_sale" class="btn btn-large btn-success" id="add_sale_another" tabindex="11">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('pageSpecificScripts')
    <script>
        var invoice_item = 1;
        $('.add-invoice-item').on('click',function(){
            addrow();
        });
        function addrow() {
            invoice_item++;
            $("#row_count").val(invoice_item);
            var tr = $('#invoice_row');
            $('tbody').append(tr.clone());
        }

        $('tbody').on('click','.delete_row',function () {
            if(invoice_item>1){
                $(this).parent().parent().remove();
                invoice_item--;
                $("#row_count").val(invoice_item);
            }
        });

        $('#calculate_price').on('click',function(){
            calculate();
        });
        $('#add_sale').on('click',function(){
            calculate();
        });
        $('#add_sale_another').on('click',function(){
            calculate();
        });
        function calculate(){
                var i=0;
                var grand_total_price = 0.0;
                for(i=0;i<invoice_item;i++){
                    var quantity = $('.quantity').eq(i).val();
                    var rate = $('.rate').eq(i).val();
                    var total_price = quantity*rate;
                    $(".total_price").eq(i).val(total_price);
                    grand_total_price+=total_price;
                }
                var fare = 0;
                if($('#fare').val()!=''){
                    fare = parseInt($("#fare").val(), 10);
                }
                var labour_charge = 0;
                if($('#labour_charge').val()!=''){
                    labour_charge = parseInt($("#labour_charge").val(), 10);
                }
                var other_expenses = 0;
                if($('#other_expenses').val()!=''){
                    other_expenses = parseInt($("#other_expenses").val(), 10);
                }
                grand_total_price += fare;
                grand_total_price += labour_charge;
                grand_total_price += other_expenses;
                $(".grand_total_price").val(grand_total_price);
                var total_paid = $(".total_paid").val();
                $(".due").val(grand_total_price-total_paid);
            } 
        
    </script>
@stop
