<?php

namespace App\Imports\Sheets;

use App\Models\statusperday;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeeStatusImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::query()
            ->where('name', $row[1])
            ->value('id');

        $date = is_string($row[0]) ? Carbon::parse($row[0])->toDateString() : Carbon::parse(Date::excelToDateTimeObject($row[0]))->toDateString();

        return new statusperday([
            'created_at' => $date,
            'employee_id' => $user,
            'office' => $row[2],
            'ho' => $row[3],
            'training' => $row[4],
            'sick_leave' => $row[5],
            'annual_leave' => $row[6],
            'emergency_leave' => $row[7],
            'medical_leave' => $row[8],
            'maternity_leave' => $row[9]
        ]);
    }
}
