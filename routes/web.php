<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'title'   => 'Sample Ecommerce APP API',
        'contact' => [
            'name' => 'API Support',
            'email' => 'everythingaboutcode@gmail.com'
        ],
        'version' => "1.0.0"
    ]);
});
