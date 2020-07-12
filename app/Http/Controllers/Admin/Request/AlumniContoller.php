<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// vendor
use Carbon\Carbon;
// model
use App\Models\ScAlumniStudent;

class AlumniContoller extends Controller
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
        // default url
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
            'sc_student_id' => 'required|numeric',
            'student_id_number' => 'required|numeric',
            'work' => 'required|string|min:3|max:191',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            $data['id'] = $this->random;
            ScAlumniStudent::create($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scAlumniStudent
     * @return \Illuminate\Http\Response
     */
    public function show($scAlumniStudent)
    {
        return response()->json(ScAlumniStudent::join('sc_students', 'sc_alumni_students.sc_student_id', '=', 'sc_students.id')
            ->join('users', 'sc_students.user_id', '=', 'users.id')
            ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
            ->where('sc_alumni_students.id', $scAlumniStudent)
            ->select('sc_alumni_students.id', 'sc_alumni_students.sc_student_id', 'sc_alumni_students.student_id_number',
                'sc_alumni_students.work', 'sc_alumni_students.created_at', 'sc_alumni_students.updated_at',
                'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                'users.name as user_name', 'users.nisn', 'users.avatar',
                'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
            )
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $scAlumniStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scAlumniStudent)
    {
        $validator = Validator::make($request->all(), [
            'sc_student_id' => 'required|numeric',
            'student_id_number' => 'required|numeric',
            'work' => 'required|string|min:3|max:191',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            ScAlumniStudent::where('id', $scAlumniStudent)->update($request->all());
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScAlumniStudent  $scAlumniStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy($scAlumniStudent)
    {
        ScAlumniStudent::where('id', $scAlumniStudent)->delete();
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
        $role = request()->user()->role;
        if($role == 'administrator') {
            return response()->json(ScAlumniStudent::join('sc_students', 'sc_alumni_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->select('sc_alumni_students.id', 'sc_alumni_students.sc_student_id', 'sc_alumni_students.student_id_number',
                    'sc_alumni_students.work', 'sc_alumni_students.created_at', 'sc_alumni_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.nisn', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($columns), 200);
        }
        if($role == 'admin') {
            return response()->json(ScAlumniStudent::join('sc_students', 'sc_alumni_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_students.sc_school_id', request()->user()->sc_school_id)
                ->select('sc_alumni_students.id', 'sc_alumni_students.sc_student_id', 'sc_alumni_students.student_id_number',
                    'sc_alumni_students.work', 'sc_alumni_students.created_at', 'sc_alumni_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.nisn', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($columns), 200);
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
        /*id, name school, user name, student_id_number, work, updated_at*/
        $role = request()->user()->role;
        if($role == 'administrator') {
            return response()->json(ScAlumniStudent::join('sc_students', 'sc_alumni_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_alumni_students.id', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                ->orWhere('users.name', 'like', '%' . $search . '%')
                ->orWhere('sc_alumni_students.student_id_number', 'like', '%' . $search . '%')
                ->orWhere('sc_alumni_students.work', 'like', '%' . $search . '%')
                ->select('sc_alumni_students.id', 'sc_alumni_students.sc_student_id', 'sc_alumni_students.student_id_number',
                    'sc_alumni_students.work', 'sc_alumni_students.created_at', 'sc_alumni_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.nisn', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($columns), 200);
        }
        if($role == 'admin' || $role == 'teacher') {
            return response()->json(ScAlumniStudent::join('sc_students', 'sc_alumni_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_schools.id', request()->user()->sc_school_id)
                ->where('sc_alumni_students.id', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                ->orWhere('users.name', 'like', '%' . $search . '%')
                ->orWhere('sc_alumni_students.student_id_number', 'like', '%' . $search . '%')
                ->orWhere('sc_alumni_students.work', 'like', '%' . $search . '%')
                ->select('sc_alumni_students.id', 'sc_alumni_students.sc_student_id', 'sc_alumni_students.student_id_number',
                    'sc_alumni_students.work', 'sc_alumni_students.created_at', 'sc_alumni_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.nisn', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($columns), 200);
        } else {
            return response()->json(['message' => 'Not allowed'], 401);
        }
    }
}
