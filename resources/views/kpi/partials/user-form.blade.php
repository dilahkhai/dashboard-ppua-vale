
<!-- form start -->
<form role="form" action="{{ route('key-performance-index.storeInput', $keyPerformanceIndex->id) }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="card-body">
    <div class="form-group">
      <label for="exampleInputPassword1">Plan</label>
      <input type="text" class="form-control" disabled>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Actual</label>
      <input type="text" class="form-control" name="actual">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Remark</label>
      <input type="text" class="form-control" name="remark">
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"> Submit </button>
    </div>
  </div>
  <!-- /.card -->
</form>
