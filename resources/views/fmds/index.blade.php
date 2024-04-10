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
          <h1 class="m-0">FMDS</h1>
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
          <div class="small-box bg-warning">
            <div class="inner">
              <h4><b>Download</b></h4>
              <p>&nbsp;</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-download"></i>
            </div>
            <a role="button" class="small-box-footer" data-toggle="modal" data-target="#download">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box {{ $latestDocument ? 'bg-danger' : 'bg-secondary' }}">
            <div class="inner">
              <h4><b>View</b></h4>

              <p>&nbsp;</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-eye"></i>
            </div>
            @if ($latestDocument)
            <a role="button" class="small-box-footer" id="view">More info <i class="fas fa-arrow-circle-right"></i></a>
            @else
            <a role="button" class="small-box-footer">{{ $latestDocument ? 'More info' : 'No Document' }} <i class="fas fa-arrow-circle-right"></i></a>
            @endif
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div>
  </section>

  <div class="frame">
    <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ asset($latestDocument?->file) }}' title="presentation" width='100%' height='100%' frameborder='0'></iframe>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('fmds.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadLabel">Upload FMDS Document</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" class="form-control" name="upload_date" id="date">
            </div>
            <div class="form-group">
              <label for="file">File</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="file" accept=".ppt,.pptx">
                <label class="custom-file-label" for="customFile">Choose file</label>
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

  <!-- Modal -->
  <div class="modal fade" id="download" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('fmds.download') }}" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadLabel">Download FMDS Document</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" class="form-control" name="date" id="date">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Download</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  window.onerror = e => console.log(e);

  $(document).on('change', 'input[type="file"]', function(e) {
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
  });

  $(document).on('click', '#view', function() {
    $('body').toggleClass('sidebar-collapse')

    $('.content').toggleClass('hide')
    $('.content-header').toggleClass('hide')

    $('.frame').addClass('show-presentation')

    $('.navbar-nav').append(`<li class="nav-item d-none d-sm-inline-block">
      <a role="button" class="nav-link" id="closePresentation">Close Presentation</a>
    </li>`)
  })

  $(document).on('click', '#closePresentation', function () {
    $('.frame').removeClass('show-presentation')

    $(this).remove()

    $('body').toggleClass('sidebar-collapse')

    $('.content').toggleClass('hide')
    $('.content-header').toggleClass('hide')
  })
</script>
@endpush
@endsection
