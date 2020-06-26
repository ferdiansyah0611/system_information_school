<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::apiResource('study', 'StudyController');
    Route::apiResource('teacher', 'TeacherController');
    Route::apiResource('assessment-task', 'ScAssessmentTaskController');
});