<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;


Route::get('/', function () {
    return  response()->json([
        'title'   => 'Sample Ecommerce API',
        'end point' => URL::current(),
        'contact' => [
            'name' => 'API Support',
            'email' => 'everythingaboutcode@gmail.com'
        ],
        'version' => "1.0.0"
    ]);
});
