<?php

namespace Envant\Likes;

use Illuminate\Http\Response;
use Envant\Helpers\ModelMapper;
use Illuminate\Routing\Controller;
use Envant\Likes\Requests\LikeRequest;

class LikeController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function __invoke(LikeRequest $request)
    {
        $model = ModelMapper::getEntity($request->model_type, $request->model_id);
        $model->toggleLike();

        response()->json([
            'success' => true,
        ], Response::HTTP_NO_CONTENT);
    }
}
