<?php

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
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'namespace' => 'Admin'], function()
{
    CRUD::resource('brand', 'BrandCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('asset', 'AssetCrudController');
    Route::get('assign/asset/', 'AssignAssetCrudController@searchAsset');
    CRUD::resource('assign', 'AssignAssetCrudController');
    CRUD::resource('action', 'ActionCrudController');
});
