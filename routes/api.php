<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Boards\BoardController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Tickets\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get("/me", fn(Request $request) => $request->user());

    // Email Verification Routes
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    // Auth Routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Project Routes
    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('/{project}', [ProjectController::class, 'show']);
        Route::put('/{project}', [ProjectController::class, 'update']);
        Route::delete('/{project}', [ProjectController::class, 'destroy']);
    });

    // Board Routes
    Route::prefix('board')->group(function () {
        Route::post('/', [BoardController::class, 'store']);
        Route::put('/{board}', [BoardController::class, 'update']);
        Route::delete('/{board}', [BoardController::class, 'destroy']);
    });

    // Ticket Routes
    Route::prefix('ticket')->group(function () {
        Route::post('/', [TicketController::class, 'store']);
        Route::get('/{ticket}', [TicketController::class, 'show']);
        Route::put('/{ticket}', [TicketController::class, 'update']);
        Route::delete('/{ticket}', [TicketController::class, 'destroy']);
        Route::post('/{ticket}/move', [TicketController::class, 'move']);
        Route::post('/{ticket}/assign', [TicketController::class, 'assign']);
    });
});
