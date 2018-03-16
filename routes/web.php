<?php

Route::get('/stats', 'SiteController@stats');
Route::get('/stats/reset', 'SiteController@statsReset');
Route::get('/', 'SiteController@index');

Route::get('/addUser', 'SiteController@addUser');
Route::get('/data/operations/load', 'SiteController@getOperations');

Route::get('/createTask', function (\Illuminate\Http\Request $request) {

});

Route::group(['prefix' => 'task'], function () {
    Route::get('/changeBalance', 'TaskController@changeBalance');
    Route::get('/changeOperationStatus', 'TaskController@changeOperationStatus');
    Route::get('/transferBalance', 'TaskController@transferBalance');
});
