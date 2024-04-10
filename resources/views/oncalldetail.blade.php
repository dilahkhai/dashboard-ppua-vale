@extends('master')

@section('css')
<style>
  .frame {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    height: 0;
    transform-origin: top;
    transform: scaleY(0);
    transition: all 500ms ease-in-out;
  }

  .frame.show-presentation {
    bottom: 0;
    height: 100%;
    transform: scaleY(100%);
    transition: all 500ms ease-in-out;
  }

  .hide {
    transform-origin: top;
    transform: scaleY(0);
    transition: all 500ms ease-in-out;
  }
</style>
@endsection

@section('content')

<div class="content-wrapper position-relative">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">On Call Automation Detail</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif

      @if(session()->has('fail'))
      <div class="alert alert-danger" role="alert">
        Failed!
      </div>
      @endif
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h4><b>{{ $oncall->title ? $oncall->title : 'No Title' }}</b></h4>

              <p>{{ $oncall->description ? $oncall->description : 'No Description.' }}</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-eye"></i>
            </div>
            <a role="button" class="small-box-footer" data-toggle="modal" data-target="#detail">Update <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h4><b>Upload</b></h4>
              <p>&nbsp;</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-upload"></i>
            </div>
            <a role="button" class="small-box-footer" data-toggle="modal" data-target="#upload">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box {{ $oncall->file ? 'bg-success' : 'bg-secondary' }} ">
            <div class="inner">
              <h4><b>Download</b></h4>
              <p>&nbsp;</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-download"></i>
            </div>
            @if ($oncall->file)
            <a class="small-box-footer" target="_blank" href="{{ $oncall->file }}">More info <i class="fas fa-arrow-circle-right"></i></a>
            @else
            <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  @if (auth()->user()->id == $oncall->user_id || auth()->user()->role == 'admin')
  <!-- Modal -->
  <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('oncall.update', $oncall->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailLabel">Set On Call Automation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="date_attended" id="date_attended">

            <div class="form-group">
              <label for="user">Employee</label>
              <input class="form-control" id="user" name="user" value="{{ $oncall->employee->name }}" readonly />
            </div>

            <div class="form-group">
              <label for="title">Title</label>
              <input class="form-control" id="title" name="title" />
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('oncall.upload', $oncall->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadLabel">Upload Document</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="file">File</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">Choose file</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endif
</div>

@push('scripts')
<script>
  $(document).on('change', 'input[type="file"]', function(e) {
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
  });
</script>
@endpush
@endsection
