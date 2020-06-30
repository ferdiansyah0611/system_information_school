<?php

namespace App\Exports;

use App\Models\ScAssessmentTask;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssessmentTaskExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScAssessmentTask::all();
    }
}
