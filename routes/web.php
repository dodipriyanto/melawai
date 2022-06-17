<?php
use App\Http\Controllers\Generator\MonitoringCovidController;
use App\Http\Controllers\Generator\VaccineController;
use App\Http\Controllers\Generator\EmployeeVaccineController;
use App\Http\Controllers\Generator\EmployeeFamilyController;
use App\Http\Controllers\Generator\EmployeeController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupConttroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

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
Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['prefix'=>'administrator','middleware'=>['auth','roles']], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/delete_file', [DashboardController::class, 'deleteFileContent'])->name('file_delete');


    Route::group(['prefix'=>'monitoringcovids'], function () {
        Route::get('/', [MonitoringCovidController::class, 'index'])->name('dashboard_monitoringcovids');
        Route::get('/get', [MonitoringCovidController::class, 'get'])->name('dashboard_monitoringcovids_detail');
        Route::get('/delete', [MonitoringCovidController::class, 'destroy'])->name('dashboard_monitoringcovids_delete');
        Route::post('/', [MonitoringCovidController::class, 'store'])->name('dashboard_monitoringcovids_post');
        Route::get('/datatable.json', [MonitoringCovidController::class ,'__datatable'])->name('dashboard_monitoringcovids_table');
    });

    Route::group(['prefix'=>'vaccines'], function () {
        Route::get('/', [VaccineController::class, 'index'])->name('dashboard_vaccines');
        Route::get('/get', [VaccineController::class, 'get'])->name('dashboard_vaccines_detail');
        Route::get('/delete', [VaccineController::class, 'destroy'])->name('dashboard_vaccines_delete');
        Route::post('/', [VaccineController::class, 'store'])->name('dashboard_vaccines_post');
        Route::get('/datatable.json', [VaccineController::class ,'__datatable'])->name('dashboard_vaccines_table');
    });

    Route::group(['prefix'=>'employeevaccines'], function () {
        Route::get('/', [EmployeeVaccineController::class, 'index'])->name('dashboard_employeevaccines');
        Route::get('/get', [EmployeeVaccineController::class, 'get'])->name('dashboard_employeevaccines_detail');
        Route::get('/delete', [EmployeeVaccineController::class, 'destroy'])->name('dashboard_employeevaccines_delete');
        Route::post('/', [EmployeeVaccineController::class, 'store'])->name('dashboard_employeevaccines_post');
        Route::get('/datatable.json', [EmployeeVaccineController::class ,'__datatable'])->name('dashboard_employeevaccines_table');
    });

    Route::group(['prefix'=>'employeefamilies'], function () {
        Route::get('/', [EmployeeFamilyController::class, 'index'])->name('dashboard_employeefamilies');
        Route::get('/get', [EmployeeFamilyController::class, 'get'])->name('dashboard_employeefamilies_detail');
        Route::get('/delete', [EmployeeFamilyController::class, 'destroy'])->name('dashboard_employeefamilies_delete');
        Route::post('/', [EmployeeFamilyController::class, 'store'])->name('dashboard_employeefamilies_post');
        Route::get('/datatable.json', [EmployeeFamilyController::class ,'__datatable'])->name('dashboard_employeefamilies_table');
    });

    Route::group(['prefix'=>'employees'], function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('dashboard_employees');
        Route::get('/get', [EmployeeController::class, 'get'])->name('dashboard_employees_detail');
        Route::get('/delete', [EmployeeController::class, 'destroy'])->name('dashboard_employees_delete');
        Route::post('/', [EmployeeController::class, 'store'])->name('dashboard_employees_post');
        Route::get('/datatable.json', [EmployeeController::class ,'__datatable'])->name('dashboard_employees_table');
    });

    Route::group(['prefix'=>'todos'], function () {
        Route::get('/', [TodoController::class, 'index'])->name('dashboard_todos');
        Route::get('/get', [TodoController::class, 'get'])->name('dashboard_todos_detail');
        Route::get('/delete', [TodoController::class, 'destroy'])->name('dashboard_todos_delete');
        Route::post('/', [TodoController::class, 'store'])->name('dashboard_todos_post');
        Route::get('/datatable.json', [TodoController::class ,'__datatable'])->name('dashboard_todos_table');
    });
    Route::group(['prefix'=>'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('dashboard_profile');
        Route::post('/', [ProfileController::class, 'store'])->name('dashboard_profile_post');
    });

    Route::group(['prefix'=>'menu'], function () {
        Route::get('/', [MenuController::class, 'index'])->name('dashboard_menu');
        Route::get('/get', [MenuController::class, 'get'])->name('dashboard_menu_detail');
        Route::get('/delete', [MenuController::class, 'destroy'])->name('dashboard_menu_delete');
        Route::post('/', [MenuController::class, 'store'])->name('dashboard_menu_post');
        Route::get('/datatable.json', [MenuController::class ,'__datatable'])->name('dashboard_menu_table');
    });

    Route::group(['prefix'=>'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('dashboard_user');
        Route::get('/get', [UserController::class, 'get'])->name('dashboard_user_detail');
        Route::get('/delete', [UserController::class, 'destroy'])->name('dashboard_user_delete');
        Route::post('/', [UserController::class, 'store'])->name('dashboard_user_post');
        Route::get('/datatable.json', [UserController::class ,'__datatable'])->name('dashboard_user_table');

    });

    Route::group(['prefix'=>'group'], function () {
        Route::get('/', [GroupConttroller::class, 'index'])->name('dashboard_group');
        Route::get('/get', [GroupConttroller::class, 'get'])->name('dashboard_group_detail');
        Route::get('/delete', [GroupConttroller::class, 'destroy'])->name('dashboard_group_delete');
        Route::post('/', [GroupConttroller::class, 'store'])->name('dashboard_group_post');
        Route::get('/changeAccess', [GroupConttroller::class, 'changeAccess'])->name('dashboard_group_change_access');
        Route::get('/datatable.json', [GroupConttroller::class ,'__datatable'])->name('dashboard_group_table');
        Route::get('/menuAccess.json', [GroupConttroller::class ,'__menuAccess'])->name('dashboard_group_menu_access');

    });

    Route::group(['prefix'=>'setting'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('dashboard_setting');
        Route::get('/get', [SettingController::class, 'get'])->name('dashboard_setting_detail');
        Route::get('/delete', [SettingController::class, 'destroy'])->name('dashboard_setting_delete');
        Route::post('/', [SettingController::class, 'store'])->name('dashboard_setting_post');
        Route::get('/datatable.json', [SettingController::class ,'__datatable'])->name('dashboard_setting_table');
    });

    Route::group(['prefix'=>'permission'], function () {
        Route::get('/administrator/permission', [MenuController::class, 'index'])->name('dashboard_permission');
    });

});
//
//Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/administrator', [DashboardController::class, 'index'])->name('dashboard');
//Route::get('/administrator/menu', [MenuController::class, 'index'])->name('dashboard_menu');
//Route::get('/administrator/user', [UserController::class, 'index'])->name('dashboard_user');
//Route::post('/administrator/user', [UserController::class, 'store'])->name('dashboard_user_post');
//Route::get('/administrator/user/datatable.json', [UserController::class ,'datatable'])->name('user_table');
//
//Route::get('/administrator/group', [GroupConttroller::class, 'index'])->name('dashboard_group');
//Route::get('/administrator/setting', [MenuController::class, 'index'])->name('dashboard_setting');
//Route::get('/administrator/permission', [MenuController::class, 'index'])->name('dashboard_permission');


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
