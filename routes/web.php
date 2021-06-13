<?php

use App\Http\Controllers\BidController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

/* Homepage Route */
Route::get('/', [WelcomeController::class, 'index'])->name('homepage');

/* 404 */
Route::get('/404', function() {
    return view('404');
})->name('error-404');

/* 404 */
Route::get('/contact-us', function() {
    return view('contact');
})->name('contact');

/* Auth routes */
Auth::routes();

/* Blog Routes */
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/article/{id}', [BlogController::class, 'show'])->where('id', '[0-9]+')->name('blog.show');

/* Company Routes */
Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');
Route::get('/company/{id}', [CompanyController::class, 'show'])->where('id', '[0-9]+')->name('company.show');

/* Freelancer Routes */
Route::get('/freelancers', [FreelancerController::class, 'index'])->name('freelancer.index');
Route::get('/freelancer/{id}', [FreelancerController::class, 'show'])->where('id', '[0-9]+')->name('freelancer.show');

/* Invoice Routes */
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->where('id', '[0-9]+')->name('invoice.show');

/* Job Routes */
Route::get('/jobs', [JobController::class, 'index'])->name('job.index');
Route::get('/job/{id}', [JobController::class, 'show'])->where('id', '[0-9]+')->name('job.show');

/* Bid Routes */
Route::get('/bid/place/{id}', [BidController::class, 'placeBid'])->where('id', '[0-9]+')->name('bid.place');

/* Order Routes */
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/error', [OrderController::class, 'error'])->name('order.error');

/* Checkout pages */
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

/* Premium Routes */
Route::get('/premium-plans', [PremiumController::class, 'index'])->name('premium.index');

/* Task Routes */
Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
Route::get('/task/{id}', [TaskController::class, 'show'])->where('id', '[0-9]+')->name('task.show');

/* Dashboard Routes */
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], static function() {
    /* Dashboard Home page */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    /* Bookmarks */
    Route::get('/bookmarks', [DashboardController::class, 'bookmarks'])->name('dashboard.bookmarks');

    /* Reviews */
    Route::get('/reviews', [DashboardController::class, 'reviews'])->name('dashboard.reviews');

    /* Settings */
    Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');

    /* Messages */
    Route::get('/messages', [DashboardController::class, 'messages'])->name('dashboard.messages');

    /* Candidates */
    Route::get('/candidates', [DashboardController::class, 'candidates'])->name('dashboard.candidates');

    /* Task */
    Route::get('/manage/task', [TaskController::class, 'manage'])->name('dashboard.task.manage');
    Route::get('/manage/bidders', [TaskController::class, 'manage'])->name('dashboard.task.manage');
    Route::post('/task/create', [TaskController::class, 'create'])->name('dashboard.task.create');

    /* Bids */
    Route::get('/manage/bidders', [BidController::class, 'manage'])->name('dashboard.bid.manage');
    Route::get('/my-active-bids', [BidController::class, 'activeBids'])->name('dashboard.bid.active');

    /* Job */
    Route::get('/manage/job', [JobController::class, 'manage'])->name('dashboard.job.manage');
    Route::post('/job/create', [JobController::class, 'create'])->name('dashboard.job.create');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
