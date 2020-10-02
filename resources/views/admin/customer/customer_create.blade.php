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
                        <form enctype="multipart/form-data" action="{{route('customer.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="InputName">Name</label>
                                    <input type="text" class="form-control" id="InputName" name="name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="InputMobile">Mobile Number</label>
                                    <input type="text" class="form-control" id="InputMobile" name="mobile" placeholder="Mobile Number">
                                </div>
                                <div class="form-group">
                                    <label for="InputAddress">Address</label>
                                    <input type="text" class="form-control" id="InputAddress" name="address" placeholder="Address">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
