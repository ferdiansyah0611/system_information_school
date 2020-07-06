<?php

namespace App\Exports;

use App\Models\ScClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use App\User;
class ClassExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return ScClass::all();
    }
}
