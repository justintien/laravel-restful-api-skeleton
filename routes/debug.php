<?php
use App\Model\DateTime;
use App\Exceptions\Error;

Route::get('/e', function (Request $request) {
    throw new Error('throw a exception.');
});

Route::get('/internal_server_error', function () {
    abort(500);
});
