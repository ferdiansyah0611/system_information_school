<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// venor
use Carbon\Carbon;
// model
use App\Models\ScAbsentStudent;

class AbsentStudentController extends Controller
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
            'date' => 'required|date',
            'status' => 'required|string|min:4'
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            $role = request()->user()->role;
            if($role == 'administrator' || $role == 'admin' || $role == 'teacher') {
                if($request->opinion) {
                    $data['opinion'] = $request->opinion;
                } else {
                    $data['opinion'] = 'OK';
                }
            }
            if($role == 'student') {
                $data['opinion'] = 'present';
            }
            ScAbsentStudent::create($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scAbsentStudent
     * @return \Illuminate\Http\Response
     */
    public function show($scAbsentStudent)
    {
        return response()->json(ScAbsentStudent::where('sc_absent_students.id', $scAbsentStudent)
            ->join('sc_students', 'sc_absent_students.sc_student_id', '=', 'sc_students.id')
            ->join('users', 'sc_students.user_id', '=', 'users.id')
            ->select('sc_absent_students.id', 'sc_absent_students.sc_student_id', 'sc_absent_students.date',
                'sc_absent_students.status', 'sc_absent_students.opinion', 'sc_absent_students.created_at', 'sc_absent_students.updated_at',
                'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                'users.name', 'users.email', 'users.nisn', 'users.role', 'users.avatar'
            )
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $scAbsentStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scAbsentStudent)
    {
        $validator = Validator::make($request->all(), [
            'sc_student_id' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|string|min:4',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            $role = request()->user()->role;
            if($role == 'administrator' || $role == 'admin' || $role == 'teacher') {
                if($request->opinion) {
                    $data['opinion'] = $request->opinion;
                } else {
                    $data['opinion'] = 'OK';
                }
            }
            if($role == 'student') {
                $data['opinion'] = 'present';
            }
            ScAbsentStudent::where('id', $scAbsentStudent)->update($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $scAbsentStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy($scAbsentStudent)
    {
        ScAbsentStudent::where('id', $scAbsentStudent)->delete();
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
            return response()->json(ScAbsentStudent::join('sc_students', 'sc_absent_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->select('sc_absent_students.id', 'sc_absent_students.sc_student_id', 'sc_absent_students.date',
                    'sc_absent_students.status', 'sc_absent_students.opinion', 'sc_absent_students.created_at', 'sc_absent_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.email', 'users.nisn', 'users.role', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($columns), 200);
        }
        if($role == 'admin') {
            return response()->json(ScAbsentStudent::join('sc_students', 'sc_absent_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_students.sc_school_id', request()->user()->sc_school_id)
                ->select('sc_absent_students.id', 'sc_absent_students.sc_student_id', 'sc_absent_students.date',
                    'sc_absent_students.status', 'sc_absent_students.opinion', 'sc_absent_students.created_at', 'sc_absent_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.email', 'users.nisn', 'users.role', 'users.avatar',
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
        /*id, name school, user name, status, updated_at*/
        $role = request()->user()->role;
        if($role == 'administrator') {
            return response()->json(ScAbsentStudent::join('sc_students', 'sc_absent_students.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_absent_students.id', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                ->orWhere('users.name', 'like', '%' . $search . '%')
                ->orWhere('sc_absent_students.status', 'like', '%' . $search . '%')
                ->select('sc_absent_students.id', 'sc_absent_students.sc_student_id', 'sc_absent_students.date',
                    'sc_absent_students.status', 'sc_absent_students.opinion', 'sc_absent_students.created_at', 'sc_absent_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.email', 'users.nisn', 'users.role', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($columns), 200);
        }
        if($role == 'admin' || $role == 'teacher') {
            return response()->json(ScAbsentStudent::join('sc_students', 'sc_absent_students.sc_student_id', '=', 'sc_students.id')
                ->orderBy($order, $type)
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
                ->where('sc_schools.id', request()->user()->sc_school_id)
                ->where('sc_absent_students.id', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                ->orWhere('users.name', 'like', '%' . $search . '%')
                ->orWhere('sc_absent_students.status', 'like', '%' . $search . '%')
                ->select('sc_absent_students.id', 'sc_absent_students.sc_student_id', 'sc_absent_students.date',
                    'sc_absent_students.status', 'sc_absent_students.opinion', 'sc_absent_students.created_at', 'sc_absent_students.updated_at',
                    'sc_students.user_id', 'sc_students.sc_school_id', 'sc_students.sc_class_id', 'sc_students.generation',
                    'users.name as user_name', 'users.email', 'users.nisn', 'users.role', 'users.avatar',
                    'sc_schools.name as sc_school_name', 'sc_schools.type as schools_type'
                )
                ->paginate($paginate), 200);
        } else {
            return response()->json(['message' => 'Not allowed'], 401);
        }
    }
}
