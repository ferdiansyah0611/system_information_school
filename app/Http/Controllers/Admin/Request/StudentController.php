<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// exports
use App\Exports\StudentExport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\Models\ScStudent;
use App\User;
class StudentController extends Controller
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
            'sc_class_id' => 'required|numeric',
            'phone' => 'required|numeric',
            'phone_father' => 'required|numeric',
            'phone_mother' => 'required|numeric',
            'father' => 'required|string|min:2|max:191',
            'mother' => 'required|string|min:2|max:191',
            'work_father' => 'required|string|min:2|max:191',
            'work_mother' => 'required|string|min:2|max:191',
            'generation' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            if($request->file('file')){
                $file = $request->file('file');
                $file->move(storage_path('app/public/image'), $file->getClientOriginalName());
                User::where('id', $request->user_id)->update([
                    'avatar' => $file->getClientOriginalName(),
                    'role' => 'student',
                    'updated_at' => $this->timestamp
                ]);
            }
            $app = new ScStudent;
            $app->id = $this->random;
            $app->user_id = $request->user_id;
            $app->sc_school_id = $request->sc_school_id;
            $app->sc_class_id = $request->sc_class_id;
            $app->phone = $request->phone;
            $app->father = $request->father;
            $app->mother = $request->mother;
            $app->work_father = $request->work_father;
            $app->work_mother = $request->work_mother;
            $app->phone_father = $request->phone_father;
            $app->phone_mother = $request->phone_mother;
            $app->generation = $request->generation;
            $app->save();
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scStudent
     * @return \Illuminate\Http\Response
     */
    public function show($scStudent)
    {
        return response()->json(ScStudent::join('users', 'sc_students.user_id', '=', 'users.id')
            ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_students.sc_class_id', '=', 'sc_classes.id')
            ->where('sc_students.id', $scStudent)
            ->select(
                'sc_students.id', 'sc_students.phone', 'sc_students.father', 'sc_students.mother', 'sc_students.work_father', 'sc_students.work_mother', 'sc_students.phone_father', 'sc_students.phone_mother', 'sc_students.generation',
                'sc_students.created_at','sc_students.updated_at',
                'sc_schools.name as sc_school_name', 'sc_schools.id as sc_school_id',
                'sc_classes.name as sc_class_name', 'sc_classes.id as sc_class_id',
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
            ->get(), 200);
        return response()->json($scStudent->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $scStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scStudent)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'sc_school_id' => 'required|numeric',
            'sc_class_id' => 'required|numeric',
            'phone' => 'required|numeric',
            'phone_father' => 'required|numeric',
            'phone_mother' => 'required|numeric',
            'father' => 'required|string|min:2|max:191',
            'mother' => 'required|string|min:2|max:191',
            'work_father' => 'required|string|min:2|max:191',
            'work_mother' => 'required|string|min:2|max:191',
            'generation' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            ScStudent::where('id', $scStudent)->update([
                'user_id' => $request->user_id,
                'sc_school_id' => $request->sc_school_id,
                'sc_class_id' => $request->sc_class_id,
                'phone' => $request->phone,
                'father' => $request->father,
                'mother' => $request->mother,
                'phone_father' => $request->phone_father,
                'phone_mother' => $request->phone_mother,
                'work_father' => $request->work_father,
                'work_mother' => $request->work_mother,
                'generation' => $request->generation,
                'updated_at' => $this->timestamp
            ]);
            User::where('id', $request->user_id)->update([
                'nisn' => $request->nisn
            ]);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\$scStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy($scStudent)
    {
        ScSchool::where('id', $scStudent)->delete();
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
        /*student = id phone father mother phone_father phone_mother generation*/
        /*school = name*/
        /*class = name*/
        /*user = id name*/
        return response()->json(ScStudent::join('users', 'sc_students.user_id', '=', 'users.id')
            ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_students.sc_class_id', '=', 'sc_classes.id')
            ->orderBy($order, $type)
            ->select(
                'sc_students.id', 'sc_students.phone', 'sc_students.father', 'sc_students.mother', 'sc_students.phone_father', 'sc_students.phone_mother', 'sc_students.generation',
                'sc_students.created_at','sc_students.updated_at',
                'sc_schools.name as sc_school_name',
                'sc_classes.name as sc_class_name',
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
            ->paginate($columns), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $$order $type $search $paginate
     * @return \Illuminate\Http\Response
     */
    public function searching($order, $type, $search, $paginate)
    {
        return response()->json(ScStudent::join('users', 'sc_students.user_id', '=', 'users.id')
            ->join('sc_schools', 'sc_students.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_students.sc_class_id', '=', 'sc_classes.id')
            ->orderBy($order, $type)
            ->where('sc_students.id', 'like', '%' . $search . '%')
            ->orWhere('sc_students.phone', 'like', '%' . $search . '%')
            ->orWhere('sc_students.father', 'like', '%' . $search . '%')
            ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
            ->orWhere('users.name', 'like', '%' . $search . '%')
            ->orWhere('users.id', 'like', '%' . $search . '%')
            ->select(
                'sc_students.id', 'sc_students.phone', 'sc_students.father', 'sc_students.mother', 'sc_students.phone_father', 'sc_students.phone_mother', 'generation',
                'sc_students.created_at','sc_students.updated_at',
                'sc_schools.name as sc_school_name',
                'sc_classes.name as sc_class_name',
                'users.name as user_name', 'users.id as user_id')
            ->paginate($paginate), 200);
    }

    /**
     * Download a file excel of the export.
     *
     * @param $user
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function export($user) 
    {
        return Excel::download(new StudentExport, 'student_export.xlsx');
    }
}
