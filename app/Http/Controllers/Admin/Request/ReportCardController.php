<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// excel
use App\Exports\ReportCardExport;
use App\Imports\ReportCardImport;
// vendor
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// model
use App\Models\ScClass;
use App\Models\ScSchool;
use App\Models\ScHomeRoomTeacher;
use App\Models\ScTypeReportCard;
use App\Models\ScReportCardSenior;
use App\Models\ScReportCardJunior;
use App\Models\ScReportCardElementary;
use App\Models\ScReportCardExtraCurricular;
use App\User;

class ReportCardController extends Controller
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
        // validation variable
        $numeric = 'required|numeric';
        $string_type = 'required|string|min:10|max:20';
        $string_description = 'required|string|min:10|max:2000';

        $validator = Validator::make($request->all(), [
            'sc_home_room_teacher_id' => $numeric,
            'sc_student_id' => $numeric,
            'type' => $string_type,
            'description' => $string_description,
            'period' => 'required|date',
            'absent_broken' => $numeric,
            'absent_permission' => $numeric,
            'absent_without_explanation' => $numeric,
            'personality_behavior' => $numeric,
            'personality_diligence' => $numeric,
            'personality_neatness' => $numeric,
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        }else{
            $ScHomeRoomTeacher = ScHomeRoomTeacher::where('id', $request->sc_home_room_teacher_id)->get('sc_class_id');
            // type
            ScTypeReportCard::create([
                'id' => $this->random,
                'sc_home_room_teacher_id' => $request->sc_home_room_teacher_id,
                'sc_student_id' => $request->sc_student_id,
                'type' => $request->type,
                'period' => $request->period,
                'description' => $request->description,
                'absent_broken' => $request->absent_broken,
                'absent_permission' => $request->absent_permission,
                'absent_without_explanation' => $request->absent_without_explanation,
                'personality_behavior' => $request->personality_behavior,
                'personality_diligence' => $request->personality_diligence,
                'personality_neatness' => $request->personality_neatness,
            ]);
            foreach($ScHomeRoomTeacher as $data) {
                $ScClass = ScClass::where('id', $data->sc_class_id)->get('sc_school_id');
                foreach($ScClass as $class) {
                    $ScSchool = ScSchool::where('id', $class->sc_school_id)->get('type');
                    foreach($ScSchool as $school) {
                        if($school->type == 'senior_high_school'){
                            $validator_senior = Validator::make($request->all(), [
                                'sc_study_id' => $numeric,
                                'score' => $numeric,
                                'kkm_k3' => $numeric,
                                'kkm_k4' => $numeric,
                                'k3_ph' => $numeric,
                                'k3_pts' => $numeric,
                                'k4_pr' => $numeric,
                                'status' => 'required|string|min:1|max:191',
                                'predicate' => 'required|string|min:1|max:191',
                            ]);
                            if($validator_senior->fails()){
                                return response()->json(['message' => $validator_senior->errors()], 401);
                            }else{
                                // senior
                                ScReportCardSenior::create([
                                    'id' => $this->random,
                                    'sc_study_id' => $request->sc_study_id,
                                    'score' => $request->score,
                                    'kkm_k3' => $request->kkm_k3,
                                    'kkm_k4' => $request->kkm_k4,
                                    'k3_ph' => $request->k3_ph,
                                    'k3_pts' => $request->k3_pts,
                                    'k4_pr' => $request->k4_pr,
                                    'status' => $request->status,
                                    'predicate' => $request->predicate,/*a b*/
                                ]);
                                return response()->json(['message' => 'Successfuly create data'], 200);
                            }
                        }
                        if($school->type == 'junior_high_school') {

                        }
                        if($school->type == 'elementary_school') {
                            $validator_elementary = Validator::make($request->all(), [
                                'sc_study_id' => $numeric,
                                'score' => $numeric,
                                'kkm' => $numeric,
                                'status' => 'required|string|min:1|max:191',
                                'predicate' => 'required|string|min:1|max:191',
                            ]);
                            if($validator_elementary->fails()){
                                return response()->json(['message' => $validator_elementary->errors()], 401);
                            }else{
                                ScReportCardElementary::create([
                                    'id' => $this->random,
                                    'sc_study_id' => $request->sc_study_id,
                                    'score' => $request->score,
                                    'kkm' => $request->kkm,
                                    'status' => $request->status,
                                    'predicate' => $request->predicate,
                                ]);
                                return response()->json(['message' => 'Successfuly create data'], 200);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scTypeReportCard
     * @return \Illuminate\Http\Response
     */
    public function show($scTypeReportCard)
    {
        $ScSchool = ScSchool::where('id', request()->user()->sc_school_id)->get('type');
        foreach($ScSchool as $school) {
            if($school->type == 'senior_high_school') {
                return response()->json(ScTypeReportCard::join('sc_students', 'sc_type_report_cards.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_report_card_seniors', 'sc_type_report_cards.id', '=', 'sc_report_card_seniors.id')
                ->join('sc_studies', 'sc_report_card_seniors.sc_study_id', '=', 'sc_studies.id')
                ->where('sc_type_report_cards.id', $scTypeReportCard)
                ->orderBy('id', 'asc')
                ->select(
                    'sc_type_report_cards.id', 'sc_type_report_cards.sc_home_room_teacher_id', 'sc_type_report_cards.sc_student_id',
                    'sc_type_report_cards.type', 'sc_type_report_cards.period', 'sc_type_report_cards.description',
                    'sc_type_report_cards.absent_broken', 'sc_type_report_cards.absent_permission', 'sc_type_report_cards.absent_without_explanation',
                    'sc_type_report_cards.personality_behavior', 'sc_type_report_cards.personality_diligence', 'sc_type_report_cards.personality_neatness',
                    'sc_type_report_cards.created_at', 'sc_type_report_cards.updated_at',
                    'users.name as student_name', 'users.id as user_id', 'sc_type_report_cards.sc_home_room_teacher_id',
                    'sc_studies.name as study_name',
                    'sc_report_card_seniors.id as sc_report_card_senior_id', 'sc_report_card_seniors.score',
                    'sc_report_card_seniors.kkm_k3', 'sc_report_card_seniors.kkm_k4', 'sc_report_card_seniors.k3_ph',
                    'sc_report_card_seniors.k3_pts', 'sc_report_card_seniors.k4_pr', 'sc_report_card_seniors.status',
                    'sc_report_card_seniors.predicate'
                )
                ->get(), 200);
            }
            if($school->type == 'junior_high_school') {

            }
            if($school->type == 'elementary_school') {
                /*ScReportCardElementary = */
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScTypeReportCard  $scTypeReportCard
     * @return \Illuminate\Http\Response
     */
    public function update($scTypeReportCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $scTypeReportCard
     * @return \Illuminate\Http\Response
     */
    public function destroy($scTypeReportCard)
    {
        ScTypeReportCard::where('id', $scTypeReportCard)->delete();
        $ScSchool = ScSchool::where('id', request()->user()->sc_school_id)->get('type');
        foreach($ScSchool as $school) {
            if($school->type == 'senior_high_school') {
                ScReportCardSenior::where('id', $scTypeReportCard)->delete();
            }
            if($school->type == 'junior_high_school') {
                ScReportCardJunior::where('id', $scTypeReportCard)->delete();
            }
            if($school->type == 'elementary_school') {
                ScReportCardElementary::where('id', $scTypeReportCard)->delete();
            }
            ScReportCardExtraCurricular::where('sc_type_report_card_id', $scTypeReportCard)->delete();
        }
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
        /*ScTypeReportCard = id, sc_student_id, student_name, sc_home_room_teacher_id*/
        $ScSchool = ScSchool::where('id', request()->user()->sc_school_id)->get('type');
        foreach($ScSchool as $school) {
            if($school->type == 'senior_high_school') {
                /*ScReportCardSenior = study_name, score, status, predicate*/
                return response()->json(ScTypeReportCard::join('sc_students', 'sc_type_report_cards.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_report_card_seniors', 'sc_type_report_cards.id', '=', 'sc_report_card_seniors.id')
                ->join('sc_studies', 'sc_report_card_seniors.sc_study_id', '=', 'sc_studies.id')
                ->orderBy($order, $type)
                ->select(
                    'sc_type_report_cards.id', 'sc_type_report_cards.sc_home_room_teacher_id', 'sc_type_report_cards.sc_student_id',
                    'sc_type_report_cards.created_at', 'sc_type_report_cards.updated_at',
                    'users.name as student_name', 'users.id as user_id', 'sc_type_report_cards.sc_home_room_teacher_id as home_room_teacher_id',
                    'sc_report_card_seniors.id as sc_report_card_senior_id', 'sc_report_card_seniors.score', 'sc_report_card_seniors.status', 'sc_report_card_seniors.predicate',
                    'sc_studies.name as study_name'
                )
                ->paginate($columns), 200);
            }
            if($school->type == 'junior_high_school') {

            }
            if($school->type == 'elementary_school') {
                /*ScReportCardElementary = */
            }
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
        /*ScTypeReportCard = id, student_name*/
        $ScSchool = ScSchool::where('id', request(t)->user()->sc_school_id)->get('type');
        foreach($ScSchool as $school) {
            if($school->type == 'senior_high_school') {
                /*ScReportCardSenior = study_name, score, status, predicate*/
                return response()->json(ScTypeReportCard::join('sc_students', 'sc_type_report_cards.sc_student_id', '=', 'sc_students.id')
                ->join('users', 'sc_students.user_id', '=', 'users.id')
                ->join('sc_report_card_seniors', 'sc_type_report_cards.id', '=', 'sc_report_card_seniors.id')
                ->join('sc_studies', 'sc_report_card_seniors.sc_study_id', '=', 'sc_studies.id')
                ->where('sc_type_report_cards.id', 'like', '%' . $search . '%')
                ->orWhere('users.name', 'like', '%' . $search . '%')
                ->orWhere('sc_studies.name', 'like', '%' . $search . '%')
                ->orWhere('sc_report_card_seniors.score', 'like', '%' . $search . '%')
                ->orWhere('sc_report_card_seniors.status', 'like', '%' . $search . '%')
                ->orWhere('sc_report_card_seniors.predicate', 'like', '%' . $search . '%')
                ->orderBy($order, $type)
                ->select(
                    'sc_type_report_cards.id', 'sc_type_report_cards.sc_home_room_teacher_id', 'sc_type_report_cards.sc_student_id',
                    'sc_type_report_cards.created_at', 'sc_type_report_cards.updated_at',
                    'users.name as student_name', 'users.id as user_id', 'sc_type_report_cards.sc_home_room_teacher_id',
                    'sc_report_card_seniors.id as sc_report_card_senior_id', 'sc_report_card_seniors.score', 'sc_report_card_seniors.status', 'sc_report_card_seniors.predicate',
                    'sc_studies.name as study_name'
                )
                ->paginate($paginate), 200);
            }
            if($school->type == 'junior_high_school') {

            }
            if($school->type == 'elementary_school') {
                /*ScReportCardElementary = */
            }
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
            return Excel::download(new ReportCardExport, 'report_card_export_export.xlsx');
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
                Excel::import(new ReportCardImport, storage_path('app/public/office/' . $file->getClientOriginalName() ));
                return response()->json(['message' => 'Successfuly import data'], 200);
            } else {
                return response()->json(['message' => 'Not allowed'], 401);
            }
        }
    }
}
