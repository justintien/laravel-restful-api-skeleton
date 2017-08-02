<?php
use App\Model\DateTime;

Route::get('/', function (Request $request) {
    return [
        'code' => 0
    ];
});

Route::get('/now', function (Request $request) {
    return DateTime::now()->toRfc3339String();
});
