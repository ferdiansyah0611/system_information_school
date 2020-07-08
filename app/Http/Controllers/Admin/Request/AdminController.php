<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ScSchool;
use App\Models\ScStudent;
use App\User;
use Mail;
use PDF;

class AdminController extends Controller
{
    public function dashboard()
    {
    	$date = '2020';
    	$app['school'] = [
    		'year_' . $date => ScSchool::whereYear('created_at', $date)->count(),
    		'year_' . ($date + 1) => ScSchool::whereYear('created_at', $date + 1)->count(),
    		'year_' . ($date + 2) => ScSchool::whereYear('created_at', $date + 2)->count(),
    		'year_' . ($date + 3) => ScSchool::whereYear('created_at', $date + 3)->count(),
    		'year_' . ($date + 4) => ScSchool::whereYear('created_at', $date + 4)->count(),
    		'year_' . ($date + 5) => ScSchool::whereYear('created_at', $date + 5)->count(),
    		'year_' . ($date + 6) => ScSchool::whereYear('created_at', $date + 6)->count(),
    		'year_' . ($date + 7) => ScSchool::whereYear('created_at', $date + 7)->count(),
    		'year_' . ($date + 8) => ScSchool::whereYear('created_at', $date + 8)->count(),
    	];
    	$app['student'] = [
    		'year_' . $date => ScStudent::whereYear('created_at', $date)->count(),
    		'year_' . ($date + 1) => ScStudent::whereYear('created_at', $date + 1)->count(),
    		'year_' . ($date + 2) => ScStudent::whereYear('created_at', $date + 2)->count(),
    		'year_' . ($date + 3) => ScStudent::whereYear('created_at', $date + 3)->count(),
    		'year_' . ($date + 4) => ScStudent::whereYear('created_at', $date + 4)->count(),
    		'year_' . ($date + 5) => ScStudent::whereYear('created_at', $date + 5)->count(),
    		'year_' . ($date + 6) => ScStudent::whereYear('created_at', $date + 6)->count(),
    		'year_' . ($date + 7) => ScStudent::whereYear('created_at', $date + 7)->count(),
    		'year_' . ($date + 8) => ScStudent::whereYear('created_at', $date + 8)->count(),
    	];
    	return response()->json($app);
    }
    /**
     * Import a file excel of the export.
     *
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'import' => 'file|mimes:xls,xlsx|max:5000',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $check = User::where('id', $user)->pluck('id');
            if($check[0] !== null || $check[0] !== undefined) {

                $file = $request->file('import');
                $file->move(storage_path('app/public/office'), $file->getClientOriginalName());
                Excel::import(new AssessmentTaskImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
    public function userLatest() 
    {
        return response()->json(User::latest()->paginate(8), 200);
    }
}
