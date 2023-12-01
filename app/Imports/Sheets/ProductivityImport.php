<?php

namespace App\Imports\Sheets;

use App\Models\Department;
use App\Models\productivity;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductivityImport implements ToModel, WithStartRow
{
    protected $area;

    public function __construct($area)
    {
        $this->area = $area;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $date = is_string($row[0]) ? Carbon::parse($row[0])->toDateString() : Carbon::parse(Date::excelToDateTimeObject($row[0]))->toDateString();

        return new productivity([
            'created_at' => $date,
            'department_id' => $row[1],
            'update' => $row[2],
            'selisih' => $row[3],
            'area_id' => $this->area
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
