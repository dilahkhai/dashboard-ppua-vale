@extends('master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Schedule Sharing Knowledge</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->

          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->

          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->

          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->

          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->



          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->




            <!-- Calendar -->



            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Schedule
                </h3>

                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">

                  </div>


                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>


            <div class="card-body">
              @if(Auth::user()->role=='admin')
                <form role="form" action="/sharingknowledge"  method="POST" enctype="multipart/form-data"  >
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" >Upload File</label>
                                <input type="file" name="fileupload" required  >
                              </div>
                        </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Submit </button>
                    </div>


                  </form>
                @endif

            </div>

            <div class="container-fluid">

                {{-- <!-- Page Heading -->

                <div class="page-heading">
                  <h3>Schedule Sharing Knowledge

                  </h3>
              </div> --}}

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">




                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                           @isset($knowledge)
                              <img src="{{$knowledge->file}}" width="100%" alt="not found!">
                          @endisset

                                {{-- <thead>
                                    <tr>
                                        <th>file</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($knowledge as $item)
                                    <tr>

                                        <td><iframe height="700"  width="100%"  src="{{$item->file}}" frameborder="0"></iframe></td>


                                      </tr>
                                    @endforeach

                                </tbody> --}}




                        </div>
                    </div>
                </div>

            </div>

            <!-- /.card -->

          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
