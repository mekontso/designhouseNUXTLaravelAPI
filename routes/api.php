<?php

use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return response()->json("Hello my friend");
});
