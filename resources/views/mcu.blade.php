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
          <h1>Growth</h1>
        </div>
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
          Data Saved succesfully!
        </div>
        @endif

        @if(session()->has('fail'))
        <div class="alert alert-danger" role="alert">
          Failed!
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
              <a href="/tambahmcu" class="btn btn-primary btn-md"><i class="fas fa-briefcase-medical"></i> &nbsp; Add </a>
            </div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Area</th>
                      <th>Name</th>
                      <th>Last MCU</th>
                      <th>Due Date</th>
                      <th>Next MCU</th>
                      <th>Status</th>
                      @if (auth()->user()->role == 'admin')
                      <th>Update</th>
                      <th>Delete</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @isset($data)
                    @foreach ($data as $item)
                    <tr>
                      <td>{{ $item->area?->area }}</td>
                      <td>{{$item->employee->name}}</td>
                      <td>{{$item->lastmcu}}</td>
                      <td class="{{ $item->is_due ? 'text-warning' : '' }}">{{$item->duedate}}</td>
                      <td>{{$item->nextmcu ?? "-" }}</td>
                      @if ($item->status == "DONE")
                      <td class="text-primary"> {{$item->status}}</td>

                      @else
                      <td class="text-warning fw-bold"> UNDONE</td>
                      @endif
                      @if (auth()->user()->role == 'admin')
                      <td>
                        <a href="/editmcu/{{$item->id_mcu}}" class="btn btn-success btn-md"><i class="fa-solid fa-pen-to-square"></i> Update </a>
                        @if ( auth()->user()->role == 'admin')
                        @if ($item->status != "DONE")
                        <a href="/donemcu/{{$item->id_mcu}}" class="btn btn-primary" onclick="return confirm('Do you want to update the status to DONE?')"><i class="fa-solid fa-pen-to-square"></i> Done! </a>
                        @endif
                        @if ($item->status == "DONE")
                        <a href="/undonemcu/{{$item->id_mcu}}" class="btn btn-warning" onclick="return confirm('Do you want to update the status to UNDONE?')"><i class="fa-solid fa-pen-to-square"></i> Undone! </a>
                        @endif
                        @endif
                      </td>
                      <td>
                        <form action="/deletemcu/{{$item->id_mcu}}" method="post">
                          {{csrf_field()}}
                          {{method_field('DELETE')}}
                          <button type="submit" class="btn btn-danger" onclick="return confirm('yakin ingin menghapus data ?')">
                            <i class="fas fa-trash"></i> DELETE </button>
                        </form>
                      </td>
                      @endif
                    </tr>
                    @endforeach

                    @endisset
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
