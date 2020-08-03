<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index');

Route::get('/login','MainController@login');
Route::post('/login','MainController@validateLogin');
Route::get('logout',function(){
    \Illuminate\Support\Facades\Session::flush();
    return redirect('/login');
});
//Manage Charts and Calendar
Route::get('/home/chart','HomeController@lineChart');

//HOMIS Reports
Route::get('/patient/logs','HomisController@patientLog');
Route::post('/patient/logs','HomisController@filterErLog');

//Events and my calendar
Route::get('/user/calendar','CalendarController@index');
Route::post('/user/calendar/save','CalendarController@save');
Route::get('/user/calendar/edit/{id}','CalendarController@edit');
Route::post('/user/calendar/update/{id}','CalendarController@update');
Route::get('/user/calendar/delete/{id}','CalendarController@delete');

Route::get('/user/events','CalendarController@events');
Route::get('/user/events/personal','CalendarController@myCalendar');

Route::get('/modules',function (){
    return view('page.modules',[
        'title' => 'Modules',
        'menu' => 'modules'
    ]);
});

//Dietary Section
Route::get('/dietary','DietaryController@index');
Route::get('/dietary/patients','DietaryController@patientList');
Route::post('/dietary/patients','DietaryController@searchList');
Route::get('/dietary/diet/{code}','DietaryController@loadDiet');

Route::post('/dietary/save','DietaryController@saveDiet');

Route::get('/dietary/discharged','DietaryController@discharged');

Route::get('/dietary/report/chart','DietaryController@reportChart');
Route::get('/dietary/report/room','DietaryController@reportRoom');
Route::get('/dietary/report/patient','DietaryController@reportPatient');
//End Dietary

Route::get('/loading',function (){
    return view('page.loading');
});

//PRINT SECTION
Route::get('/dietary/print/chart','PrintController@printDietaryReportChart');
Route::get('/dietary/print/room','PrintController@printDietaryReportRoom');
//END PRINT SECTION


//HOMIS SAMPLE
Route::get('homis',function (){
    $data = \App\Homis\Admlog::orderBy('disdate','desc')->paginate(10);
    //$data = \App\Homis\Disposition::paginate(20);
    return $data;
});
//END SAMPLE