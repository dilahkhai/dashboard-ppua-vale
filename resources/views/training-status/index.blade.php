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
              <a href="{{ route('training-status.create') }}" class="btn btn-primary btn-md"><i class="fas fa-briefcase-medical"></i> &nbsp; Add </a>
            </div>
            @endif

            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Training Name</th>
                      <th>Area</th>
                      <th>Employee</th>
                      <th>Certif Date</th>
                      <th>Status</th>
                      <th>Training Schedule</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($trainings as $training)
                      <tr>
                        <td>{{ $training->name }}</td>
                        <td>{{ $training->employee->area->area }}</td>
                        <td>{{ $training->employee->name }}</td>
                        <td>{{ $training->certif_date->format('d/m/y') }}</td>
                        <td>{{ $training->status_text }}</td>
                        <td>{{ $training->training_schedule?->format('d/m/Y') ?? '-' }}</td>
                        <td class="d-flex">
                          <a href="{{ route('training-status.edit', $training->id) }}" class="btn btn-sm btn-success mr-3">Edit</a>
                          <form action="{{ route('training-status.destroy', $training->id) }}" method="post">
                            @csrf
                            @method('delete')

                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this training status?')">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                    <tr>
                      <td colspan="8">No Data</td>
                    </tr>
                    @endforelse
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
