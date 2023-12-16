@extends('master')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Infrastructure</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Infrastructure</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <form action="" method="get">
        <div class="row">
          <div class="col-4">
            <label for="">From</label>
            <input type="date" name="from" id="dateFilterFrom" class="form-control">
          </div>
          <div class="col-4">
            <label for="">To</label>
            <div class="d-flex">
              <input type="date" name="to" id="dateFilterTo" class="form-control mr-3">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </div>
        </div>
      </form>
      <br>

        {{-- Employee Status --}}
        <div class="card pb-5">
          <div class="card-header">
            <p class="card-title">Employee Status Per Day</p>
          </div>
          <div class="card-body">
            <div class="chart-container" style="height:300px">
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
        {{-- End Employee Status --}}


        <div class="row">
          {{-- Productivity --}}
          <div class="row col-6">

            <div class="col-4">
              <div class="small-box bg-info">
                <div class="inner">
                    <p style="font-size:15px;">Updated Organization
                      Structure
                    </p>

                    <h3>{{$organization->value ?? '0'}}%</h3>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="small-box bg-warning">
                <div class="inner">
                    <p>Kaizen
                    </p>

                    <h3>{{$kaizen->value ?? '0'}}%</h3>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="small-box bg-primary">
                <div class="inner">
                    <p>MCU Status</p>

                    <h3>{{$statusMcu}}%</h3>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card pb-4">
                <div class="card-header">
                  <p class="card-title">Working Time Allocation</p>
                </div>
                <div class="card-body">
                  <div class="chart-container" style="height:300px">
                    <canvas id="ChartProductivity"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- End Productivity --}}



          {{-- ManHours --}}
          <div class="col-6">
            <div class="card pb-2">
              <div class="card-header">
                <p class="card-title">Man Hours</p>
              </div>
              <div class="card-body">
                <div class="chart-container" style="height:450px">
                  <canvas id="CharManHours"></canvas>
                </div>
              </div>
            </div>
           </div>
          {{-- End ManHours --}}
        </div>

        <div class="row">
          {{-- Automation Safety --}}
          <div class="col-12">
              <div class="card pb-2">
                <div class="card-header">
                    <p class="card-title">Automation Safety Report</p>
                </div>
                <div class="card-body">
                  <div class="chart-container" style="height:300px">
                    <canvas id="ChartAutomationSafety"></canvas>
                  </div>
                </div>
              </div>
          </div>
          {{-- End Automation Safety --}}
        </div>

        <div class="card">
          <div class="card-header">
              <p class="card-title">Main Project</p>
          </div>
          <div class="card-body">
            <div id="gantt_here" style='width:100%; height:500px;'></div>
          </div>
        </div>

        <br>

        <div class="row col-12">
          @foreach ($employees as $employee)
          {{-- Hours Chart --}}
          <div class="pr-1 col-4">
            <div class="card pb-5">
              <div class="card-body">
                <div class="chart-container text-center" style="height:200px;width:200px;">
                  <p>{{$employee->name}}</p>
                  <canvas id="ChartHours{{$employee->id}}"></canvas>
                </div>
              </div>
            </div>
          </div>
          {{-- End Hours Chart --}}
          @endforeach
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>

    <script type="text/javascript">
        gantt.config.readonly = true;
        // gantt.config.date_format = "%Y-%m-%d";
        gantt.config.grid_width = 700;
        gantt.config.columns = [
            {name:"name", label:"Task name",  align: "center", color:"red" },
            {name:"task_owner_area", label:"Area", align: "center" },
            {name:"task_owner", label:"Owner", align: "center" },
            {name:"priority", label:"Priority", align: "center" },
            {name:"start_date", label:"Start time", align: "center" },
            {name:"duration", label:"Duration", align: "center" },
            {name:"status", label:"Status", align: "center" }
        ];

        gantt.templates.task_text = function(start, end, task) {
          return `<span style="color: black; font-weight: bold">${task.name} - ${task.status}</span>`;
        };

        gantt.templates.task_class = function(start, end, task){
            if(task.status == "Not Started"){
                return "gantt-orange";
            }else if(task.status == "In Progress"){
                return "gantt-amber";
            }else if(task.status == "Complete"){
                return "gantt-green";
            }else if(task.status == "Overdue"){
                return "gantt-blue";
            }
        };


        var monthScaleTemplate = function (date) {
            var dateToStr = gantt.date.date_to_str("%M");
            var endDate = gantt.date.add(date, 2, "month");
            return dateToStr(date) + " - " + dateToStr(endDate);
        };

        gantt.config.scales = [
            {unit: "month", step: 1, format: "%F %Y"},
            {unit: "day", step: 1, format: "%j %D"}
        ];

        gantt.init("gantt_here");
        gantt.load("/api/data-infra");
    </script>

<script src="{{asset('SelainLogin/chart.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>

<script>
  // Employee Status
  // -----------------------
  const data = {
    labels: {!! json_encode($safety_employees) !!},
    datasets: [
      {
        label: 'HO',
        data:  {!! json_encode($ho) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(127, 127, 127)'
      },
      {
        label: 'Training',
        data: {!! json_encode($trainings) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(165, 165, 165)'
      },
      {
        label: 'Sick Leave',
        data: {!! json_encode($sick_leaves) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(255, 192, 0)'
      },
      {
        label: 'Annual Leave',
        data: {!! json_encode($annual_leaves) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(91, 155, 213)'
      },
      {
        label: 'Emergency Leave',
        data: {!! json_encode($emergency_leaves) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(112, 173, 71)'
      },
      {
        label: 'Medical Check up',
        data: {!! json_encode($medical_leaves) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(38, 68, 120)'
      },
      {
        label: 'Maternity Leave',
        data: {!! json_encode($maternity_leaves) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(158, 72, 14)'
      },
      {
        label: 'Office',
        data: {!! json_encode($offices) !!},
        borderWidth: 1,
        backgroundColor: 'rgb(0, 102, 102)'
      },
    ]
  };
  const config = {
    type: 'bar',
    data: data,
    options: {
      color: "#000",
      borderColor: '#fff',
      responsive:true,
      maintainAspectRatio: false,
      scales: {
        y: {
            suggestedMin: 0,
            suggestedMax: 100,
            ticks: {
              color: '#000'
            }
        },
        x: {
          ticks: {
            color: '#000'
          }
        }
      }
    }
  };
</script>

<script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

</script>
{{-- End Employee Status --}}



{{-- Productivity --}}
<script>
  const dataProductivity = {
    labels: {!! json_encode($departments) !!},
    datasets: [{
      label: 'Productivity',
      data: {!! json_encode($department_values) !!},
      backgroundColor: 'rgb(186, 155, 145)',
      borderWidth: 1
    }]
  };

  const configProductivity = {
    type: 'bar',
    data: dataProductivity,
    options: {
      color: "#000",
      borderColor: '#fff',
      responsive:true,
      maintainAspectRatio: false,
      scales: {
        y: {
            suggestedMin: 0,
            suggestedMax: 30,
            ticks: {
              color: '#000'
            }
        },
        x: {
          ticks: {
            color: '#000'
          }
        }
      },
      elements: {
        bar: {
          color: '#fff'
        }
      }
    }
  };
</script>

<script>
    const myChartProductivity = new Chart(
      document.getElementById('ChartProductivity'),
      configProductivity
    );

</script>
{{-- End Productivity --}}


{{-- Man Hours --}}

<script>
    const dataManhours = {
      labels: {!! json_encode($safety_employees) !!},
      datasets: [{
        label: 'Manhours',
        data: {!! json_encode($manhours) !!},
        backgroundColor: 'rgb(180, 200, 145)',
        borderWidth: 1
      }]
    };

    const configManhours = {
      type: 'bar',
      data: dataManhours,
      options: {
          color: "#000",
          borderColor: '#fff',
          responsive:true,
          maintainAspectRatio: false,
          scales: {
            y: {
                suggestedMin: 0,
                suggestedMax: 30,
                ticks: {
                  color: '#000'
                }
            },
            x: {
              ticks: {
                color: '#000'
              }
            }
          }
        }
    };
  </script>

  <script>
      const myChartManhours = new Chart(
        document.getElementById('CharManHours'),
        configManhours
      );

  </script>

{{-- End Man Hours --}}

{{-- Automation Safety --}}
<script>
  const dataAutomation = {
    labels: {!! json_encode($safety_employees) !!},
    datasets: [{
      label: 'Automation Safety Report',
      data: {!! json_encode($safety_values) !!},
      backgroundColor: 'rgb(125, 104, 120)',
      borderWidth: 1
    }]
  };

  const configAutomation = {
    type: 'bar',
    data: dataAutomation,
    options: {
          color: "#000",
          borderColor: '#fff',
          responsive:true,
          maintainAspectRatio: false,
          scales: {
            y: {
                suggestedMin: 0,
                suggestedMax: 30,
                ticks: {
                  color: '#000'
                }
            },
            x: {
              ticks: {
                color: '#000'
              }
            }
          }
        }
  };
</script>

<script>
    const myChartAutomation = new Chart(
      document.getElementById('ChartAutomationSafety'),
      configAutomation
    );

</script>
{{-- End Automation Safety --}}

{{-- Hours Chart --}}
<script>
  let listEmployee = {!! json_encode($employees) !!};
  let working_time_per_week = {!! json_encode($working_time_per_week) !!};
  console.log(listEmployee[0]);
  for (let index = 0; index < listEmployee.length; index++) {
    const dataHours = {
      labels: [
        'Finish',
        'Not Finish',
      ],
      datasets: [{
        data: working_time_per_week[index],
        backgroundColor: [
          'rgb(51, 102, 153)',
          'red',
        ],
        borderColor: 'rgba(0, 0, 0, 0.2)',
        borderWidth: 0.5,
        hoverOffset: 4
      }]
    };
    const configHours = {
      type: 'pie',
      data: dataHours,
      options: {
        color: '#000',
        plugins: {
          datalabels: {
            color: "white",
            font: {
              size: 32,
              weight: 'bold'
            }
          }
        }
      },
      plugins: [ChartDataLabels]
    };


    const myChartHours = new Chart(
        document.getElementById('ChartHours'+listEmployee[index].id),
        configHours
      );
  }
</script>
{{-- End Hours Chart --}}

@endsection
