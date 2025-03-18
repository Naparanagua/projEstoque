<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/home', function () {
    return response()->json(['teste'=> 10]);
    });

Route::get('/produtos', function () {
    #return view('produtos');
    return response()->json(['produtos'=> 0]);
    });