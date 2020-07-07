<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// excel
use App\Exports\StudyExport;
use App\Imports\StudyImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\Models\ScStudy;
use App\User;

class StudyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->random = rand(1000000, 10000000);
        $this->timestamp = Carbon::now();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = $request->get('orderby');
        $search = $request->get('search');
        $columns = $request->get('columns');
        $type = $request->get('type');
        if($order == true){
            // search default
            if($search == 'default'){
                if($columns < 101 && $columns > 1){
                    return $this->searchDefault($order, $type, $columns);
                }
            // searching
            }else{
                if($columns < 101 && $columns > 1){
                    return $this->searching($order, $type, $search, $columns);
                }else{
                    return $this->searching($order, $type, $search, 25);
                }
            }
        // default url api/class
        }else{
            if($columns < 101 && $columns > 1){
                return $this->searchDefault('id', 'asc', $columns);
            }
            if($type == 'default'){
                return $this->searchDefault('id', 'asc', '25');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sc_school_id' => 'required|numeric',
            'sc_class_id' => 'required|numeric',
            'sc_teacher_id' => 'required|numeric',
            'name' => 'required|string|min:2|max:191',
            'day' => 'required|string|min:1|max:5',
            'time' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            $app = new ScStudy;
            $app->id = $this->random;
            $app->sc_school_id = $request->sc_school_id;
            $app->sc_class_id = $request->sc_class_id;
            $app->sc_teacher_id = $request->sc_teacher_id;
            $app->name = $request->name;
            $app->day = $request->day;
            $app->time = $request->time;
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scStudy
     * @return \Illuminate\Http\Response
     */
    public function show($scStudy)
    {
        return response()->json(ScStudy::join('sc_teachers', 'sc_studies.sc_teacher_id', '=', 'sc_teachers.id')
            ->join('sc_schools', 'sc_studies.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_studies.sc_class_id', '=', 'sc_classes.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->orderBy('id', 'asc')
            ->where('sc_studies.id', $scStudy)
            ->select(
                'sc_studies.id', 'sc_studies.name', 'sc_studies.day', 'sc_studies.time', 'sc_studies.sc_school_id', 'sc_studies.sc_class_id', 'sc_studies.sc_teacher_id',
                'sc_studies.created_at', 'sc_studies.updated_at',
                'sc_schools.name as sc_school_name',
                'sc_classes.name as sc_class_name',
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $scStudy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scStudy)
    {
        $validator = Validator::make($request->all(), [
            'sc_school_id' => 'required|numeric',
            'sc_class_id' => 'required|numeric',
            'sc_teacher_id' => 'required|numeric',
            'name' => 'required|string|min:2|max:191',
            'day' => 'required|string|min:1|max:5',
            'time' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            ScStudy::where('id', $scStudy)->update([
                'sc_school_id' => $request->sc_school_id,
                'sc_class_id' => $request->sc_class_id,
                'sc_teacher_id' => $request->sc_teacher_id,
                'name' => $request->name,
                'day' => $request->day,
                'time' => $request->time,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\$scStudy
     * @return \Illuminate\Http\Response
     */
    public function destroy($scStudy)
    {
        ScStudy::where('id', $scStudy)->delete();
        return response()->json(['message' => 'Successfuly delete data'], 200);
    }
    ////////////////////////////////end resources////////////////////////////////

    /**
     * Display a listing of the resource.
     *
     * @param $$order $type $columns
     * @return \Illuminate\Http\Response
     */
    public function searchDefault($order, $type, $columns)
    {
        /*student = id name day time*/
        /*school = name*/
        /*class = name*/
        /*teacher = id title join users = name nisn*/
        $role = request()->user()->role;
        if($role == 'administrator' || $role == 'admin' || $role == 'teacher') {
            if($role == 'administrator') {
                return response()->json(ScStudy::join('sc_teachers', 'sc_studies.sc_teacher_id', '=', 'sc_teachers.id')
                    ->join('sc_schools', 'sc_studies.sc_school_id', '=', 'sc_schools.id')
                    ->join('sc_classes', 'sc_studies.sc_class_id', '=', 'sc_classes.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->select(
                        'sc_studies.id', 'sc_studies.name', 'sc_studies.day', 'sc_studies.time', 'sc_studies.created_at', 'sc_studies.updated_at',
                        'sc_schools.name as sc_school_name',
                        'sc_classes.name as sc_class_name',
                        'users.name as user_name', 'users.id as user_id', 'users.nisn')
                    ->paginate($columns), 200);
            }
            if($role == 'admin' || $role == 'teacher') {
                return response()->json(ScStudy::join('sc_teachers', 'sc_studies.sc_teacher_id', '=', 'sc_teachers.id')
                    ->join('sc_schools', 'sc_studies.sc_school_id', '=', 'sc_schools.id')
                    ->where('sc_schools.id', request()->user()->sc_school_id)
                    ->join('sc_classes', 'sc_studies.sc_class_id', '=', 'sc_classes.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->select(
                        'sc_studies.id', 'sc_studies.name', 'sc_studies.day', 'sc_studies.time', 'sc_studies.created_at', 'sc_studies.updated_at',
                        'sc_schools.name as sc_school_name',
                        'sc_classes.name as sc_class_name',
                        'users.name as user_name', 'users.id as user_id', 'users.nisn')
                    ->paginate($columns), 200);
            }
        } else {
            return response()->json(['message' => 'Not allowed'], 401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param $$order $type $search $paginate
     * @return \Illuminate\Http\Response
     */
    public function searching($order, $type, $search, $paginate)
    {
        $role = request()->user()->role;
        if($role == 'administrator' || $role == 'admin' || $role == 'teacher') {
            if($role == 'administrator') {
                return response()->json(ScStudy::join('sc_teachers', 'sc_studies.sc_teacher_id', '=', 'sc_teachers.id')
                    ->join('sc_schools', 'sc_studies.sc_school_id', '=', 'sc_schools.id')
                    ->join('sc_classes', 'sc_studies.sc_class_id', '=', 'sc_classes.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->where('sc_studies.id', 'like', '%' . $search . '%')
                    ->orWhere('sc_studies.name', 'like', '%' . $search . '%')
                    ->orWhere('sc_studies.day', 'like', '%' . $search . '%')
                    ->orWhere('sc_studies.time', 'like', '%' . $search . '%')
                    ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                    ->orWhere('sc_classes.name', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.id', 'like', '%' . $search . '%')
                    ->select(
                        'sc_studies.id', 'sc_studies.name', 'sc_studies.day', 'sc_studies.time', 'sc_studies.created_at','sc_studies.updated_at',
                        'sc_schools.name as sc_school_name',
                        'sc_classes.name as sc_class_name',
                        'users.name as user_name', 'users.id as user_id', 'users.nisn')
                    ->paginate($paginate), 200);
            }
            if($role == 'admin' || $role == 'teacher') {
                return response()->json(ScStudy::join('sc_teachers', 'sc_studies.sc_teacher_id', '=', 'sc_teachers.id')
                    ->join('sc_schools', 'sc_studies.sc_school_id', '=', 'sc_schools.id')
                    ->where('sc_schools.id', request()->user()->sc_school_id)
                    ->join('sc_classes', 'sc_studies.sc_class_id', '=', 'sc_classes.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->where('sc_studies.id', 'like', '%' . $search . '%')
                    ->orWhere('sc_studies.name', 'like', '%' . $search . '%')
                    ->orWhere('sc_studies.day', 'like', '%' . $search . '%')
                    ->orWhere('sc_studies.time', 'like', '%' . $search . '%')
                    ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                    ->orWhere('sc_classes.name', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.id', 'like', '%' . $search . '%')
                    ->select(
                        'sc_studies.id', 'sc_studies.name', 'sc_studies.day', 'sc_studies.time', 'sc_studies.created_at','sc_studies.updated_at',
                        'sc_schools.name as sc_school_name',
                        'sc_classes.name as sc_class_name',
                        'users.name as user_name', 'users.id as user_id', 'users.nisn')
                    ->paginate($paginate), 200);
            }
        } else {
            return response()->json(['message' => 'Not allowed'], 401);
        }
    }

    /**
     * Download a file excel of the export.
     *
     * @param $user
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function export($user, $email) 
    {
        $check = User::where('id', $user)->pluck('email');
        if($check[0] == $email) {
            return Excel::download(new StudyExport, 'study_export.xlsx');
        } else {
            return response()->json(['message' => 'Not allowed'], 401);
        }
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
                Excel::import(new StudyImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
}
