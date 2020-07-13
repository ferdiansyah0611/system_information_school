<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
// model
use App\Models\ScClassroomPost;
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
            $data['id'] => $this->random;
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
            /*quest choice*/
            if($request->type == 'quest_choice') {
                $data_choice = $request->all();
                $data_choice['sc_classroom_post_id'] = $this->random;
                $data_choice['answer'] = $request->answer;
                $data_choice['correct'] = $request->correct;
                /*upload file_choices*/
                if($request->file('file_choices')) {
                    $file = $request->file('file_choices');
                    $name = $file->getClientOriginalName();
                    $file->move(storage_path('app/public/asset'), $name);
                    $data_choice['file_choices'] = $name;
                }
                ScClassroomQuestChoice::create($data_choice);
            }
            /*quest fill*/
            if($request->type == 'quest_fill') {
                $data_fill = $request->all();
                $data_fill['sc_classroom_post_id'] = $this->random;
                $data_fill['answer'] = $request->answer;
                $data_fill['correct'] = $request->correct;
                /*upload file_fills*/
                if($request->file('file_fills')) {
                    $file = $request->file('file_fills');
                    $name = $file->getClientOriginalName();
                    $file->move(storage_path('app/public/asset'), $name);
                    $data_fill['file_fills'] = $name;
                }
                ScClassroomQuestFill::create($data_fill);
            }
            ScClassroomPost::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScClassroomPost  $scClassroomPost
     * @return \Illuminate\Http\Response
     */
    public function show(ScClassroomPost $scClassroomPost)
    {
        //
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
