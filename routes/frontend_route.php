<?php
use Illuminate\Support\Facades\Route;

Route::get('/',function(){

    abort(404);
    return view('frontend.index');
});


