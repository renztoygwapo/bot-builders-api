<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([ 'message' => 'B2 Atlas Web API Service Version 1.0' ], 200);
});

Route::get('fetch', function() {
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Sp-Client-Id' => config('services.opsn.client_id'),
        'Sp-Client-Secret' => config('services.opsn.client_secret')
    ])->get(config('services.opsn.api_endpoint') . '/authorized/agency/opsn?page=1&limit=10');

    dd($response->json());
});
