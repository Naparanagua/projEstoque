<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/home', function () {
    return response()->json(['teste'=> 10]);
    });

Route::prefix('products')-> controller(ProductController::class)->group(static function(){
    Route::get("",'search');
    Route::post("",'store');

    Route::prefix('{product}')->group(static function(){
        Route::get("", 'show');
        Route::patch("",'update');
        Route::delete("", 'destroy');
    });
});

Route::get('/categorias', function () {
    return response()->json(['categorias'=> 0]);
    });