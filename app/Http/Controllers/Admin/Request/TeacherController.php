<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use File;
// excel
use App\Exports\TeacherExport;
use App\Imports\TeacherImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\Models\ScTeacher;
use App\User;

class TeacherController extends Controller
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
            'user_id' => 'required|numeric',
            'sc_school_id' => 'required|numeric',
            'title' => 'required|string|min:2|max:191',
            'graduate' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            if($request->file('file')) {
                $validator = Validator::make($request->all(), [
                    'file' => 'image|mimes:jpg,png,jpeg|max:2000',
                ]);
                if($validator->fails()){
                    return response()->json(['message' => $validator->errors()], 401);
                }else{
                    $file = $request->file('file');
                    $fileDefault = User::where('id', $request->user_id)->pluck('avatar')[0];
                    // if name image upload except avatar in table users
                    if($file->getClientOriginalName() !== $fileDefault) {
                        $file->move(storage_path('app/public/image'), $file->getClientOriginalName());
                    }
                    if($fileDefault !== 'avatar-admin.png' || $fileDefault !== 'avatar-student-female.png' || $fileDefault !== 'avatar-student-male.png' || $fileDefault !== 'avatar-teacher-female.png' || $fileDefault !== 'avatar-teacher-male.png') {
                        File::delete(storage_path('app/public/image/' . $fileDefault));
                    }
                    User::where('id', $request->user_id)->update([
                        'avatar' => $file->getClientOriginalName(),
                        'role' => 'student',
                        'updated_at' => $this->timestamp
                    ]);
                }
            }
            $app = new ScTeacher;
            $app->id = $this->random;
            $app->user_id = $request->user_id;
            $app->sc_school_id = $request->sc_school_id;
            $app->title = $request->title;
            $app->graduate = $request->graduate;
            $app->save();
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scTeacher
     * @return \Illuminate\Http\Response
     */
    public function show($scTeacher)
    {
        return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->orderBy('id', 'asc')
            ->where('sc_teachers.id', $scTeacher)
            ->select(
                'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.sc_school_id', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                'sc_schools.name as sc_school_name',
                'users.name as user_name', 'users.id as user_id', 'users.nisn', 'users.avatar')
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\$scTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scTeacher)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'sc_school_id' => 'required|numeric',
            'title' => 'required|string|min:2|max:191',
            'graduate' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            if($request->file('file')) {
                $validator = Validator::make($request->all(), [
                    'file' => 'image|mimes:jpg,png,jpeg|max:2000',
                ]);
                if($validator->fails()){
                    return response()->json(['message' => $validator->errors()], 401);
                }else{
                    $file = $request->file('file');
                    $file->move(storage_path('app/public/image'), $file->getClientOriginalName());
                    $fileDefault = User::where('id', $request->user_id)->pluck('avatar')[0];
                    // if name image upload except avatar in table users
                    if($fileDefault !== 'avatar-admin.png' || $fileDefault !== 'avatar-student-female.png' || $fileDefault !== 'avatar-student-male.png' || $fileDefault !== 'avatar-teacher-female.png' || $fileDefault !== 'avatar-teacher-male.png') {
                        File::delete(storage_path('app/public/image/' . $fileDefault));
                    }
                    User::where('id', $request->user_id)->update([
                        'nisn' => $request->nisn,
                        'avatar' => $file->getClientOriginalName(),
                        'role' => 'teacher',
                        'updated_at' => $this->timestamp
                    ]);
                }
            }
            ScTeacher::where('id', $scTeacher)->update([
                'user_id' => $request->user_id,
                'sc_school_id' => $request->sc_school_id,
                'title' => $request->title,
                'graduate' => $request->graduate,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\$scTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($scTeacher)
    {
        $id = ScTeacher::where('id', $scTeacher);
        $fileDefault = User::where('id', $id->pluck('user_id')[0])->pluck('avatar')[0];
        // if name image upload except avatar in table users
        if($fileDefault !== 'avatar-admin.png' || $fileDefault !== 'avatar-student-female.png' || $fileDefault !== 'avatar-student-male.png' || $fileDefault !== 'avatar-teacher-female.png' || $fileDefault !== 'avatar-teacher-male.png') {
            File::delete(storage_path('app/public/image/' . $fileDefault));
        }
        $id->delete();
        User::where('id', $id->pluck('user_id'))->delete();
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
        /*school = name*/
        /*teacher = id title join users = name nisn*/
        $role = request()->user()->role;
        if($role == 'administrator' || $role == 'admin' || $role == 'teacher') {
            if($role == 'administrator') {
                return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->select(
                        'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                        'sc_schools.name as sc_school_name',
                        'users.name as user_name', 'users.id as user_id', 'users.nisn')
                    ->paginate($columns), 200);
            }
            if($role == 'admin' || $role == 'teacher') {
                return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
                    ->where('sc_schools.id', request()->user()->sc_school_id)
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->select(
                        'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                        'sc_schools.name as sc_school_name',
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
                return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->where('sc_teachers.id', 'like', '%' . $search . '%')
                    ->orWhere('sc_teachers.title', 'like', '%' . $search . '%')
                    ->orWhere('sc_teachers.graduate', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->select(
                        'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                        'sc_schools.id as sc_school_id', 'sc_schools.name as sc_school_name',
                        'users.name as user_name', 'users.id as user_id', 'users.nisn')
                    ->paginate($paginate), 200);
            }
            if($role == 'admin' || $role == 'teacher') {
                return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
                    ->join('users', 'sc_teachers.user_id', '=', 'users.id')
                    ->orderBy($order, $type)
                    ->where('sc_teachers.sc_school_id', request()->user()->sc_school_id)
                    ->where('sc_teachers.title', 'like', '%' . $search . '%')
                    ->orWhere('sc_teachers.id', 'like', '%' . $search . '%')
                    ->orWhere('sc_teachers.graduate', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->select(
                        'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                        'sc_schools.id as sc_school_id', 'sc_schools.name as sc_school_name',
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
            return Excel::download(new TeacherExport, 'teacher_export.xlsx');
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
                Excel::import(new TeacherImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
}
