<?php

return [
    'table' => 'likes',
    'model' => Envant\Likes\Like::class,
    'user_model' => null,
    'routes' => [
        'enabled' => true,
        'controller' => Envant\Likes\LikeController::class,
        'middleware' => 'api',
        'prefix' => 'api',
    ],
];
