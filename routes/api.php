<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UrlShortenerController;



Route::post('/encode', [UrlShortenerController::class, 'encode']);
Route::post('/decode', [UrlShortenerController::class, 'decode']);