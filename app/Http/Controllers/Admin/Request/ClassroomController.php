<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
// model
use App\Models\ScTeacher;
use App\Models\ScClassroomPost;
use App\Models\ScClassroomQuestion;
use App\Models\ScClassroomComment;
use App\Models\ScClassroomCommentPrivate;
use App\Models\ScClassroomQuestChoice;
use App\Models\ScClassroomQuestFill;

class ClassroomController extends Controller
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
    public function index()
    {
        //
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
            'description' => 'required|string|min:10|max:2000',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            $data['id'] = $this->random;
            /*upload asset*/
            if($request->file('asset')) {
                $valid_asset = Validator::make($request->all(), [
                    'asset' => 'required|file|max:25000|mimes:jpg,png,jpeg,doc,docx,pdf,xls,xlsx,ppt,pptx'
                ]);
                if($valid_asset->fails()) {
                    return response()->json(['message' => $valid_asset->errors()], 401);
                } else {
                    $file = $request->file('asset');
                    $name = $file->getClientOriginalName();
                    $file->move(storage_path('app/public/asset'), $name);
                    $data['asset'] = $name;
                }
            }
            if($request->type == 'question') {
                $teacher = ScTeacher::where('user_id', request()->user()->id)->pluck('id');
                ScClassroomQuestion::create([
                    'id' => $this->random,
                    'sc_classroom_post_id' => $this->random,
                    'sc_teacher_id' => $teacher[0],
                    'sc_study_id' => $request->sc_study_id,
                    'question' => $request->question,
                    'max_question' => $request->max_question
                ]);
            }
            $data['user_id'] = request()->user()->id;
            ScClassroomPost::create($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $scClassroomPost
     * @return \Illuminate\Http\Response
     */
    public function show($scClassroomPost)
    {
        /*$data = ScClassroomPost::where('id', $scClassroomPost)->get();*/
        $data = ScClassroomPost::with('user')->with('sc_classroom_questions')
        ->where('sc_classroom_posts.id', $scClassroomPost)
        ->where('sc_classroom_questions.sc_classroom_post_id', $scClassroomPost)
        ->get();
        /*$data['question'] = ScClassroomQuestion::where('id', $scClassroomPost)->get();*/
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScClassroomPost  $scClassroomPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScClassroomPost $scClassroomPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScClassroomPost  $scClassroomPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScClassroomPost $scClassroomPost)
    {
        //
    }
}
