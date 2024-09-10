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

  <section class="content">
    <div class="card-body">
      <a href="{{ url('manage-tasks') }}" class="btn btn-md btn-success">Manage Project</a>

      <p>&nbsp;</p>

      <div id="gantt_here" style='width:100%; height:500px;'></div>

      <p>&nbsp;</p>

      <h3>Completed Tasks</h3>
      <table id="completed_tasks_table" class="table table-bordered">
        <thead>
          <tr style="background-color: rgb(40, 167, 69); color: white;">
            <th>Task Name</th>
            <th>Area</th>
            <th>Owner</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </section>
</div>

@push('scripts')
<script type="text/javascript">
  gantt.config.readonly = true;
  gantt.config.grid_width = 600;
  gantt.config.date_format = "%Y-%m-%d %H:%i"; 

  gantt.config.columns = [
    { name: "name", label: "Task name", align: "left" },
    { name: "task_owner_area", label: "Area", align: "center" },
    { name: "task_owner", label: "Owner", align: "center", width: 150},
    { name: "priority", label: "Priority", align: "center" },
    { name: "start_date", label: "Start time", align: "center" },
    { name: "end_date", label: "End time", align: "center" },
    { name: "status", label: "Status", align: "center", width: 150},
    { name: "progress", label: "Progress", align: "center", width: 80 }
  ];

  gantt.templates.task_text = function(start, end, task) {
    return `<span style="color: black; font-weight: bold">${task.name} - ${task.status} (${task.progress}%)</span>`;
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

  gantt.config.scales = [
    { unit: "month", step: 1, format: "%F %Y" },
    { unit: "day", step: 1, format: "%j %D" }
  ];

  gantt.init("gantt_here");

  fetch("/api/data-main?user_id={{ auth()->user()->id }}")
    .then(response => response.json())
    .then(data => {
      const tasks = data.data;

      const ongoingTasks = tasks.filter(task => task.status !== "Complete");
      const completedTasks = tasks.filter(task => task.status === "Complete");

      gantt.parse({ data: ongoingTasks });

      const tableBody = document.querySelector("#completed_tasks_table tbody");
      tableBody.innerHTML = ""; 
      completedTasks.forEach(task => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td style="background-color: rgb(255, 255, 255); color: black;">${task.name}</td>
          <td style="background-color: rgb(255, 255, 255); color: black;">${task.task_owner_area}</td>
          <td style="background-color: rgb(255, 255, 255); color: black;">${task.task_owner}</td>
          <td style="background-color: rgb(255, 255, 255); color: black;">${task.start_date}</td>
          <td style="background-color: rgb(255, 255, 255); color: black;">${task.end_date}</td>
          <td style="background-color: rgb(255, 255, 255); color: black;">${task.status}</td>
        `;
        tableBody.appendChild(row);
      });
    });
</script>
@endpush

@endsection
