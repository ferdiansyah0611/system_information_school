<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// excel
use App\Exports\ClassExport;
use App\Imports\TeacherImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
//model
use App\Models\ScClass;

class ClassController extends Controller
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
            }else{
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
            'name' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            $app = new ScClass;
            $app->id = $this->random;
            $app->sc_school_id = $request->sc_school_id;
            $app->name = $request->name;
            $app->save();
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scClass
     * @return \Illuminate\Http\Response
     */
    public function show($scClass)
    {
        return response()->json(ScClass::where('sc_classes.id', $scClass)->join('sc_schools', 'sc_classes.sc_school_id', '=', 'sc_schools.id')
            ->select('sc_classes.id', 'sc_classes.sc_school_id', 'sc_classes.name', 'sc_schools.name as sc_school_name', 'sc_schools.description', 'sc_classes.created_at', 'sc_classes.updated_at')
            ->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $scClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scClass)
    {
        $validator = Validator::make($request->all(), [
            'sc_school_id' => 'required|numeric',
            'name' => 'required|string|min:2|max:191',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            ScClass::where('id', $scClass)->update([
                'sc_school_id' => $request->sc_school_id,
                'name' => $request->name,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $scClass
     * @return \Illuminate\Http\Response
     */
    public function destroy($scClass)
    {
        ScClass::where('id', $scClass)->delete();
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
        if(request()->user()->role == 'admin'){
            return response()->json(ScClass::join('sc_schools', 'sc_classes.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_classes.sc_school_id', request()->user()->sc_school_id)
                ->select('sc_classes.id', 'sc_classes.sc_school_id', 'sc_classes.name', 'sc_schools.name as sc_school_name', 'sc_schools.description', 'sc_classes.created_at', 'sc_classes.updated_at')
                ->paginate($columns), 200);
        }
        if(request()->user()->role == 'administrator'){
            return response()->json(ScClass::join('sc_schools', 'sc_classes.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->select('sc_classes.id', 'sc_classes.sc_school_id', 'sc_classes.name', 'sc_schools.name as sc_school_name', 'sc_schools.description', 'sc_classes.created_at', 'sc_classes.updated_at')
                ->paginate($columns), 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param $order $type $search $paginate
     * @return \Illuminate\Http\Response
     */
    public function searching($order, $type, $search, $paginate)
    {
        if(request()->user()->role == 'admin'){
            return response()->json(ScClass::join('sc_schools', 'sc_classes.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_classes.name', request()->user()->sc_school_id)
                ->orWhere('sc_classes.id', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.description', 'like', '%' . $search . '%')
                ->select('sc_classes.id', 'sc_classes.sc_school_id', 'sc_classes.name', 'sc_schools.name as sc_school_name', 'sc_schools.description', 'sc_classes.created_at', 'sc_classes.updated_at')
                ->paginate($paginate), 200);
        }
        if(request()->user()->role == 'administrator'){
            return response()->json(ScClass::join('sc_schools', 'sc_classes.sc_school_id', '=', 'sc_schools.id')
                ->orderBy($order, $type)
                ->where('sc_classes.name', 'like', '%' . $search . '%')
                ->orWhere('sc_classes.id', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.name', 'like', '%' . $search . '%')
                ->orWhere('sc_schools.description', 'like', '%' . $search . '%')
                ->select('sc_classes.id', 'sc_classes.sc_school_id', 'sc_classes.name', 'sc_schools.name as sc_school_name', 'sc_schools.description', 'sc_classes.created_at', 'sc_classes.updated_at')
                ->paginate($paginate), 200);
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
            return Excel::download(new ClassExport, 'class_export.xlsx');
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
