<?php

namespace App\Exports;

// excel
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
// model
use App\Models\ScTypeReportCard;

class ReportCardExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScTypeReportCard::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Homeroom Teacher ID',
            'Student ID'
            'Type',
            'Period',
            'Description',
            'Absent Broken',
            'Absent Permission',
            'Absent Without Explanation',
            'Personality Behavior',
            'Personality Diligence',
            'Personality Neatness',
            'Created at',
            'Updated at'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
            },
        ];
    }
}
