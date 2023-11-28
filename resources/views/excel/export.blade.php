<table>
  <thead>
    <tr>
      <th rowspan="2">Date</th>
      <th colspan="{{ $employees->count() }}">Status Per Day</th>
      <th colspan="{{ $employees->count() }}">Safety Report</th>
      <th rowspan="2">Organization</th>
      <th rowspan="2">Kaizen</th>
      <th colspan="5">Working Time Allocation</th>
    </tr>
    <tr>
      @foreach ($employees as $employee)
      <th>{{ $employee->name }}</th>
      @endforeach
      @foreach ($employees as $employee)
      <th>{{ $employee->name }}</th>
      @endforeach
      <th>RND</th>
      <th>Automation Project</th>
      <th>Tech Support</th>
      <th>Management</th>
      <th>Maintenance</th>
    </tr>
  </thead>
  <tbody>
    @foreach($statusPerDay as $key => $row)
    <tr>
      <td>{{ $key }}</td>
      @foreach ($row as $key => $status)

      @endforeach
      <td>{{ $row-> }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
