<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// vendor
use Carbon\Carbon;
// model
use App\models\ScNote;

class NoteController extends Controller
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
        return response()->json(ScNote::where('user_id', request()->user()->id)->paginate(25), 200);
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
            'title' => 'required|string|min:2|max:191',
            'note' => 'required|string|min:2|max:5000',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            ScNote::create([
                'id' => $this->random,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'note' => $request->note
            ]);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\ScNote  $scNote
     * @return \Illuminate\Http\Response
     */
    public function show($scNote)
    {
        return response()->json(ScNote::where('id', $scNote)->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\ScNote  $scNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scNote)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:2|max:191',
            'note' => 'required|string|min:2|max:5000',
        ]);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            ScNote::where('user_id', $request->user()->id)->where('id', $scNote)->update([
                'title' => $request->title,
                'note' => $request->note,
                'updated_at' => $this->timestamp
            ]);
            return response()->json(['message' => 'Successfuly delete data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\ScNote  $scNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($scNote)
    {
        ScNote::where('id', $scNote)->delete();
        return response()->json(['message' => 'Successfuly delete data'], 200);
    }
}
