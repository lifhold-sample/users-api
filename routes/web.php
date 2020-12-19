<?php

use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "users", ""], function() {
    Route::get("{id}", "UsersController@getOne");
    Route::post("", "UsersController@create");
    Route::delete("{id}", "UsersController@delete");
});
