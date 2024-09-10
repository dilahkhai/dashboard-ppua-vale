@extends('master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('SelainLogin/tablesearch/DataTables/datatables.min.css') }}" />
@endsection

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="simper mb-2">
        <div class="col-sm-6">
          <h1>SIM Status</h1>
        </div>
      </div>
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        Data Saved successfully!
      </div>
      @endif

      @if(session()->has('fail'))
      <div class="alert alert-danger" role="alert">
        Failed!
      </div>
      @endif
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="simper">
        <div class="col-12">
          <div class="card">
            @if (auth()->user()->role == 'admin')
            <div class="card-header">
              <a href="{{ route('simper.create') }}" class="btn btn-primary btn-md"><i class="fas fa-briefcase-medical"></i> &nbsp; Add </a>
            </div>
            @endif

            <div class="card-body">
              <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Area</th>
                      <th>Employee</th>
                      <th>Certif Date</th>
                      <th>Status</th>
                      <th>Sim Update</th>
                      @if (auth()->user()->role == 'admin')
                      <th>Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($simpers as $simper)
                    <tr>
                      <td>{{ $simper->employee->area->area }}</td>
                      <td>{{ $simper->employee->name }}</td>
                      <td>{{ $simper->certif_date->format('d/m/Y') }}</td>
                      <td class="
                        @if ($simper->status == 1) text-success
                        @elseif ($simper->status == 2) text-warning
                        @elseif ($simper->status == 3) text-danger
                        @endif
                      ">{{ $simper->statusText }}</td>
                      <td>{{ $simper->sim_update->format('d/m/Y') }}</td>
                      @if (auth()->user()->role == 'admin')
                      <td class="d-flex">
                        <a href="{{ route('simper.edit', $simper->id) }}" class="btn btn-sm btn-success mr-3">Edit</a>
                        <form action="{{ route('simper.destroy', $simper->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this sim status?')">Delete</button>
                        </form>
                      </td>
                      @endif
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6">No Data</td>
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
<script type="text/javascript" src="{{ asset('SelainLogin/tablesearch/DataTables/datatables.min.js') }}"></script>
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
