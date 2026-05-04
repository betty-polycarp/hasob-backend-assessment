<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use Hasob\FoundationCore\Middleware\IdentifyOrganization;
use Illuminate\Support\Facades\Route;

$orgRoutes = function () {
    Route::group([
        'middleware' => IdentifyOrganization::class,
    ], function () {

        // Frontend routes
        Route::get('/', [FrontendController::class, 'displayHome'])->name('home');

        Auth::routes();
        SavingsBond::public_routes();
        FoundationCore::public_routes();

        Route::middleware(['auth'])->group(function () {

            // Package Routes
            SavingsBond::routes();
            FoundationCore::routes();

            // Dashboard Routes
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        });

    });
};

Route::group([], $orgRoutes);
