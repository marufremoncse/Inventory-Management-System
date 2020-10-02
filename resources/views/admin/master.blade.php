<!DOCTYPE html>
<html>
@include('admin.header')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    @include('admin.top')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('admin.navigation')

    <!-- Content Wrapper. Contains page content -->
    @yield('content')

    <!-- /.content-wrapper -->
    @include('admin.bottom')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('admin.footer')

</body>
</html>
