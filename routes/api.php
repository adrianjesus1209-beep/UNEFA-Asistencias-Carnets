<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/auth/login', LoginController::class);

Route::middleware(['auth:sanctum', 'active.user'])->prefix('v1')->group(function () {
    Route::post('/auth/logout', LogoutController::class);

    Route::get('/me', function (Request $request) {
        $user = $request->user()->load([
            'profile.career',
            'roles' => fn ($q) => $q->wherePivot('is_active', 1),
        ]);

        return response()->json([
            'user' => $user,
        ]);
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});