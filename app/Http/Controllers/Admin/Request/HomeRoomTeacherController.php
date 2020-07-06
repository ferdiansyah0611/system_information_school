<?php
namespace App\Http\Controllers\Admin\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// excel
use App\Exports\HomeRoomTeacherExport;
use App\Imports\HomeRoomTeacherImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\Models\ScHomeRoomTeacher;
use App\User;

class HomeRoomTeacherController extends Controller
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
            'sc_teacher_id' => 'required|numeric',
            'sc_class_id' => 'required|numeric',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            ScHomeRoomTeacher::create([
                'id' => $this->random,
                'sc_teacher_id' => $request->sc_teacher_id,
                'sc_class_id' => $request->sc_class_id,
                'start_period' => $request->start_period,
                'end_period' => $request->end_period
            ]);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scHomeRoomTeacher
     * @return \Illuminate\Http\Response
     */
    public function show($scHomeRoomTeacher)
    {
        return response()->json(ScHomeRoomTeacher::join('sc_teachers', 'sc_home_room_teachers.sc_teacher_id', '=', 'sc_teachers.id')
            ->join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_home_room_teachers.sc_class_id', '=', 'sc_classes.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->where('sc_home_room_teachers.id', $scHomeRoomTeacher)
            ->orderBy('id', 'asc')
            ->select(
                'sc_home_room_teachers.id', 'sc_home_room_teachers.sc_teacher_id', 'sc_home_room_teachers.sc_class_id', 'sc_home_room_teachers.start_period',
                'sc_home_room_teachers.end_period', 'sc_home_room_teachers.created_at', 'sc_home_room_teachers.updated_at',
                'sc_schools.name as sc_school_name',
                'sc_classes.name as sc_class_name',
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $scHomeRoomTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scHomeRoomTeacher)
    {
        $validator = Validator::make($request->all(), [
            'sc_teacher_id' => 'required|numeric',
            'sc_class_id' => 'required|numeric',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            ScHomeRoomTeacher::where('id', $scHomeRoomTeacher)->update([
                'sc_teacher_id' => $request->sc_teacher_id,
                'sc_class_id' => $request->sc_class_id,
                'start_period' => $request->start_period,
                'end_period' => $request->end_period,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $scHomeRoomTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($scHomeRoomTeacher)
    {
        ScHomeRoomTeacher::where('id', $scHomeRoomTeacher)->delete();
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
        /*school name, classname, username, start_period end_period*/
        return response()->json(ScHomeRoomTeacher::join('sc_teachers', 'sc_home_room_teachers.sc_teacher_id', '=', 'sc_teachers.id')
            ->join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_home_room_teachers.sc_class_id', '=', 'sc_classes.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->orderBy($order, $type)
            ->select(
                'sc_home_room_teachers.id', 'sc_home_room_teachers.sc_teacher_id', 'sc_home_room_teachers.sc_class_id', 'sc_home_room_teachers.start_period',
                'sc_home_room_teachers.end_period', 'sc_home_room_teachers.created_at', 'sc_home_room_teachers.updated_at',
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
        return response()->json(ScHomeRoomTeacher::join('sc_teachers', 'sc_home_room_teachers.sc_teacher_id', '=', 'sc_teachers.id')
            ->join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
            ->join('sc_classes', 'sc_home_room_teachers.sc_class_id', '=', 'sc_classes.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->where('sc_home_room_teachers.id', 'like', '%' . $search . '%')
            ->orWhere('sc_home_room_teachers.start_period', 'like', '%' . $search . '%')
            ->orWhere('sc_home_room_teachers.end_period', 'like', '%' . $search . '%')
            ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
            ->orWhere('sc_classes.name', 'like', '%' . $search . '%')
            ->orWhere('users.name', 'like', '%' . $search . '%')
            ->orderBy($order, $type)
            ->select(
                'sc_home_room_teachers.id', 'sc_home_room_teachers.sc_teacher_id', 'sc_home_room_teachers.sc_class_id', 'sc_home_room_teachers.start_period',
                'sc_home_room_teachers.end_period', 'sc_home_room_teachers.created_at', 'sc_home_room_teachers.updated_at',
                'sc_schools.name as sc_school_name',
                'sc_classes.name as sc_class_name',
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
            ->paginate($columns), 200);
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
            return Excel::download(new HomeRoomTeacherExport, 'homeroom_teacher_export.xlsx');
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
                Excel::import(new HomeRoomTeacherImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
}