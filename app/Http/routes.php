<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Blade::setContentTags('[[',']]');
Blade::setRawTags('[!!', '!!]');
        
//Route::get('/', function () {
//    return view('welcome');
//});

Route::auth();

//Route::get('/', 'HomeController@index');

//Route::group(['middleware' => ['auth','admin']], function(){
//    Route::get('/admin', function ()    {
//        echo "this is the admin Section";
//    });
//});


//Route::group(['middleware' => ['auth', 'admin']], function(){
//    
//    
//    Route::get('/', 'HomeController@index');
//    
//    Route::get('/admin', function ()    {
//        echo "this is the admin Section";
//    });
//    
//});


Route::group(['middleware' => ['auth']], function(){
    Route::get('/', 'HomeController@index');
});


Route::group(['middleware' => ['auth', 'student']], function() {
    Route::get('/student', 'StudentController@index');
    Route::post('/student/test_instruction', 'StudentController@instruction');
    Route::match(['post', 'get'],'/student/sheet', 'StudentController@answer_sheet');
    Route::post('/student/image_capture', 'StudentController@image_capture');
    Route::post('/student/choice', 'StudentController@save_choice');
    Route::post('/student/save_err', 'StudentController@save_error');
    Route::post('/student/time', 'StudentController@save_time');
    Route::post('/student/endexam', 'StudentController@end_exam');
    Route::post('/student/my_answered', 'StudentController@get_my_answered');
    
});


Route::group(['middleware' => ['auth', 'admin']], function() {

    Route::get('/admin', 'AdminController@index');

    Route::get('/admin/sessions', 'AdminController@sessions');
    Route::post('/admin/sessions/create', 'AdminController@create_session');
    Route::post('/admin/sessions/update', 'AdminController@update_session');
    Route::post('/admin/sessions/delete', 'AdminController@delete_session');

    Route::get('/admin/users', 'AdminController@users');
    Route::post('/admin/users/create', 'AdminController@create_user');
    Route::post('/admin/users/update', 'AdminController@update_user');
    Route::post('/admin/users/delete', 'AdminController@delete_user');
    Route::post('/admin/users/upload', 'AdminController@upload_user');

    Route::get('/admin/test_type', 'AdminController@test_types');
    Route::post('/admin/test_type/create', 'AdminController@create_test_type');
    Route::post('/admin/test_type/update', 'AdminController@update_test_type');
    Route::post('/admin/test_type/delete', 'AdminController@delete_test_type');
    
    
    Route::get('/admin/courses', 'AdminController@courses');
    Route::post('/admin/courses/create', 'AdminController@create_course');
    Route::post('/admin/courses/update', 'AdminController@update_course');
    Route::post('/admin/courses/upload', 'AdminController@upload_course');
    Route::post('/admin/courses/delete', 'AdminController@delete_course');

    Route::get('/admin/assessments', 'AdminController@assessments');
    Route::post('/admin/assessments/create', 'AdminController@create_assessment');
    Route::post('/admin/assessments/update', 'AdminController@update_assessment');
    Route::post('/admin/assessments/upload', 'AdminController@upload_assessment');
    Route::post('/admin/assessments/delete', 'AdminController@delete_assessment');
    Route::get('/admin/assessment/{ass_id}', 'AdminController@assessment');
    
    Route::get('/admin/centers', 'AdminController@exam_centers');
    Route::post('/admin/center/create', 'AdminController@create_center');
    Route::post('/admin/assessments/update', 'AdminController@update_assessment');
    Route::post('/admin/assessments/upload', 'AdminController@upload_assessment');
    Route::post('/admin/assessments/delete', 'AdminController@delete_assessment');
    Route::get('/admin/assessment/{ass_id}', 'AdminController@assessment');
    Route::get('/admin/assessment/{ass_id}/report', 'AdminController@assesment_report');


    Route::post('/admin/tests/create', 'AdminController@create_test');
    Route::post('/admin/tests/update', 'AdminController@update_test');
    Route::post('/admin/tests/delete', 'AdminController@delete_test');

    Route::get('/admin/test/manage/{testid}', 'AdminController@manage_test');
    Route::post('/admin/test/load_users', 'AdminController@load_test_users');
    Route::post('/admin/test/change_batch_status', 'AdminController@attendee_batch_status');
    Route::get('/admin/test/questions/{testid}', 'AdminController@set_question');
    Route::post('/admin/test/question', 'AdminController@save_question');
    Route::get('/admin/test/history/{id}', 'AdminController@test_history');
    
    
    
});
