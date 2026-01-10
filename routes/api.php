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

Route::post('login', 'APIController@login')->name('api.login');
Route::get('programs/list', 'APIController@getPrograms')->name('api.list.programs');
Route::post('programs/store', 'APIController@storeProgram')->name('api.store.program');
Route::post('programs/update/{id}', 'APIController@updateProgram')->name('api.update.program');
Route::delete('programs/delete/{id}', 'APIController@deleteProgram')->name('api.delete.program');

Route::get('notices/list', 'APIController@getNotices')->name('api.list.notices');
Route::post('notices/store', 'APIController@storeNotice')->name('api.store.notice');
Route::post('notices/update/{id}', 'APIController@updateNotice')->name('api.update.notice');
Route::delete('notices/delete/{id}', 'APIController@deleteNotice')->name('api.delete.notice');

Route::get('units', 'APIController@getUnits')->name('api.get.units');
Route::get('leaders/list', 'APIController@getLeaders')->name('api.list.notices');
Route::post('leaders/store', 'APIController@storeLeader')->name('api.store.neader');
Route::post('leaders/update/{id}', 'APIController@updateLeader')->name('api.update.neader');
Route::delete('leaders/delete/{id}', 'APIController@deleteLeader')->name('api.delete.neader');

Route::get('/sliders/list', 'APIController@getSliders')->name('api.list.sliders');
Route::post('/sliders/store', 'APIController@storeSlider')->name('api.store.slider');
Route::delete('/sliders/delete/{id}', 'APIController@deleteSlider')->name('api.delete.slider');

Route::get('/sliders/list', 'APIController@getSliders')->name('api.list.sliders');
Route::post('/sliders/store', 'APIController@storeSlider')->name('api.store.slider');
Route::delete('/sliders/delete/{id}', 'APIController@deleteSlider')->name('api.delete.slider');

Route::get('admin/stats', 'APIController@getAdminStats')->name('api.admin.stats');










Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/testapi', 'APIController@test')->name('api.test');

Route::post('/generateotp', 'APIController@generateOTP')->name('api.generateotp');
Route::post('/loginorcreate', 'APIController@loginOrCreate')->name('api.loginorcreate');

Route::get('/checkuid/{softtoken}/{phonenumber}', 'APIController@checkUid')->name('api.checkuid');
Route::get('/checkpackagevalidity/{softtoken}/{phonenumber}', 'APIController@checkPackageValidity')->name('api.checkpackagevalidity');
Route::post('/adduser', 'APIController@addUser')->name('api.adduser');
Route::post('/addonesignaldata', 'APIController@addOneSignalData')->name('api.addonesignaldata');
Route::post('/updateuser', 'APIController@updateUser')->name('api.updateuser');
Route::post('/notification/single', 'APIController@sendSingleNotification')->name('api.sendsinglenotification');
Route::get('/notification/test', 'APIController@testNotification')->name('api.testnotification');

//
Route::prefix('/location')->group(function () {
    Route::get('districts/{divisionId}', 'APIController@getDistricts');
    Route::get('upazilas/{districtId}', 'APIController@getUpazilas');
    Route::get('unions/{upazilaId}', 'APIController@getUnions');
});

// Route::get('/testcache', 'APIController@testCache')->name('api.testcache');
// Route::get('/getcourses/{softtoken}/{coursetype}', 'APIController@getCourses')->name('api.getcourses');
// Route::get('/getcourses/exams/{softtoken}/{id}', 'APIController@getCourseExams')->name('api.getcourses.exams');
// Route::get('/getothercourses/exams/{softtoken}/{coursetype}', 'APIController@getOtherCourseExams')->name('api.getothercourses.exams');
// Route::get('/getcourses/exam/{softtoken}/{id}/questions', 'APIController@getCourseExamQuestions')->name('api.getcourses.exam.questions');
// Route::get('/gettopicwise/exam/{softtoken}/{id}/questions', 'APIController@getTopicExamQuestions')->name('api.gettopicwise.exam.questions');
// Route::get('/gettopics/{softtoken}', 'APIController@getTopics')->name('api.gettopics');
Route::get('/getpackages/{softtoken}', 'APIController@getPackages')->name('api.getpackages');
Route::post('/payment/proceed', 'APIController@paymentProceed')->name('api.paymentproceed');

Route::post('/message/store', 'APIController@storeMessage')->name('api.storemessage');

Route::get('/getpaymenthistory/{softtoken}/{phonenumber}', 'APIController@getPaymentHistory')->name('api.getpaymenthistory');

// Route::get('/getmaterials/{softtoken}', 'APIController@getMaterials')->name('api.getmaterials');
// Route::get('/getmaterials/single/{softtoken}/{id}', 'APIController@getSingleMaterial')->name('api.getsinglematerial');

// Route::post('/addexamresult', 'APIController@addExamResult')->name('api.addexamresult');
// Route::get('/meritlist/{softtoken}/{course_id}/{exam_id}', 'APIController@getMeritList')->name('api.getmeritlist');
// Route::post('/reportquestion', 'APIController@reportQuestion')->name('api.reportquestion');
// Route::get('/getexamcategories/{softtoken}', 'APIController@getExamCategories')->name('api.getexamcategories');
// Route::get('/getquestionbank/exams/{softtoken}/{getexamcategory}', 'APIController@getQBCatWise')->name('api.getquestionbank.exams');