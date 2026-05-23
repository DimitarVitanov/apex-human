<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/method', [PageController::class, 'method'])->name('method');
Route::get('/apply', [PageController::class, 'apply'])->name('apply');
Route::get('/journal', [PageController::class, 'journal'])->name('journal');
Route::get('/journal/{slug}', [PageController::class, 'journalShow'])->name('journal.show');
Route::get('/daily-apex', [PageController::class, 'dailyApex'])->name('daily-apex');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms-of-service');

// Form submissions
Route::post('/apply', [FormController::class, 'submitApplication'])->name('apply.submit');
Route::post('/contact', [FormController::class, 'submitContact'])->name('contact.submit');

// Booking
Route::get('/apply/book', [BookingController::class, 'show'])->name('booking.show');
Route::get('/api/available-slots', [BookingController::class, 'availableSlots'])->name('booking.slots');
Route::post('/apply/book', [BookingController::class, 'book'])->name('booking.book');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pages', [Admin\PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}/edit', [Admin\PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [Admin\PageController::class, 'update'])->name('pages.update');

    Route::put('/sections/{section}', [Admin\SectionController::class, 'update'])->name('sections.update');

    Route::resource('posts', Admin\PostController::class)->except(['show']);
    Route::resource('daily-apex', Admin\DailyApexController::class)->except(['show']);

    Route::get('/applications', [Admin\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [Admin\ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{application}', [Admin\ApplicationController::class, 'update'])->name('applications.update');

    Route::get('/slots', [Admin\SlotController::class, 'index'])->name('slots.index');
    Route::post('/slots/generate', [Admin\SlotController::class, 'generate'])->name('slots.generate');
    Route::put('/slots/{slot}/toggle', [Admin\SlotController::class, 'toggleBlock'])->name('slots.toggle');
    Route::delete('/slots/{slot}', [Admin\SlotController::class, 'destroy'])->name('slots.destroy');

    Route::get('/contacts', [Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::put('/settings/password', [Admin\SettingController::class, 'updatePassword'])->name('settings.password');

    Route::get('/navigation', [Admin\NavigationController::class, 'index'])->name('navigation.index');
    Route::post('/navigation', [Admin\NavigationController::class, 'store'])->name('navigation.store');
    Route::put('/navigation/{navigation}', [Admin\NavigationController::class, 'update'])->name('navigation.update');
    Route::delete('/navigation/{navigation}', [Admin\NavigationController::class, 'destroy'])->name('navigation.destroy');
});
