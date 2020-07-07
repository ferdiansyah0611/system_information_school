<?php

namespace App\Exports;

// excel
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
// model
use App\Models\ScStudent;

class StudentExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScStudent::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'User ID',
            'School ID',
            'Class ID',
            'Phone',
            'Father',
            'Mother',
            'Work Father',
            'Work Mother',
            'Phone Father',
            'Phone Mother',
            'Generation'
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
