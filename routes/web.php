<?php

use App\Cloth;
use App\Config;
use App\Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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
// 個人設定
Route::prefix('profile')->group(function () {
    Route::get('/', function () {
        return view('auth.profile');
    })->name('profile');

    Route::post('password', 'Auth\PasswordChangeController@change')
        ->name('profile.change.password');

    Route::post('image', 'Auth\ImageChangeController@change')
        ->name('profile.change.image')
        ->middleware('can:admin');
});
Route::group(['middleware' => ['auth']], function () {
    // 主頁面
    Route::get('/', function () {
        return Redirect::route('home');
    });
    Route::get('/index', 'IndexController@index')
        ->name('home');



    // 報表產生
    Route::group(['prefix' => 'report', 'middleware' => ['can:admin'], 'as' => 'report.'], function () {
        Route::get('total', 'ReportController@total')
        ->name('total');

        Route::post('degree_total', 'ReportController@degree_total')
        ->name('degree_total');

        Route::get('not_return', 'PdfController@not_return')
        ->name('not_return');

        Route::get('is_return', 'PdfController@is_return')
        ->name('is_return');

        Route::get('class_order/{class_name}', 'ReportController@class_order')
        ->name('class_order');

        Route::get('all_student_order', 'ReportController@all_student_order')
        ->name('all_student_order');

        Route::post('return_cloth', 'ReturnClothController@return_cloth')
        ->name('return_cloth');

        Route::post('delete_order', 'ReturnClothController@delete_order')
        ->name('delete_order');

        Route::post('edit_order', 'ReturnClothController@edit_order')
        ->name('edit_order');
    });
 
    // 系統設定
    Route::group(['prefix' => 'system', 'middleware' => ['can:admin'], 'as' => 'system.'], function () {
        Route::get('/', 'SystemController@index')
            ->name('index');
        Route::post('new_user', 'SystemController@new_user')
            ->name('new_user');
        Route::post('drop_students', 'SystemController@dropStudents')
            ->name('drop_students');
        Route::post('import_students', 'SystemController@importstudent')
            ->name('import_students');
    });

    // 更新歸還地點
    Route::post('return_location/update', 'ConfigController@update_location')
        ->name('update.location')
        ->middleware('can:admin');

    // 物品歸還頁面
    Route::get('return', 'ReturnClothController@index')
        ->name('return.cloths.page')
        ->middleware('can:admin');
    Route::post('return', 'ReturnClothController@post')
        ->name('return.cloths.post')
        ->middleware('can:admin');



    Route::group(['prefix' => 'print', 'middleware' => ['can:admin'], 'as' => 'print.'], function () {
        Route::get('bill','BillController@bill')
        ->name('bill');

        Route::get('class_bill/{class_name}','BillController@class_bill')
        ->name('class_bill');

        Route::get('class_bill_pdf/{class_name}','PdfController@class_bill_pdf')
        ->name('class_bill_pdf');
    });
    Route::resource('time', 'TimeController', ['except' => ['create', 'edit', 'show']]);

    Route::resource('cloth', 'ClothController', ['except' => ['create', 'edit', 'show']]);

});
Route::group(['middleware' => ['auth:represent']], function () {
    //助教
    Route::get('represent','RepresentController@index')
    ->name('represent.page');
});
Route::get('asd',function(){
    return view('hello', [
        'users' => DB::table('student_order')->select(DB::raw('*'))->get(),
    ]);
});
Route::group(['middleware' => ['auth:student']], function () {
    //助教
    Route::get('student','StudentController@index')
    ->name('student.page');

});

Route::group(['middleware' => ['auth:department']], function () {
    //助教
    Route::get('department/{class_name?}','DepartmentController@index')
    ->name('department.page');
    Route::post('department_get_class','DepartmentController@return_class')
    ->name('department.return_class');
});
Route::post('order/{degree?}','OrderController@save')
    ->name('order.save');

Auth::routes([
    'confirm' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
]);