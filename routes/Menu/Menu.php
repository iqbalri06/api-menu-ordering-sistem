<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Menu\MenuController;



Route::get('/', function () {
    return response()->json(['message' => 'Hello Role API']);
});


Route::middleware('auth')->group(function () {
    Route::post('/menus', [MenuController::class, 'store']);
});


