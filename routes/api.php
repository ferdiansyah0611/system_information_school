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
    Route::apiResource('assessment-task', 'AssessmentTaskController');
    Route::apiResource('homeroom-teacher', 'HomeRoomTeacherController');
    Route::apiResource('report-card', 'ReportCardController');

});
Route::group(['namespace' => 'Admin\Request'], function(){
    Route::get('dashboard', 'AdminController@dashboard');
    /*export*/
    Route::get('class/excel/export/{user}', 'ClassController@export')->name('class.export');
    Route::get('school/excel/export/{user}', 'SchoolController@export')->name('school.export');
    Route::get('student/excel/export/{user}', 'StudentController@export')->name('student.export');
    Route::get('study/excel/export/{user}', 'StudyController@export')->name('study.export');
    Route::get('teacher/excel/export/{user}', 'TeacherController@export')->name('teacher.export');
    Route::get('assessment-task/excel/export/{user}', 'AssessmentTaskController@export')->name('assessment-task.export');
    Route::get('homeroom-teacher/excel/export/{user}', 'HomeRoomTeacherController@export')->name('homeroom-teacher.export');
    Route::get('report-card/excel/export/{user}', 'ReportCardController@export')->name('report-card.export');
});