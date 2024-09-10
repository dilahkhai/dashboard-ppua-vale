@extends('master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('SelainLogin/tablesearch/DataTables/datatables.min.css') }}" />
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
          Data Saved successfully!
        </div>
        @endif

        @if(session()->has('fail'))
        <div class="alert alert-danger" role="alert">
          Failed!
        </div>
        @endif
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            @if(auth()->user()->role == 'admin')
            <div class="card-header">
              <a href="/tambahmcu" class="btn btn-primary btn-md"><i class="fas fa-briefcase-medical"></i> &nbsp; Add </a>
            </div>
            @endif

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
                      @if(auth()->user()->role == 'admin')
                      <th>Update</th>
                      <th>Delete</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @isset($data)
                    @foreach($data as $item)
                    <tr>
                      <td>{{ $item->area?->area }}</td>
                      <td>{{ $item->employee->name }}</td>
                      <td>{{ is_null($item->lastmcu) ? '-' : $item->lastmcu }}</td>
                      <td class="{{ $item->is_due ? 'text-warning' : '' }}">{{ $item->duedate }}</td>
                      <td class="{{ $item->next_mcu_status ? 'text-danger' : '' }}">{{ $item->nextmcu ?? '-' }}</td>
                      <td class="{{ $item->status == 'DONE' && !$item->is_due ? 'text-primary' : ($item->status == 'Active' ? 'text-success' : 'text-warning fw-bold') }}">
                        {{ $item->status == 'DONE' && !$item->is_due ? $item->status : ($item->status == 'Active' ? $item->status : 'Warning') }}
                      </td>
                      @if(auth()->user()->role == 'admin')
                      <td>
                        <a href="/editmcu/{{ $item->id_mcu }}" class="btn btn-sm btn-success mb-1">
                          <i class="fa-solid fa-pen-to-square"></i> Update
                        </a>
                        @if(!is_null($item->nextmcu))
                        <a href="/donemcu/{{ $item->id_mcu }}" class="btn btn-sm btn-primary mb-1"
                          onclick="return confirm('Do you want to update the status to DONE?')">
                          <i class="fa-solid fa-pen-to-square"></i> Done
                        </a>
                        @endif
                      </td>
                      <td>
                        <form action="/deletemcu/{{ $item->id_mcu }}" method="post">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger" onclick="return confirm('yakin ingin menghapus data ?')">
                            <i class="fas fa-trash"></i> DELETE
                          </button>
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
