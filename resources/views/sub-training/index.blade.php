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
          <h1>{{$trainingStatus->name}} Sub Trainings</h1>
        </div>
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
  </section>


  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            @if ( auth()->user()->role == 'admin')
            <div class="card-header">
              <a href="{{ route('sub-training.create', ['trainingStatus' => $trainingStatus->id]) }}" class="btn btn-primary btn-md"><i class="fas fa-briefcase-medical"></i> &nbsp; Add </a>
            </div>
            @endif

            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Sub Training Name</th>
                      <th>Area</th>
                      <th>Employee</th>
                      <th>Certif Date</th>
                      <th>Status</th>
                      <th>Training Schedule</th>
                      @if (auth()->user()->role == 'admin')
                      <th>Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($trainings as $row)
                    <tr>
                      <td>{{ $row->name }}</td>
                      <td>{{ $row->employee->area->area }}</td>
                      <td>{{ $row->employee->name }}</td>
                      <td>{{ $row->certif_date->format('d/m/y') }}</td>
                      <td>{{ $row->status_text }}</td>
                      <td>{{ $row->training_schedule?->format('d/m/Y') ?? '-' }}</td>
                      @if (auth()->user()->role == 'admin')
                      <td class="d-flex">
                        <a href="{{ route('sub-training.edit', ['trainingStatus' => $trainingStatus->id, 'subTraining' => $row->id]) }}?training_status={{ request('training_status') }}" class="btn btn-sm btn-success mr-3">Edit</a>
                        <form action="{{ route('sub-training.destroy', $row->id) }}" method="post">
                          @csrf
                          @method('delete')

                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this training status?')">Delete</button>
                        </form>
                      </td>
                      @endif
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
