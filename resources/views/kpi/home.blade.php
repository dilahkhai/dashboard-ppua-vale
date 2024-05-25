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
          <h1>Key Performance Index</h1>
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

        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Area</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($areas as $area)
                <tr>
                  <td>{{ $area->area }}</td>
                  <td class="">
                    <div class="d-flex">
                      <a href="{{ route('key-performance-index.index', $area->id) }}" class="btn btn-sm btn-primary mr-1">Input</a>
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
@endpush
