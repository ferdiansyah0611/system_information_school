<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// excel
use App\Exports\SchoolExport;
use App\Imports\SchoolImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\Models\ScSchool;
use App\User;

class SchoolController extends Controller
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
            'name' => 'required|string|min:2|max:191',
            'description' => 'required|string|min:2|max:191',
            'type' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            $app = new ScSchool;
            $app->id = $this->random;
            $app->user_id = $request->user_id;
            $app->name = $request->name;
            $app->description = $request->description;
            $app->type = $request->type;
            $app->save();
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(ScSchool::join('users', 'sc_schools.user_id', '=', 'users.id')
            ->orderBy('name', 'asc')
            ->where('sc_schools.id', $id)
            ->select(
                'sc_schools.id', 'sc_schools.name', 'sc_schools.description', 'sc_schools.type',
                'sc_schools.created_at','sc_schools.updated_at',
                'users.name as user_name', 'users.id as user_id')
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\$scSchool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scSchool)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:191',
            'description' => 'required|string|min:2|max:191',
            'type' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            ScSchool::where('id', $scSchool)->update([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\$scSchool
     * @return \Illuminate\Http\Response
     */
    public function destroy($scSchool)
    {
        ScSchool::where('id', $scSchool)->delete();
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
        return response()->json(ScSchool::join('users', 'sc_schools.user_id', '=', 'users.id')
            ->orderBy($order, $type)
            ->select(
                'sc_schools.id', 'sc_schools.name', 'sc_schools.description',
                'sc_schools.created_at','sc_schools.updated_at',
                'users.name as user_name', 'users.id as user_id')
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
        return response()->json(ScSchool::join('users', 'sc_schools.user_id', '=', 'users.id')
            ->orderBy($order, $type)
            ->where('sc_schools.id', 'like', '%' . $search . '%')
            ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
            ->orWhere('sc_schools.description', 'like', '%' . $search . '%')
            ->orWhere('users.name', 'like', '%' . $search . '%')
            ->orWhere('users.id', 'like', '%' . $search . '%')
            ->select(
                'sc_schools.id', 'sc_schools.name', 'sc_schools.description',
                'sc_schools.created_at','sc_schools.updated_at',
                'users.name as user_name', 'users.id as user_id')
            ->paginate($paginate), 200);
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
            return Excel::download(new SchoolExport, 'school_export.xlsx');
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
                Excel::import(new SchoolImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
}