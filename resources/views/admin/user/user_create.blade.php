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
                        <form enctype="multipart/form-data" action="{{route('user.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="InputFirstName">First Name</label>
                                    <input type="text" class="form-control" id="InputFirstName" name="first_name" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="InputLastName">Last Name</label>
                                    <input type="text" class="form-control" id="InputLastName" name="last_name" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="InputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="InputEmail1" name="email" placeholder="Email Address ex. abc@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="InputMobile">Mobile Number</label>
                                    <input type="text" class="form-control" id="InputMobile" name="mobile" placeholder="Mobile Number">
                                </div>
                                <div class="form-group">
                                    <label for="InputAddress">Address</label>
                                    <input type="text" class="form-control" id="InputAddress" name="address" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <label for="InputPassword">Password</label>
                                    <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="InputConfirmPassword1">Confirm Password</label>
                                    <input type="password" class="form-control" id="InputConfirmPassword" name="confirmPassword" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Profile Picture</label>
                                    <div class="input-group">

                                            <label class="custom-file-label" for="InputFile">Choose Your Image</label>
                                            <input type="file" class="custom-file-input" id="InputFile" name="image">

                                    </div>
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
@section('pageSpecificScript')
    <!-- bs-custom-file-input -->
    <script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection