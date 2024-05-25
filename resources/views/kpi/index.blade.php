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
          <h1>Key Performance Index for {{ $area->area }}</h1>
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
    </div><!-- /.container-fluid -->
  </section>


  <section class="content">
    <div class="container-fluid">
      <div class="card">

        @if ( auth()->user()->role == 'admin')
        <div class="card-header">
          <a href="{{ route('key-performance-index.create', $area->id) }}" class="btn btn-primary btn-md"><i class="fas fa-briefcase-medical"></i> &nbsp; Add </a>
        </div>
        @endif

        <!-- /.card-header -->
        <div class="card-body">
          <div class="">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th rowspan="2">Title</th>
                  @foreach ($users as $user)
                  <th colspan="4">{{ $user->name }}</th>
                  @endforeach
                  <th rowspan="2">Action</th>
                </tr>
                <tr>
                  @foreach ($users as $user)
                  <td>Plan</td>
                  <td>Actual</td>
                  <td>Remark</td>
                  <td>Progress</td>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @forelse ($indexes as $index)
                <tr>
                  <td>{{ $index->title }}</td>
                  @foreach ($users as $user)
                  <td class="{{ in_array($user->position, $index->allowed) ? '' : 'bg-light' }}">{{ in_array($user->position, $index->allowed) ? (array_key_exists($index->id, $details) ? (array_key_exists($user->id, $details[$index->id]) ? $details[$index->id][$user->id]['plan'] : 0) : 0) : '' }}</td>
                  <td class="{{ in_array($user->position, $index->allowed) ? '' : 'bg-light' }}">{{ in_array($user->position, $index->allowed) ? (array_key_exists($index->id, $details) ? (array_key_exists($user->id, $details[$index->id]) ? $details[$index->id][$user->id]['actual'] : 0) : 0) : '' }}</td>
                  <td class="{{ in_array($user->position, $index->allowed) ? '' : 'bg-light' }}">{{ in_array($user->position, $index->allowed) ? (array_key_exists($index->id, $details) ? (array_key_exists($user->id, $details[$index->id]) ? $details[$index->id][$user->id]['remark'] : '-') : "-") : '' }}</td>
                  <td class="{{ in_array($user->position, $index->allowed) ? '' : 'bg-light' }}">{{ in_array($user->position, $index->allowed) ? (array_key_exists($index->id, $details) ? (array_key_exists($user->id, $details[$index->id]) ? $details[$index->id][$user->id]['status'] : '-') : "-") : '' }}</td>
                  @endforeach
                  <td class="">
                    <div class="d-flex">
                      @if ($index->is_owner)
                      <a href="{{ route('key-performance-index.input', $index->id) }}" class="btn btn-sm btn-primary mr-1">Input</a>
                      @endif
                      @if (auth()->user()->role == 'admin')
                      <a href="{{ route('key-performance-index.edit', $index->id) }}" class="btn btn-sm btn-success mr-1">Edit</a>
                      <form action="{{ route('key-performance-index.destroy', $index->id) }}" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this kpi?')">Delete</button>
                      </form>
                      @endif
                    </div>
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
