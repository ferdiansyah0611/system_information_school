<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Admin\Request'], function(){
    Route::apiResource('class', 'ClassController');
    Route::apiResource('school', 'SchoolController');
    Route::apiResource('student', 'StudentController');
    Route::apiResource('study', 'StudyController');
    Route::apiResource('teacher', 'TeacherController');
    /*route datatable*/
    Route::get('class/datatable', 'ClassController@datatable')->name('class.datatable');
    Route::get('school/datatable', 'SchoolController@datatable')->name('school.datatable');
    Route::get('student/datatable', 'StudentController@datatable')->name('student.datatable');
    Route::get('study/datatable', 'StudyController@datatable')->name('study.datatable');
    Route::get('teacher/datatable', 'TeacherController@datatable')->name('teacher.datatable');
});