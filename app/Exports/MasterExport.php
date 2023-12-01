<?php

namespace App\Exports;

use App\Exports\Sheets\EmployeeStatusExport;
use App\Exports\Sheets\KaizenExport;
use App\Exports\Sheets\OrganizationExport;
use App\Exports\Sheets\ProductivityExport;
use App\Exports\Sheets\SafetyReportExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterExport implements WithMultipleSheets
{
    protected $from, $to, $area;

    public function __construct($from, $to, $area)
    {
        $this->from = $from;
        $this->to = $to;
        $this->area = $area;
    }

    public function sheets(): array
    {
        return [
            new EmployeeStatusExport($this->from, $this->to),
            new KaizenExport($this->from, $this->to, $this->area),
            new OrganizationExport($this->from, $this->to, $this->area),
            new ProductivityExport($this->from, $this->to, $this->area),
            new SafetyReportExport($this->from, $this->to)
        ];
    }
}
