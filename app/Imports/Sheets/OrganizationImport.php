<?php

namespace App\Imports\Sheets;

use App\Models\OrganizationStructure;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OrganizationImport implements ToModel, WithStartRow
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
        return new OrganizationStructure([
            'created_at' => $date,
            'value' => $row[1],
            'area_id' => $this->area
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
