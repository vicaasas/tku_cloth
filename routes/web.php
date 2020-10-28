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

        Route::get('exportCsv', 'PdfController@exportCsv')
        ->name('exportCsv');

        Route::get('class_order/{class_name}', 'ReportController@class_order')
        ->name('class_order');

        Route::get('all_student_order', 'ReportController@all_student_order')
        ->name('all_student_order');

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
    Route::group(['prefix' => 'return', 'middleware' => ['can:admin'], 'as' => 'return.'], function () {

        Route::get('/', 'ReturnClothController@index')
            ->name('cloths.page');
    
        Route::get('get_student_order', 'ReturnClothController@get_student_order')
            ->name('cloths.get_student_order');
            
        Route::post('return_order_self', 'ReturnClothController@self_cloth')
            ->name('self_cloth');

        Route::post('return_cloth', 'ReturnClothController@return_cloth')
            ->name('return_cloth');

        Route::post('delete_order', 'ReturnClothController@delete_order')
            ->name('delete_order');

        Route::post('edit_order', 'ReturnClothController@edit_order')
            ->name('edit_order');

    });

    Route::group(['prefix' => 'print', 'middleware' => ['can:admin'], 'as' => 'print.'], function () {
        Route::get('bill','BillController@bill')
        ->name('bill');

        Route::get('student_bill','BillController@student_bill')
        ->name('student_bill');

        Route::post('get_receipt','BillController@get_receipt')
        ->name('get_receipt');

        Route::get('student_bill_pdf/{student_id}/{order_id}','PdfController@student_bill_pdf')
        ->name('student_bill_pdf');
    });

    Route::post('order_return','OrderController@order_return')
        ->name('order.order_return')
        ->middleware('can:admin');
    
    Route::get('/get_cloths_view',function () {
            return view('admin.report.get_cloths');
        })->name('get_cloths_view')
        ->middleware('can:admin');

    Route::get('/get_cloths','OrderController@get_cloths')
        ->name('get_cloths')
        ->middleware('can:admin');

    Route::post('/is_get_cloths','OrderController@is_get_cloths')
        ->name('is_get_cloths')
        ->middleware('can:admin');


    Route::resource('time', 'TimeController', ['except' => ['create', 'edit', 'show']]);

    Route::resource('cloth', 'ClothController', ['except' => ['create', 'edit', 'show']]);

});

// Route::get('asd',function(){
//     return view('hello', [
//         'users' => DB::table('student_order')->select(DB::raw('*'))->get(),
//     ]);
// });
Route::group(['prefix' => 'student','middleware' => ['auth:student']], function () {
    //學生
    Route::get('/','StudentController@index')
        ->name('student.page');

    Route::post('order','OrderController@save')
        ->name('order.save')
        ->middleware('checkorder');

    Route::post('add_order','OrderController@add_order')
        ->name('order.add_order')
        ->middleware('check_single_order');

    Route::post('order_update','OrderController@order_update')
        ->name('order.order_update');

    Route::post('order_delete','OrderController@order_delete')
        ->name('order.order_delete');

    Route::post('student_all_order_delete','OrderController@student_all_order_delete')
        ->name('order.student_all_order_delete');

    Route::get('receipt_bail', 'PdfController@receipt_bail')
        ->name('receipt_bail');

    Route::get('bill_proof','PdfController@bill_proof')
        ->name('bill_proof');

    Route::get('student_bill_pdf/{student_id?}/{order_id?}','PdfController@student_bill_pdf')
        ->name('student_bill_pdf');
    
    Route::post('recover_order', 'OrderController@recover_order')
        ->name('recover_order');

    Route::post('password', 'Auth\PasswordChangeController@change')
        ->name('profile.change.password');
});


Auth::routes([
    'confirm' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
]);