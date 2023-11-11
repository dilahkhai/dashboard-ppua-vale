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
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="/updateuser/{{$data->id}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" required name="name" id="exampleInputEmail1" placeholder="Full Name" value="{{$data->name}}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Area</label>
                  <select required class="form-control" name="area" id="">
                    @foreach ($areas as $id => $area)
                    <option {{($id == $data->area_id) ? 'selected' : ''}} value="{{$id}}">{{$area}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Role</label>
                  <select class="form-control" required name="role" id="">
                    <option value="admin">Super Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Username</label>
                  <input type="text" required class="form-control" name="username" id="exampleInputUsername" placeholder="username" value="{{$data->username}}">
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
