<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// vendor
use Carbon\Carbon;
// model
use App\Models\ScTeacher;

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
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
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
            ScTeacher::where('id', $scTeacher)->update([
                'user_id' => $request->user_id,
                'sc_school_id' => $request->sc_school_id,
                'title' => $request->title,
                'graduate' => $request->graduate,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly create data'], 200);
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
        ScTeacher::where('id', $scTeacher)->delete();
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
        return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->orderBy($order, $type)
            ->select(
                'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                'sc_schools.name as sc_school_name',
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
        return response()->json(ScTeacher::join('sc_schools', 'sc_teachers.sc_school_id', '=', 'sc_schools.id')
            ->join('users', 'sc_teachers.user_id', '=', 'users.id')
            ->orderBy($order, $type)
            ->where('sc_teachers.id', 'like', '%' . $search . '%')
            ->orWhere('sc_teachers.title', 'like', '%' . $search . '%')
            ->orWhere('sc_teachers.graduate', 'like', '%' . $search . '%')
            ->select(
                'sc_teachers.id', 'sc_teachers.title', 'sc_teachers.graduate', 'sc_teachers.created_at', 'sc_teachers.updated_at',
                'sc_schools.id as sc_school_id', 'sc_schools.name as sc_school_name',
                'users.name as user_name', 'users.id as user_id', 'users.nisn')
            ->paginate($columns), 200);
    }
}
