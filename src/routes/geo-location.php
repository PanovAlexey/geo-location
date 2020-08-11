<?php
use Illuminate\Support\Facades\Route;
use CodeblogPro\GeoLocation\Controller\GeoLocationController;

Route::prefix('api')->middleware('api')->group(function() {
    Route::get('/geo-location/{ip?}/{language?}', [GeoLocationController::class, 'show'])->name('codeblogpro.geolocation.get.location');
    Route::match(['post', 'put', 'patch', 'delete', 'options'], '/geo-location/{ip?}/{language?}', [
        GeoLocationController::class, 'incorrectMethod']
    );
});