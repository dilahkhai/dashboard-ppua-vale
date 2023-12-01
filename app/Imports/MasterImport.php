<?php

namespace App\Imports;

use App\Imports\Sheets\EmployeeStatusImport;
use App\Imports\Sheets\KaizenImport;
use App\Imports\Sheets\OrganizationImport;
use App\Imports\Sheets\ProductivityImport;
use App\Imports\Sheets\SafetyReportImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterImport implements WithMultipleSheets
{
    protected $area;

    public function __construct($area)
    {
        $this->area = $area;
    }

    public function sheets(): array
    {
        return [
            'Employee Status' => new EmployeeStatusImport($this->area),
            'Kaizen' => new KaizenImport($this->area),
            'Organization' => new OrganizationImport($this->area),
            'Productivity' => new ProductivityImport($this->area),
            'Safety Report' => new SafetyReportImport($this->area)
        ];
    }
}
