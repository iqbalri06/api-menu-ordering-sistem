<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Role\RoleController;



Route::get('/', function () {
    return response()->json(['message' => 'Hello Role API']);
});

//Role
Route::get('/index', [RoleController::class, 'index']);
Route::get('/show', [RoleController::class, 'show']);
Route::post('/store', [RoleController::class, 'store']);
Route::patch('/update/{id}', [RoleController::class, 'update']);
Route::delete('/delete/{id}', [RoleController::class, 'destroy']);
Route::get('/download/{id}', [RoleController::class, 'download']);

