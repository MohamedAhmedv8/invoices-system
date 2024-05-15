<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


// Auth::routes(['register' => false]);
Auth::routes([
    'register' => false,
    // 'reset' => false,
    // 'verify' => false,
]);
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('invoices', InvoicesController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('products', ProductController::class);
    Route::resource('/archive', InvoiceArchiveController::class);
    Route::post('/addAttachments', [InvoiceAttachmentsController::class, 'store']);
    Route::post('/delet_attachment', [InvoiceAttachmentsController::class, 'destroy']);
    Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);
    Route::get('/details/{id}', [InvoiceDetailsController::class, 'edit']);
    Route::get('/edit_invoice/{id}', [InvoicesController::class, 'edit']);
    Route::get('/show_status/{id}', [InvoicesController::class, 'show']);
    Route::patch('/update_invoice/{id}', [InvoicesController::class, 'update']);
    Route::patch('/update_status/{id}', [InvoicesController::class, 'updateStatus']);
    Route::get('/invoices_paid', [InvoicesController::class, 'invoices_paid']);
    Route::get('/invoices_unpaid', [InvoicesController::class, 'invoices_unpaid']);
    Route::get('/invoices_partial', [InvoicesController::class, 'invoices_partial']);
    Route::get('/print_invoice/{id}', [InvoicesController::class, 'print_invoice']);
    // Route::get('view_file/{id}', [InvoiceAttachmentsController::class, 'openFile']);
    // Route::get('download/{id}', [InvoiceAttachmentsController::class, 'downloadFile']);
    Route::group(['middleware' => ['auth']], function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
    Route::get('invoices_reports', [InvoiceReportController::class, 'index']);
    Route::post('search_invoice', [InvoiceReportController::class, 'search_invoice']);
    Route::get('customers_reports', [CustomerReportController::class, 'index']);
    Route::post('search_customers', [CustomerReportController::class, 'search_customers']);
    Route::get('read_all', [NotificationController::class, 'MarkAsReadAll']);
    Route::get('all_notification', [NotificationController::class, 'index']);
    Route::get('/{page}', [AdminController::class, 'index']);
});
