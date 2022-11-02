<?php

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


Route::get("/", "TaskController@index")->name("task.index");

Route::group(["prefix" => "tasks"], function () {

    Route::get("recyclebin/", "TaskController@bin")->name("task.recyclebin");
    Route::get("restore/{task_id}", "TaskController@restore")->name("task.restore");
    Route::post("store", "TaskController@store")->name("task.store");
    Route::get("edit/{task_id}", "TaskController@edit")->name("task.edit");
    Route::get("delete/{task_id}", "TaskController@destroy")->name("task.delete");
    Route::post("update/{task_id}", "TaskController@update")->name("task.update");
    Route::post("search", "TaskController@search")->name("task.show");
    Route::get("search/{task_name}", "TaskController@show")->name("task.view");
   
});

