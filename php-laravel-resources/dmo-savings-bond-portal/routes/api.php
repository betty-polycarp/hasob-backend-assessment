<?php

use Hasob\FoundationCore\Middleware\IdentifyOrganization;
use Illuminate\Support\Facades\Route;

$orgRoutes = function () {

    Route::group([
        'middleware' => IdentifyOrganization::class,
    ], function () {

        SavingsBond::api_public_routes();
        FoundationCore::api_public_routes();

        Route::middleware(['auth:sanctum'])->group(function () {

            SavingsBond::api_routes();
            FoundationCore::api_routes();

        });

    });
};

Route::group([], $orgRoutes);
