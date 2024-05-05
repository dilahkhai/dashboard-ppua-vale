<!-- form start -->
<form role="form" action="{{ route('key-performance-index.storeInput', $keyPerformanceIndex->id) }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="card-body">
    <div class="table-responsive">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Plan</th>
            <th>Actual</th>
            <th>Remark</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
          <tr>
            <td>
              {{ $user->name }}
            </td>
            <td>
              <div>
                <input type="text" class="form-control" name="{{ $user->id }}[plan]" value="{{ $details->has($user->id) ? $details[$user->id]->plan : 0 }}" {{ auth()->user()->role == 'admin' ? '' : 'disabled' }}>
              </div>
            </td>
            <td>
              <div>
                <input type="text" class="form-control" name="{{ $user->id }}[actual]" value="{{ $details->has($user->id) ? $details[$user->id]->actual : 0 }}" {{ ($details->has($user->id) && $details[$user->id]->user_id == auth()->user()->id) || auth()->user()->role == 'admin' ? '' : 'disabled' }}>
              </div>
            </td>
            <td>
              <div>
                <input type="text" class="form-control" name="{{ $user->id }}[remark]" value="{{ $details->has($user->id) ? $details[$user->id]->remark : '' }}" {{ ($details->has($user->id) && $details[$user->id]->user_id == auth()->user()->id) || auth()->user()->role == 'admin' ? '' : 'disabled' }}>
              </div>
            </td>
            <td>
              <div>
                <input type="text" class="form-control" value="{{ $details->has($user->id) ? $details[$user->id]->status : '' }}" disabled>
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
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"> Submit </button>
    </div>
  </div>
  <!-- /.card -->
</form>
