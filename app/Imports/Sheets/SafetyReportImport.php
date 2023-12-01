<?php

namespace App\Imports\Sheets;

use App\Models\SafetyReport;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SafetyReportImport implements ToModel, WithStartRow
{
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

        return new SafetyReport([
            'created_at' => $date,
            'employee_id' => $user,
            'count' => $row[2]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
