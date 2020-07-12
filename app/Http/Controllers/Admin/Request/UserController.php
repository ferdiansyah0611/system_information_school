<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// excel
use App\Exports\UserExport;
use App\Imports\UserImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\User;

class UserController extends Controller
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
            'sc_school_id' => 'required|numeric',
            'name' => 'required|string||min:3|max:191',
            'email' => 'required|email',
            'nisn' => 'required|numeric',
            'password' => 'required|string',
            'role' => 'required|string',
            'location' => 'required|string',
            'born' => 'required|date',
            'languange' => 'required|string|min:2',
            'gender' => 'required|string',
            'religious' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            if($request->file('file')) {
                $validator_file = Validator::make($request->all(), [
                    'file' => 'file|image|max:2000|mimes:jpg,png,jpeg'
                ]);
                if($validator_file->fails()) {
                    return response()->json(['message' => $validator_file->errors()], 401);
                } else {
                    $file = $request->file('file');
                    $file->move('app/public/image/', $file->getClientOriginalName());
                    $data['avatar'] = $file->getClientOriginalName();
                }
            } else {
                if($request->role == 'administrator' || $request->role == 'admin') {
                    $data['avatar'] = 'avatar-admin.png';
                }
                if($request->role == 'teacher') {
                    if($request->gender == 'male') {
                        $data['avatar'] = 'avatar-teacher-male.png';
                    }
                    if($request->gender == 'female') {
                        $data['avatar'] = 'avatar-teacher-female.png';
                    }
                }
                if($request->role == 'student') {
                    if($request->gender == 'male') {
                        $data['avatar'] = 'avatar-student-male.png';
                    }
                    if($request->gender == 'female') {
                        $data['avatar'] = 'avatar-student-female.png';
                    }
                }
            }
            User::create($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        return response()->json(User::where('id', $user)->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'sc_school_id' => 'required|numeric',
            'name' => 'required|string||min:3|max:191',
            'email' => 'required|email',
            'nisn' => 'required|numeric',
            'role' => 'required|string',
            'location' => 'required|string',
            'born' => 'required|date',
            'languange' => 'required|string|min:2',
            'gender' => 'required|string',
            'religious' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            if($request->file('file')) {
                $validator_file = Validator::make($request->all(), [
                    'file' => 'file|image|max:2000|mimes:jpg,png,jpeg'
                ]);
                if($validator_file->fails()) {
                    return response()->json(['message' => $validator_file->errors()], 401);
                } else {
                    $file = $request->file('file');
                    $file->move('app/public/image/', $file->getClientOriginalName());
                    $data['avatar'] = $file->getClientOriginalName();
                }
            }
            User::create($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        User::where('id', $user)->delete();
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
            return response()->json(User::orderBy($order, $type)
                ->paginate($columns), 200);
        }
        if($role == 'admin') {
            return response()->json(User::orderBy($order, $type)
                ->where('sc_school_id', request()->user()->sc_school_id)
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
        $role = request()->user()->role;
        if($role == 'administrator') {
            return response()->json(User::where('id', 'like', '%' . $search . '%')
                ->orderBy($order, $type)
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('nisn', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%')
                ->orWhere('born', 'like', '%' . $search . '%')
                ->orWhere('gender', 'like', '%' . $search . '%')
                ->paginate($paginate), 200);
        }
        if($role == 'admin') {
            return response()->json(User::where('id', 'like', '%' . $search . '%')
                ->orderBy($order, $type)
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('nisn', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%')
                ->orWhere('born', 'like', '%' . $search . '%')
                ->orWhere('gender', 'like', '%' . $search . '%')
                ->paginate($paginate), 200);
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
            return Excel::download(new UserExport, 'user_export.xlsx');
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
                Excel::import(new UserImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
}
