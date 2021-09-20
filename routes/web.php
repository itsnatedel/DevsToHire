<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FreelancerController;

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
Route::get('/search', [WelcomeController::class, 'search'])->name('welcome.search');

/* 404 */
Route::get('/404', function () {
    return view('404');
})->name('error-404');

/* Contact */
Route::get('/contact-us', function () {
    return view('contact');
})->name('contact');

Route::post('/contact-us', [Controller::class, 'sendContactForm'])->name('sendContactForm');

Route::get('/terms-of-use', function () {
    return view('terms');
})->name('terms');

Route::get('/automatic-renewal-terms', function () {
    return view('renewal');
})->name('renewal');
/* Auth routes */
Auth::routes();

/* Blog Routes */
Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/article/{id}', [BlogController::class, 'show'])->where('id', '[0-9]+')->name('blog.show');
});

/* Company Routes */
Route::group(['prefix' => 'companies'], function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/{id}/{slug}', [CompanyController::class, 'show'])->where('id', '[0-9]+')->name('company.show');
    Route::post('/{id}/{slug}', [CompanyController::class, 'show'])->where('id', '[0-9]+')->name('company.ratings.search');
    Route::get('/{letter}', [CompanyController::class, 'search'])->where('letter', '[a-z]')->name('company.search');
});

/* Freelancer Routes */
Route::group(['prefix' => 'freelancers'], function () {
    Route::get('/', [FreelancerController::class, 'index'])->name('freelancer.index');
    Route::get('/{id}/{fullname}', [FreelancerController::class, 'show'])
        ->where('id', '[0-9]+')
        ->where('fullname', '[a-z-]+')
        ->name('freelancer.show');
    Route::get('/search', [FreelancerController::class, 'search'])->name('freelancer.search');
    Route::get('/{id}/{cv}', [FreelancerController::class, 'downloadCV'])
        ->where('id', '[0-9]+')
        ->where('cv', '[a-z0-9-.]+')
        ->name('freelancer.cv.download');
});

/* Invoice Routes */
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->where('id', '[0-9]+')->name('invoice.show');
Route::get('/invoice/{invoiceId}', [InvoiceController::class, 'download'])->where('id', '[a-Z0-9]+')->name('invoice.download');

/* Job Routes */
Route::group(['prefix' => 'jobs'], function () {
    Route::get('/', [JobController::class, 'index'])->name('job.index');
    Route::get('/category/{id}', [JobController::class, 'category'])->where('id', '[0-9]+')->name('job.category');
    Route::get('/{id}/{slug}', [JobController::class, 'show'])->where('id', '[0-9]+')->name('job.show');
    Route::get('/search', [JobController::class, 'search'])->name('job.search');
});

/* Bid Routes */
Route::get('/bid/place/{id}', [BidController::class, 'placeBid'])->where('id', '[0-9]+')->name('bid.place');

/* Order Routes */
Route::group(['prefix' => 'order'], function () {
    Route::get('/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/error', [OrderController::class, 'error'])->name('order.error');
});

/* Checkout pages */
Route::group(['prefix' => 'checkout', 'middleware' => 'auth'], function() {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/payment', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-success', [CheckoutController::class, 'suceeded'])->name('checkout.success');
});

/* Premium Routes */
Route::get('/plans', [PremiumController::class, 'index'])->name('premium.index');

/* Task Routes */
Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', [TaskController::class, 'index'])->name('task.index');
    Route::get('/{task_id}/{slug}', [TaskController::class, 'show'])
        ->where('task_id', '[0-9]+')
        ->where('slug', '[a-z-]+')
        ->name('task.show');
    Route::get('/search', [TaskController::class, 'search'])->name('task.search');
    Route::post('/create', [TaskController::class, 'store'])->name('task.store');
    Route::get('/{taskId}/{fileUrl}', [TaskController::class, 'downloadBrief'])
        ->where('taskId', '[0-9]+')
        ->where('fileUrl', '[a-z0-9-.]+')
        ->name('task.brief.download');
});

/* Dashboard Routes */
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], static function () {
    /* Dashboard Home page */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    /* Bookmarks */
    Route::get('/bookmarks', [DashboardController::class, 'bookmarks'])->name('dashboard.bookmarks');

    /* Reviews */
    Route::get('/reviews', [DashboardController::class, 'reviews'])->name('dashboard.reviews');

    /* Settings */
    Route::get('/settings', [DashboardController::class, 'edit'])->name('dashboard.settings');
    Route::post('/settings/update', [DashboardController::class, 'update'])->name('dashboard.settings.update');

    /* Messages */
    Route::get('/messages', [DashboardController::class, 'messages'])->name('dashboard.messages');

    /* Candidates */
    Route::get('/candidates', [DashboardController::class, 'candidates'])->name('dashboard.candidates');

    /* Task */
    Route::get('/manage/task', [TaskController::class, 'manage'])->name('dashboard.task.manage');
    Route::get('/manage/bidders', [TaskController::class, 'manage'])->name('dashboard.bidders.manage');
    Route::get('/task/create', [DashboardController::class, 'createTask'])->name('dashboard.task.create');

    /* Bids */
    Route::get('/manage/bidders', [BidController::class, 'manage'])->name('dashboard.bid.manage');
    Route::get('/my-active-bids', [BidController::class, 'activeBids'])->name('dashboard.bid.active');

    /* Job */
    Route::get('/manage/job', [JobController::class, 'manage'])->name('dashboard.job.manage');
    Route::get('/job/create', [DashboardController::class, 'createJob'])->name('dashboard.job.create');
});