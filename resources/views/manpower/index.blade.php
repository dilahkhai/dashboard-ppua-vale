@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Man Power</h1>
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  @if(session()->has('success'))
  <div class="alert alert-success" role="alert">
    Data Saved succesfully!
  </div>
  @endif
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">Man Power</div>
      <div class="card-body">
        @if (auth()->user()->role == 'admin')
        <a href="{{ route('man-power.create') }}" class="btn btn-sm btn-primary">Input Data</a>
        @endif
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Area</th>
              <th>Leader</th>
              <th>Crew</th>
              <th>Contractor</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($manpowers as $row)
            <tr>
              <td>{{ $row->user->area->area }}</td>
              <td>{{ $row->user->name }}</td>
              <td>{{ $row->crew->total_power }}</td>
              <td>{{ $row->contractor->total_power }}</td>
              <td>{{ $row->date }}</td>
              <td class="d-flex">
                <a href="{{ route('man-power.show', $row->id) }}" class="btn btn-sm btn-primary mr-3">Show</a>
                <a href="{{ route('man-power.edit', $row->id) }}" class="btn btn-sm btn-success mr-3">Edit</a>
                <form action="{{ route('man-power.destroy', $row->id) }}" method="post">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to delete this data?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4">No Data.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        {{ $manpowers->links() }}
      </div>
    </div>
  </section>
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@push('scripts')
<script type="application/javascript">
  $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
  });
</script>
@endpush


@endsection
