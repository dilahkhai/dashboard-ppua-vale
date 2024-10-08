<style>
    body,
    html {
        width: 100%;
        height: 100%;
        margin: unset;
    }

    .gantt_progress_red .gantt_task_progress {
        background-color: #f44336 !important;
    }

    .gantt_progress_yellow .gantt_task_progress {
        background-color: #ffeb3b !important; /* Kuning */
    }
    
    .gantt_progress_green .gantt_task_progress {
        background-color: #4caf50 !important; /* Hijau */
    }

    .gantt_status_not_started {
        color: #f44336; /* Red */
    }

    .gantt_status_on_progress {
        color: #ffeb3b; /* Yellow */
    }

    .gantt_status_completed {
        color: #4caf50; /* Green */
    }

    .gantt_status_overdue {
        color: #f44336; /* Red */
        font-weight: bold;
    }
</style>

@extends('master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Main Project</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="gantt_here" style="width:100%; height:100%;"></div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css">
<script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>

<script type="text/javascript">
        // Menyiapkan mapping ID ke nama
        const userMap = {
            @foreach ($users as $userGroup)
                @foreach ($userGroup as $user)
                    '{{ $user->id }}': '{{ $user->name }}',
                @endforeach
            @endforeach
        };

        const areaMap = {
            @foreach ($areas as $area)
                '{{ $area->id }}': '{{ $area->area }}',
            @endforeach
        };

        gantt.config.work_time = true;
        gantt.config.min_column_width = 60;
        gantt.config.duration_unit = "day";
        gantt.config.scale_height = 20 * 3;
        gantt.config.row_height = 28;

        gantt.config.scales = [
            {unit: "month", step: 1, format: "%F, %Y"},
            {unit: "week", step: 1, format: function (date) {
                var dateToStr = gantt.date.date_to_str("%d %M");
                var weekNum = gantt.date.date_to_str("(week %W)");
                var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
                return dateToStr(date) + " - " + dateToStr(endDate) + " " + weekNum(date);
            }},
            {unit: "day", step: 1, format: "%D, %d"}
        ];


        gantt.templates.task_class = function (start, end, task) {
            var totalDays = Math.ceil(end - start); 
            var currentDate = new Date(); 
            var daysPassed = Math.ceil(currentDate - start); 

            if (daysPassed > totalDays) {
                daysPassed = totalDays;
            }

            var expectedProgress = (daysPassed / totalDays) * 100; 
            var actualProgress = task.progress * 100; 
            if (actualProgress >= 100) {
                return "gantt_progress_green"; 
                } else if (actualProgress >= expectedProgress) {
                    return "gantt_progress_yellow"; 
                } else {
                        return "gantt_progress_red"; 
                }
            };


        gantt.templates.task_text = function(start, end, task) {
            let statusText;
            const progressPercentage = Math.round(task.progress * 100);
            const today = new Date();
            const endDate = new Date(task.end_date);

            if (progressPercentage === 100) {
                statusText = "Completed";
            } else if (progressPercentage === 0) {
                statusText = "Not Started";
            } else if (today > endDate) {
                statusText = "Overdue";
            } else {
                statusText = "On Progress";
            }
            
            return "<strong style='color: black;'>" + progressPercentage + "% - " + statusText + "</strong>";
        };

        gantt.config.columns = [
            { name: "name", label: "Task Name", align: "left", width: 300, tree: true },
            { name: "user_id", label: "Owner", align: "center", width: 150, template: function(task) {
                return userMap[task.user_id] || "Unknown";
            }},
            { name: "start_date", label: "Start Date", align: "center", width: 100 },
            { name: "end_date", label: "End Date", align: "center", width: 100 },
            { name: "add", label: "", width: 44 }
        ];

        gantt.locale.labels.section_owner = "Owner";
        gantt.locale.labels.section_name = "Task Name";
        gantt.locale.labels.section_progress = "Progress";
        gantt.locale.labels.section_area_id = "Area";
        
        gantt.config.lightbox.sections = [
            { name: "name", label: 'Task Name', height: 30, map_to: "name", type: "textarea", id: "task_name", focus: true },
            { name: "time", type: "duration", map_to: "auto", id: "time_duration" },
            { name: "area_id", label: 'Area', type: "select", map_to: "area_id", id: "area_id", options: [
                @foreach ($areas as $area)
                { key: '{{ $area->id }}', label: '{{ $area->area }}' },
                @endforeach
            ]},
            { name: "owner", label: 'Owner', type: "select", map_to: "user_id", id: "user_id", options: [
                @foreach ($users as $userGroup)
                @foreach ($userGroup as $user)
                { key: '{{ $user->id }}', label: '{{ $user->name }}' },
                @endforeach
                @endforeach
            ]}
        ];

        gantt.attachEvent("onBeforeRowDragMove", function (id, parentId, tindex) {
            if (parentId) {
                const parent = gantt.getTask(parentId);
                if (parent.type != "project") {
                    return false;
                }
            }
            return true
        });

        gantt.config.open_tree_initially = true;
        gantt.config.order_branch = "marker";
        gantt.config.order_branch_free = true;;
        gantt.config.auto_types = true;

        gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
        gantt.config.order_branch = true;
        gantt.config.order_branch_free = true;
        gantt.init("gantt_here");
        
        gantt.load("/api/data-project");
        
        const dp = gantt.createDataProcessor({
            url: "/api/",
            mode: "REST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            on_after_update: function (id, action, data) {
                console.log("Data to be sent:", data);
            }
        });
</script>


@endpush
@endsection

