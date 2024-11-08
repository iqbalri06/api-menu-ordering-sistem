<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\User\UserController;



Route::get('/', function () {
    return response()->json(['message' => 'Hello Role API']);
});


Route::get('/index', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/me', [UserController::class, 'me']);
Route::post('/logout', [UserController::class, 'logout']);

