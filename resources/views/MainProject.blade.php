@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Main Project</h1>
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="card-body">
      <a href="{{url('manage-tasks')}}" class="btn btn-md btn-success">Manage Project</a>

      <p>&nbsp;</p>

      <div id="gantt_here" style='width:100%; height:500px;'></div>
    </div>
    <!-- /.card -->

    <!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@push('scripts')
<script type="text/javascript">
  gantt.config.readonly = true;
  // gantt.config.date_format = "%Y-%m-%d";
  gantt.config.grid_width = 700;
  gantt.config.columns = [{
      name: "name",
      label: "Task name",
      align: "center",
      color: "red"
    },
    {name:"task_owner_area", label:"Area", align: "center" },
    {
      name: "task_owner",
      label: "Owner",
      align: "center"
    },
    {
      name: "priority",
      label: "Priority",
      align: "center"
    },
    {
      name: "start_date",
      label: "Start time",
      align: "center"
    },
    {
      name: "duration",
      label: "Duration",
      align: "center"
    },
    {
      name: "status",
      label: "Status",
      align: "center"
    }
  ];

  gantt.templates.task_text = function(start, end, task) {
    return `<span style="color: black; font-weight: bold">${task.name} - ${task.status}</span>`;
  };

  gantt.templates.task_class = function(start, end, task) {
    if (task.status == "Not Started") {
      return "gantt-orange";
    } else if (task.status == "In Progress") {
      return "gantt-amber";
    } else if (task.status == "Complete") {
      return "gantt-green";
    } else if (task.status == "Overdue") {
      return "gantt-blue";
    }
  };


  var monthScaleTemplate = function(date) {
    var dateToStr = gantt.date.date_to_str("%M");
    var endDate = gantt.date.add(date, 2, "month");
    return dateToStr(date) + " - " + dateToStr(endDate);
  };

  gantt.config.scales = [{
      unit: "month",
      step: 1,
      format: "%F %Y"
    },
    {
      unit: "day",
      step: 1,
      format: "%j %D"
    }
  ];

  gantt.init("gantt_here");
  gantt.load("/api/data-main?user_id={{ auth()->user()->id }}");
</script>
@endpush


@endsection
