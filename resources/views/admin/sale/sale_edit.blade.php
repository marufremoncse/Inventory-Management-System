@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
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
                            <form enctype="multipart/form-data" action="{{route('sale.update',$sale->id)}}" method="post">
                                @csrf
                                {{method_field('PUT')}}
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="sale_id">Sale ID</label>
                                            <input type="number" step="any" class="form-control" id="sale_id" name="sale_id" value="{{$sale->id}}" readonly="readonly">
                                        </div>                          
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{\App\Customer::where('id','=',$sale->customer_id)->pluck('name')->first()}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="employee_name">Employee Name</label>
                                            <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{\App\User::where('id','=',$sale->employee_id)->pluck('first_name')->first()}} {{\App\User::where('id','=',$sale->employee_id)->pluck('last_name')->first()}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="sale_date">Sale Date</label>
                                            <input type="text" class="form-control" id="sale_date" name="sale_date" value="{{$sale->sale_date}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="number" step="any" class="form-control" id="total_amount" name="total_amount" value="{{$sale->total_amount}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="total_paid">Paid</label>
                                            <input type="number" step="any" class="form-control" id="total_paid" name="total_paid" value="{{$sale->total_paid}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="due">Due</label>
                                            <input type="number" step="any" class="form-control" id="due" name="due" value="{{$sale->due}}">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="button" id="calculate" class="btn btn-warning">Calculate</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
        $('#calculate').on('click',function(){
            calculate();
        });
        function calculate(){
                var total_amount = $('#total_amount').val();
                var total_paid = $('#total_paid').val();
                $('#due').val(total_amount-total_paid);
            } 
    </script>
@stop