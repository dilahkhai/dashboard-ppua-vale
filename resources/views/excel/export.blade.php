<table>
  <thead>
    <tr>
      <th colspan="9">Employee Status Range: {{ $from }} - {{ $to }}</th>
    </tr>
    <tr>
      <th>Employee</th>
      <th>Office</th>
      <th>HO</th>
      <th>Training</th>
      <th>Sick Leave</th>
      <th>Annual Leave</th>
      <th>Emergency Leave</th>
      <th>Medical CheckUp</th>
      <th>Maternity Leave</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employees as $key => $row)
    <tr>
      <td>{{ $row->name }}</td>
      <td>{{ $row->office }}</td>
      <td>{{ $row->ho }}</td>
      <td>{{ $row->training }}</td>
      <td>{{ $row->sick_leave }}</td>
      <td>{{ $row->annual_leave }}</td>
      <td>{{ $row->emergency_leave }}</td>
      <td>{{ $row->medical_leave }}</td>
      <td>{{ $row->maternity_leave }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
