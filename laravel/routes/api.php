<?php

use Illuminate\Http\Request;
use App\Models\Histories;
use App\Models\Currencies;
use App\Models\Sources;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('crypto')->group(function () {

    Route::get('refresh', '\App\Http\Controllers\Crypto@refresh');

});

Route::prefix('sources')->group(function () {

    Route::get('', function() {
        return Sources::all();
    });

    Route::get('{id}', function($id) {
        return Sources::find($id);
    });

    Route::post('', function(Request $request) {
        return Sources::create($request->all);
    });

    Route::put('{id}', function(Request $request, $id) {
        $article = Sources::findOrFail($id);
        $article->update($request->all());
        return $article;
    });

    Route::delete('{id}', function($id) {
        Sources::find($id)->delete();
        return 204;
    });

});

Route::prefix('currency')->group(function () {

    Route::get('', function() {
        return Currencies::all();
    });

    Route::get('{id}', function($id) {
        return Currencies::find($id);
    });

    Route::post('', function(Request $request) {
        return Currencies::create($request->all);
    });

    Route::put('{id}', function(Request $request, $id) {
        $article = Currencies::findOrFail($id);
        $article->update($request->all());
        return $article;
    });

    Route::delete('{id}', function($id) {
        Currencies::find($id)->delete();
        return 204;
    });

});

Route::prefix('history')->group(function () {

    Route::get('', function() {
        return Histories::all();
    });

    Route::get('{id}', function($id) {
        return Histories::find($id);
    });

    Route::post('', function(Request $request) {
        return Histories::create($request->all);
    });

    Route::put('{id}', function(Request $request, $id) {
        $article = Histories::findOrFail($id);
        $article->update($request->all());
        return $article;
    });

    Route::delete('{id}', function($id) {
        Histories::find($id)->delete();
        return 204;
    });

});
