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
                            <form enctype="multipart/form-data" action="{{route('purchase.update',$purchase->id)}}" method="post">
                                @csrf
                                {{method_field('PUT')}}
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="purchase_id">Purchase ID</label>
                                            <input type="text" class="form-control" id="purchase_id" name="purchase_id" value="{{$purchase->id}}" readonly="readonly">
                                        </div>                          
                                        <div class="form-group">
                                            <label for="supplier_name">Supplier Name</label>
                                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="{{\App\Supplier::where('id','=',$purchase->supplier_id)->pluck('name')->first()}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="employee_name">Employee Name</label>
                                            <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{\App\User::where('id','=',$purchase->employee_id)->pluck('first_name')->first()}} {{\App\User::where('id','=',$purchase->employee_id)->pluck('last_name')->first()}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="purchase_date">Purchase Date</label>
                                            <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="{{$purchase->purchase_date}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="number" step="any" class="form-control" id="total_amount" name="total_amount" value="{{$purchase->total_amount}}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="total_paid">Paid</label>
                                            <input type="number" step="any" class="form-control" id="total_paid" name="total_paid" value="{{$purchase->total_paid}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="due">Due</label>
                                            <input type="number" step="any"class="form-control" id="due" name="due" value="{{$purchase->due}}">
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