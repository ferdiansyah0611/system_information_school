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
    	/*if(request()->user()->role == 'admin') {
    		if(request()->get('data') == true) {
    			$type == gettype(request()->get('data'));
    			if($type !== null || $type !== 'object' || $type !== 'double') {
	    			return User::where('id', request()->user()->id)
		    		->join('sc_schools', 'users.sc_school_id', '=', 'sc_schools.id')
		    		->join('sc_classes', 'users.sc_school_id', '=', 'sc_classes.sc_school_id')
		    		->select(
		    			'sc_classes.id', 'sc_classes.name', 'users.nisn'
		    		)
		    		->offset(0)->limit(request()->get('data'))
		    		->get();
    			} else {
    				return User::where('id', request()->user()->id)
		    		->join('sc_schools', 'users.sc_school_id', '=', 'sc_schools.id')
		    		->join('sc_classes', 'users.sc_school_id', '=', 'sc_classes.sc_school_id')
		    		->select(
		    			'sc_classes.id', 'sc_classes.name', 'users.nisn'
		    		)
		    		->offset(0)->limit(25)
		    		->get();
    			}
    		} else {*/
	    		return User::where('users.id', '1')
	    		->join('sc_schools', 'users.sc_school_id', '=', 'sc_schools.id')
	    		->join('sc_classes', 'users.sc_school_id', '=', 'sc_classes.sc_school_id')
	    		->select(
	    			'sc_classes.id', 'sc_classes.name', 'users.nisn'
	    		)
	    		->get();
    		/*}
    	}
    	if(request()->user()->role == 'administrator') {
    		
    	}*/
    }
}
