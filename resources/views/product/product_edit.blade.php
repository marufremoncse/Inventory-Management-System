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
                            <form enctype="multipart/form-data" action="{{route('product.update',$product->id)}}" method="post">
                                @csrf
                                {{method_field('PUT')}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="InputName">Product Name</label>
                                        <input type="text" class="form-control" id="InputName" name="name" placeholder="Product Name" value="{{$product->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="InputCode">Product Code</label>
                                        <input type="text" class="form-control" id="InputCode" name="product_code" placeholder="Product Code" value="{{$product->product_code}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="InputQuantity">Stock</label>
                                        <input type="text" class="form-control" id="InputQuantity" name="quantity_available" placeholder="Stock" value="{{$product->quantity_available}}">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
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
