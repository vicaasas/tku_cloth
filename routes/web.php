<?php

use App\Cloth;
use App\Config;
use App\Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:admin,student']], function () {
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

        Route::post('change_degree', 'ReportController@change_degree')
        ->name('change_degree');

        Route::get('class_order/{class_name}', 'ReportController@class_order')
        ->name('class_order');

        Route::get('all_student_order', 'ReportController@all_student_order')
        ->name('all_student_order');

    });
    //pdf csv 匯出 or 顯示
    Route::group(['prefix' => 'pdf', 'middleware' => ['can:admin'], 'as' => 'pdf.'], function () {

        Route::get('not_return/{degree}', 'PdfController@not_return')
        ->name('not_return');

        Route::get('is_return/{degree}', 'PdfController@is_return')
        ->name('is_return');

        Route::get('exportCsv', 'PdfController@exportCsv')
        ->name('exportCsv');

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

        Route::post('recover_password', 'SystemController@recover_password')
            ->name('recover_password');

        Route::post('give_admin_authority', 'SystemController@give_admin_authority')
            ->name('give_admin_authority');

        Route::get('history',function(){
            
            $history_database=request()->record_year."_rent_cloth";
            $path = base_path('.env');
            if (file_exists($path)) {
                file_put_contents($path, str_replace('DB_DATABASE_SECOND='.env('DB_DATABASE_SECOND'), 'DB_DATABASE_SECOND='.$history_database, file_get_contents($path)));
            }
            return redirect()->route('sub_system.home');
        })->name('history_rent_cloth');
        
        Route::group(['middleware' => ['web']], function () {
            Route::post('next_year_TKU-graduate-gown',function(){ //next_year_TKU-graduate-gown

                $newDatabase = (date('Y')-1911)."_rent_cloth";
                DB::statement("CREATE DATABASE $newDatabase");
        
                config(['database.connections.mysql.database' => $newDatabase]);
                DB::purge('mysql');
                
                Artisan::call('migrate');
                Artisan::call('db:seed');
                DB::statement("CREATE OR REPLACE VIEW student_order AS 
                SELECT students.student_id, students.class_id, students.class_name, students.student_name,orders.id,orders.order_id, c1.type AS type, c1.name AS cloth, c1.property AS size, c2.name AS accessory, c2.property AS color,orders.return,student_have_orders.has_paid,student_have_orders.has_get_cloths,orders.has_cancel,student_have_orders.stu_id as responsible_person,receipts.receipt_no,receipts.payer,receipts.receipt_date FROM student_have_orders 
                LEFT JOIN receipts ON student_have_orders.order_id=receipts.order_id
                INNER JOIN orders ON student_have_orders.order_id=orders.order_id
                INNER JOIN students ON students.student_id=orders.stu_id 
                INNER JOIN cloths c1 ON orders.cloth=c1.id
                INNER JOIN cloths c2 ON orders.accessory=c2.id");
                $path = base_path('.env');
                if (file_exists($path)) {
                    $add_history_database = env('DB_DATABASE').','.env('HISTORY_DATABASE',null);
                    file_put_contents($path, str_replace('DB_DATABASE='.env('DB_DATABASE'), 'DB_DATABASE='.$newDatabase, file_get_contents($path)));
                    file_put_contents($path, str_replace('HISTORY_DATABASE='.env('HISTORY_DATABASE',null), 'HISTORY_DATABASE='.$add_history_database, file_get_contents($path)));
                }
                
                Auth::guard('admin')->logout();
                request()->session()->invalidate();
    
                request()->session()->regenerateToken();
                return redirect()->route('login');
            })->name('create_next_year_TKU-graduate-gown');
        });
    });

    // 更新歸還地點
    Route::post('return_location/update', 'ConfigController@update_location')
        ->name('update.location')
        ->middleware('can:admin');

    // 物品歸還跟退款功能
    Route::group(['prefix' => 'return', 'middleware' => ['can:admin'], 'as' => 'return.'], function () {

        Route::get('/', 'ReturnClothController@index')
            ->name('page');
    
        Route::get('get_student_order', 'ReturnClothController@get_student_order')
            ->name('get_student_order');
            
        Route::post('return_order_self', 'ReturnClothController@self_cloth')
            ->name('self_cloth');

        Route::get('refund_view',function () {
            return view('admin.function_page.refund_view');
        })->name('refund_view');

        Route::get('get_refund_order', 'ReturnClothController@get_refund_order')
            ->name('get_refund_order');

        Route::post('determine_refund','ReturnClothController@determine_refund')
            ->name('determine_refund');

    });
    //訂單操作
    Route::group(['prefix' => 'operate', 'middleware' => ['can:admin'], 'as' => 'order.'], function () {

        Route::post('order_cancel', 'OrderController@order_cancel')
        ->name('cancel');
        
        Route::post('order_edit', 'OrderController@order_edit')
        ->name('edit');

        Route::get('/get_cloths_order','OrderController@get_cloths_order')
            ->name('get_cloths_order');

        Route::post('/determine_get_cloths','OrderController@determine_get_cloths')
            ->name('determine_get_cloths');

    });

    //繳費收據登記
    Route::group(['prefix' => 'print', 'middleware' => ['can:admin'], 'as' => 'print.'], function () {
        Route::get('bill','BillController@bill')
        ->name('bill')->middleware('preventBackHistory');

        Route::get('student_bill','BillController@student_bill')
        ->name('student_bill');

        Route::post('get_receipt','BillController@get_receipt')
        ->name('get_receipt');

        Route::get('student_bill_pdf/{student_id}/{order_id}','PdfController@student_bill_pdf')
        ->name('student_bill_pdf');
    });

    Route::get('/get_cloths_view',function () {
        return view('admin.function_page.get_cloths');
    })->name('get_cloths_view')->middleware('can:admin');

    Route::resource('time', 'TimeController', ['except' => ['create', 'edit', 'show']]);

    Route::resource('cloth', 'ClothController', ['except' => ['create', 'edit', 'show']]);

});





Route::group(['prefix' => 'SubSystem','middleware' => ['auth'],'as' => 'sub_system.'], function () {
    // 主頁面
    Route::get('/', function () {
        return Redirect::route('home');
    });
    Route::get('/index', 'SubSystem\IndexController@index')
        ->name('home');

    // 報表產生
    Route::group(['prefix' => 'report', 'middleware' => ['can:admin'], 'as' => 'report.'], function () {
        Route::get('total', 'SubSystem\ReportController@total')
        ->name('total');

        Route::post('change_degree', 'SubSystem\ReportController@change_degree')
        ->name('change_degree');

        Route::get('class_order/{class_name}', 'SubSystem\ReportController@class_order')
        ->name('class_order');

        Route::get('all_student_order', 'SubSystem\ReportController@all_student_order')
        ->name('all_student_order');

    });
    //pdf csv 匯出 or 顯示
    Route::group(['prefix' => 'pdf', 'middleware' => ['can:admin'], 'as' => 'pdf.'], function () {

        Route::get('not_return/{degree}', 'SubSystem\PdfController@not_return')
        ->name('not_return');

        Route::get('is_return/{degree}', 'SubSystem\PdfController@is_return')
        ->name('is_return');

        Route::get('exportCsv', 'SubSystem\PdfController@exportCsv')
        ->name('exportCsv');

    });

});



Route::group(['prefix' => 'student','middleware' => ['auth:student']], function () {
    //學生
    Route::get('/','StudentController@index')
    ->name('student.page');

    Route::get('receipt_bail', 'PdfController@receipt_bail')
        ->name('receipt_bail');

    Route::get('bill_proof','PdfController@bill_proof')
        ->name('bill_proof');

    Route::get('student_bill_pdf/{student_id}/{order_id}','PdfController@student_bill_pdf')
        ->name('student_bill_pdf');

    Route::post('password', 'Auth\PasswordChangeController@change')
        ->name('profile.change.password');
    //訂單操作
    Route::group(['prefix' => 'operate', 'as' => 'order.'], function () {

        Route::post('order','OrderController@save')
            ->name('save')
            ->middleware('checkorder');

        Route::post('add_order','OrderController@add_order')
            ->name('add_order')
            ->middleware('check_single_order');

        Route::post('order_delete','OrderController@order_delete')
            ->name('order_delete');

        Route::post('student_all_order_delete','OrderController@student_all_order_delete')
            ->name('student_all_order_delete');

        Route::post('order_edit', 'OrderController@order_edit')
            ->name('edit');

        Route::post('recover_order', 'OrderController@recover_order')
            ->name('recover_order');

    });

});


Auth::routes([
    'confirm' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

