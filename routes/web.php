<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CrudGeneratorController;
use App\Http\Controllers\GoogleTranslateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'view'])->name('home');
Route::get('/image', [HomeController::class, 'image'])->name('image.upload');
Route::get('/mode/{mode}', [HomeController::class, 'mode'])->name('mode');
Route::get('logout', [LoginController::class, 'logout']);
Auth::routes(['register' => false, 'verify' => true]);

Route::middleware([
    'auth:web',
])
    ->group(function () {

        Route::get('/crud_generator', [CrudGeneratorController::class, 'index'])->name('crud-generator');
        Route::get('/crud_generator/show_fields', [CrudGeneratorController::class, 'show_fields'])->name('crud-generator.show_fields');
        Route::post('/crud_generator/generate', [CrudGeneratorController::class, 'generate'])->name('crud-generator.generate');

        // route for city Controller
        Route::get('/city/status_change/{city}', [CityController::class, 'status_change'])->name('city.status_change');
        Route::get('/city/data', [CityController::class, 'data'])->name('city.data');
        Route::resource('city', CityController::class);

        Route::get('/lang/{locale}', [HomeController::class, 'lang'])->name('lang');

        // route for user managment Controller
        Route::get('/admin/status_change/{admin}', [AdminController::class, 'status_change'])->name('admin.status_change');
        Route::get('/admin/data', [AdminController::class, 'data'])->name('admin.data');
        Route::resource('admin', AdminController::class);

        // route for role Controller
        Route::get('/role/status_change/{role}', [RolesController::class, 'status_change'])->name('role.status_change');
        Route::get('/role/data', [RolesController::class, 'data'])->name('role.data');
        Route::resource('role', RolesController::class);

        Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
        Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
        Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
        Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
        Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');

        // uploaded files
        Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
        Route::get('/uploaded-files/data', [AizUploadController::class, 'data'])->name('uploaded-files.data');
        Route::resource('/uploaded-files', AizUploadController::class);
        //        Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class,'destroy'])->name('uploaded-files.destroy');

        //form google translating
        Route::get('/translate', [GoogleTranslateController::class, 'translate'])->name('translate.all');

        //Contact us route
        Route::get('/contact_us/data', [ContactUsController::class, 'data'])->name('contact_us.data');
        Route::get('/contact_us/sent', [ContactUsController::class, 'sent_mails'])->name('contact_us.sent');
        Route::get('/contact_us/trash', [ContactUsController::class, 'trashed_mails'])->name('contact_us.trash');
        Route::get('/contact_us/data_trashed', [ContactUsController::class, 'data_trashed'])->name('contact_us.data_trashed');
        Route::get('/contact_us/starred', [ContactUsController::class, 'starred_mails'])->name('contact_us.starred_mails');
        Route::get('/contact_us/data_starred', [ContactUsController::class, 'data_starred'])->name('contact_us.data_starred');
        Route::get('/contact_us/data_sent', [ContactUsController::class, 'data_sent'])->name('contact_us.data_sent');
        Route::post('/contact_us/send_mail', [ContactUsController::class, 'send_mail'])->name('contact_us.send_mail');
        Route::get('/contact_us/starred/{contact}', [ContactUsController::class, 'starred'])->name('contact_us.starred');
        Route::get('/contact_us/read/{contact}', [ContactUsController::class, 'read'])->name('contact_us.read')->withTrashed();
        Route::get('/contact_us/read_history/{contact}', [ContactUsController::class, 'read_history'])->name('contact_us.read_history');
        Route::get('/contact_us/{contact}/reply', [ContactUsController::class, 'reply'])->name('contact_us.reply');
        Route::resource('contact_us', ContactUsController::class);

        // route for Users Setting
        Route::get('/account/setting', [AdminController::class, 'change_password'])->name('users.setting');
        Route::post('/account/change_password', [AdminController::class, 'new_password'])->name('users.change_password');

        // route for generate
    });
