<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageViewedController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);

// Router para a extensão
Route::prefix('/ex')->group(function () {
    Route::middleware(['auth.api'])->group(function () {
        Route::get('/unreadMessages', [MessageController::class, 'unreadMessages'])->name('messages.unreadMessages');
        Route::post('/viewMessageByUser', [MessageViewedController::class, 'viewMessageByUser'])->name('messageViewed.viewMessageByUser');
        Route::get('/viewMessagePriority', [MessageController::class, 'viewMessagePriority'])->name('messages.viewMessagePriority');
    });
});

Route::prefix('/v1')->group(function () {
    Route::middleware(['jwt.verify'])->group(function () {

        // Mensagens
        Route::get('/messages', [MessageController::class, 'listAll'])->name('messages.listAll');
        Route::post('/message', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/message/{id}', [MessageController::class, 'show'])->name('messages.show');
        Route::put('/message/{id}', [MessageController::class, 'update'])->name('messages.update');
        Route::delete('/message/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
        Route::get('/messagesIsActive', [MessageController::class, 'messagesIsActive'])->name('messages.messageIsActive');
        Route::get('/messagesOnTimeIsActive', [MessageController::class, 'messagesOnTimeIsActive'])->name('messages.messageOnTimeIsActive');
        Route::get('/unreadMessages', [MessageController::class, 'unreadMessages'])->name('messages.unreadMessages');
        Route::put('/prioritizeMessage', [MessageController::class, 'prioritizeMessage'])->name('messages.prioritizeMessage');
        Route::delete('/deprioritizeMessage', [MessageController::class, 'deprioritizeMessage'])->name('messages.deprioritizeMessage');

        // Usuários
        Route::get('/users', [UserController::class, 'listAll'])->name('users.listAll');
        Route::post('/user', [UserController::class, 'store'])->name('users.store');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    });
});


