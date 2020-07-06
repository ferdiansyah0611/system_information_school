<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
/*authentication api*/
Route::post('login', 'AuthenticateController@login');
Route::post('register', 'AuthenticateController@register');
/*auth middleware api passport token*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Admin\Request', 'middleware' => 'auth:api'], function(){
    Route::apiResource('class', 'ClassController');
    Route::apiResource('school', 'SchoolController');
    Route::apiResource('student', 'StudentController');
    Route::post('student/update/{any}', 'StudentController@update');
    Route::apiResource('study', 'StudyController');
    
    Route::apiResource('teacher', 'TeacherController');
    Route::post('teacher/update/{any}', 'TeacherController@update');

    Route::apiResource('assessment-task', 'AssessmentTaskController');
    Route::apiResource('homeroom-teacher', 'HomeRoomTeacherController');
    Route::apiResource('report-card', 'ReportCardController');
    Route::apiResource('note', 'NoteController');
    /*import*/
    Route::post('class/excel/import/{any}', 'ClassController@import')->name('class.import');
    Route::post('school/excel/import/{any}', 'SchoolController@import')->name('school.import');
    Route::post('student/excel/import/{any}', 'StudentController@import')->name('student.import');
    Route::post('study/excel/import/{any}', 'StudyController@import')->name('study.import');
    Route::post('teacher/excel/import/{any}', 'TeacherController@import')->name('teacher.import');
    Route::post('assessment-task/excel/import/{any}', 'AssessmentTaskController@import')->name('assessment-task.import');
    Route::post('homeroom-teacher/excel/import/{any}', 'HomeRoomTeacherController@import')->name('homeroom-teacher.import');
    Route::post('report-card/excel/import/{any}', 'ReportCardController@import')->name('report-card.import');
});
Route::group(['namespace' => 'Admin\Request'], function(){
    Route::get('test', 'AdminController@sending');
    Route::get('dashboard', 'AdminController@dashboard');
    /*export*/
    Route::get('class/excel/export/{user}/{email}', 'ClassController@export')->name('class.export');
    Route::get('school/excel/export/{user}/{email}', 'SchoolController@export')->name('school.export');
    Route::get('student/excel/export/{user}/{email}', 'StudentController@export')->name('student.export');
    Route::get('study/excel/export/{user}/{email}', 'StudyController@export')->name('study.export');
    Route::get('teacher/excel/export/{user}/{email}', 'TeacherController@export')->name('teacher.export');
    Route::get('assessment-task/excel/export/{user}/{email}', 'AssessmentTaskController@export')->name('assessment-task.export');
    Route::get('homeroom-teacher/excel/export/{user}/{email}', 'HomeRoomTeacherController@export')->name('homeroom-teacher.export');
    Route::get('report-card/excel/export/{user}/{email}', 'ReportCardController@export')->name('report-card.export');
});
Route::group(['middleware' => 'auth:api'], function(){
    /*search*/
    Route::get('search/{any}', 'HomeController@search')->name('search');
});
/*Route::get('example', function(){
    dd(User::where('id', '1')->pluck('avatar')[0]);
    return response()->json(User::where('id', '1')->pluck('avatar'),200);
});*/