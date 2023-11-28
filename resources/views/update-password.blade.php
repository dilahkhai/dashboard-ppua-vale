@extends('master')
@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Password</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        Data Saved succesfully!
      </div>
      @endif
      @if(session()->has('fail'))
      <div class="alert alert-warning" role="alert">
        {{ session('fail') }}
      </div>
      @endif
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Password</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="/update-password" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="password" required class="form-control" name="old_password" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" required class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password Confirmation</label>
                  <input type="password" required class="form-control" name="password_confirmation" id="exampleInputPassword1" placeholder="Password">
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Submit </button>
                </div>

                <!-- /.card-body -->


                <!-- /.card-body -->
              </div>
              <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>
@endsection
