<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Cache;

Route::redirect('/', '/dashboard');
 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});
 
    Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  
    Route::get('/dashboard', DashboardController::class)->name('dashboard'); 
    Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->name('short-urls.redirect'); 
    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('short-urls.index'); 
    Route::middleware('role:admin,member')->group(function () {
        Route::get('/short-urls/create', [ShortUrlController::class, 'create'])->name('short-urls.create');
        Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('short-urls.store');
    }); 
    Route::middleware('role:super_admin')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    }); 
    Route::middleware('role:super_admin,admin')->group(function () {
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    });
    
    // check cache 
    Route::get('/cache-check', function () { 
        Cache::put('my_test', 'Hello Laravel', 600); 
            return [
                'value' => Cache::get('my_test'),
                'has' => Cache::has('my_test'),
            ];
    });

    Route::get('/test-cache', function () {        
        $value = Cache::remember('demo', 3600, function () { 
             logger('Cache Miss'); 
            return now()->format('H:i:s');
        });
            logger('Hit Cache'); 
        return $value;
    });

});
