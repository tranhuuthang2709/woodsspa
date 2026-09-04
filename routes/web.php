<?php

use App\Http\Controllers\Admin\Admin_homecontroller;
use App\Http\Controllers\Admin\AboutManagementController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\List_ServiceController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

//
// -------------------------
// PUBLIC ROUTES
// -------------------------
//

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', function ($locale) {
    $supported = ['vi', 'en', 'jp', 'kr', 'cn'];
    if (!in_array($locale, $supported)) {
        abort(404);
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('set.language');

Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/services', [List_ServiceController::class, 'index'])->name('service.list');
Route::get('/services/{serviceId}', [List_ServiceController::class, 'show'])->name('service.detail');

Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login']);
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');


Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin')
    ->group(function () {

        // Dashboard
        Route::get('/', [Admin_homecontroller::class, 'index'])->name('home');

        // Categories & Services
        Route::resource('categories', CategoryController::class);
        Route::resource('services', ServiceController::class);

        // Bookings
        Route::get('/bookings', [BookingController::class, 'list'])->name('booking.list');
        Route::post('/bookings/{id}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

        // Banner
        Route::get('/banner', [BannerController::class, 'index'])->name('banner');
        Route::post('/banner/upload', [BannerController::class, 'upload'])->name('banner.upload');
        Route::post('/banner/toggle/{id}', [BannerController::class, 'toggle'])->name('banner.toggle');
        Route::put('/banner/{id}/update', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
        //change_password
        Route::get('/change-password', [AdminAuthController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [AdminAuthController::class, 'updatePassword'])->name('change-password.update');
});
