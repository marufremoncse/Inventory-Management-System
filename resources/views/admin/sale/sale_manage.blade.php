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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{$page_name}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Sale ID</th>
                                        <th>Customer Name</th>
                                        <th>Employee Name</th>
                                        <th>Total Amount</th>
                                        <th>Total Paid</th>
                                        <th>Due</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <div style="display: none">
                                        {{$i =  ($sale_all->currentPage()-1)*$items}}
                                    </div>
                                    @foreach($sale_all as $sale)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$sale->id}}</td>
                                            <td>{{\App\Customer::where('id','=',$sale->customer_id)->pluck('name')->first()}}</td>
                                            <td>{{\App\User::where('id','=',$sale->employee_id)->pluck('first_name')->first()}}&nbsp{{\App\User::where('id','=',$sale->employee_id)->pluck('last_name')->first()}}</td>
                                            <td>{{$sale->total_amount}}</td>
                                            <td>{{$sale->total_paid}}</td>
                                            <td>{{$sale->due}}</td>
                                            <td>{{$sale->sale_date}}</td>
                                            <td>
                                                <div class="row">
                                                    <a href="{{route('sale.show',$sale->id)}}"><span title="Details" type="button" class="btn btn-flat btn-info"><i class="fa fa-info-circle"></i></span></a>&nbsp;

                                                    <a href="{{route('sale.edit',$sale->id)}}"><span title="Edit" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                                                    
                                                    <button class="btn btn-flat btn-danger" type="button" data-toggle="modal" data-target="#modal-del{{$sale->id}}" title="Delete"><i class="fa fa-trash"></i></button>
                                                    <!-- </form> -->
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal-del{{$sale->id}}">
                                            <div class="modal-dialog modal-del">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Delete Confirmation</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <p style="text-align: center;">Are you sure to delete?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <form action="{{route('sale.destroy',$sale->id)}}" method="post">
                                                        @csrf
                                                        {{method_field('DELETE')}}
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                              </div>
                                              <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-left: 20px">
                                {{ $sale_all->links() }}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content -->
@endsection


