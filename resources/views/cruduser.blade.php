@extends('master')
@section('css')
{{-- <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('SelainLogin/tablesearch/DataTables/datatables.min.css')}}" />
@endsection
@section('content')

<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User PPU</h1>
        </div>
      </div>
      <div class="row">
        @if(session()->has('success'))
        <div class="alert alert-success w-100" role="alert">
          {{ session('success') }}
        </div>
        @endif

        @if(session()->has('fail'))
        <div class="alert alert-danger" role="alert">
          {{ session('fail') }}
        </div>
        @endif
      </div>
    </div><!-- /.container-fluid -->
  </section>


  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            @if ( auth()->user()->role == 'admin')
            <div class="card-header">
              <a href="/tambahuser" class="btn btn-primary btn-md"><i class="fas fa-user-plus"></i> Add User</a>
            </div>
            @endif


            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      {{-- <th>id</th> --}}
                      <th>Name</th>
                      <th>Area</th>
                      <th>Username</th>

                      @if ( auth()->user()->role == 'admin')
                      <th>Update</th>
                      <th>Delete</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                    <tr>
                      {{-- <td>{{$item->id}}</td> --}}
                      <td>{{$item->name}}</td>
                      <td>{{$item->area->area}}</td>
                      <td>{{$item->username}}</td>

                      @if ( auth()->user()->role == 'admin')
                      <td class="d-flex">
                        <a href="/edituser/{{$item->id}}" class="btn btn-success btn-md mr-3"><i class="fa-solid fa-pen-to-square"></i> Update </a>
                        <form action="/resetpassword/{{ $item->id }}" method="post">
                          @csrf
                          <button type="submit" class="btn btn-success btn-md" onclick="return confirm('Apakah anda yakin akan mereset password user ini?')"><i class="fa-solid fa-pen-to-square"></i> Reset Password </button>
                        </form>
                      </td>
                      <td>
                        <form action="/deleteuser/{{$item->id}}" method="post">
                          {{csrf_field()}}
                          {{method_field('DELETE')}}
                          <button type="submit" class="btn btn-danger" onclick="return confirm('yakin ingin menghapus data ?')">
                            <i class="fas fa-trash"></i> DELETE </button>
                        </form>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>

                </table>
              </div>
            </div>

            @include('sweetalert::alert')
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('SelainLogin/tablesearch/DataTables/datatables.min.js')}}"></script>

<script src="SelainLogin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="SelainLogin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="SelainLogin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="SelainLogin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="SelainLogin/plugins/jszip/jszip.min.js"></script>
<script src="SelainLogin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="SelainLogin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>




{{-- <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

<script>
  $(document).ready(function() {
    $('#tabeluser').DataTable();
  });
</script>



<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
@endpush
