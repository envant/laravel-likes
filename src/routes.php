<?php

Route::prefix(config('likes.routes.prefix'))->middleware([config('likes.routes.middleware')])->group(function () {
    Route::post('likes', config('likes.routes.controller'));
});