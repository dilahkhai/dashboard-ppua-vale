@extends('master')
@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Access</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Data</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="/updatemcu/{{$data->id_mcu}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Name</label>
                  <input readonly type="text" class="form-control" name="name" id="exampleInputPassword1" placeholder="Name" value="{{$data->employee->name}}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Last MCU</label>
                  <input type="date" class="form-control" name="lastmcu" id="exampleInputPassword1" placeholder="Last MCU" value="{{$data->lastmcu}}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Due Date</label>
                  <input type="date" class="form-control" name="duedate" id="exampleInputPassword1" placeholder="Due Date" value="{{$data->duedate}}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Next MCU</label>
                  <input type="date" class="form-control" name="nextmcu" id="exampleInputPassword1" placeholder="Due Date" value="{{$data->nextmcu}}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Submit </button>
                </div>
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
