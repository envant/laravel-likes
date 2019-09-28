<?php

namespace Envant\Likes;

use Illuminate\Http\Response;
use Envant\Helpers\ModelMapper;
use Illuminate\Routing\Controller;
use Envant\Likes\Requests\LikeRequest;

class LikeController extends Controller
{
    /** @var \Illuminate\Contracts\Auth\Authenticatable|null  */
    private $user;

    /**
     * LikeController constructor.
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * @param \Envant\Likes\Requests\LikeRequest $request
     * @throws \Exception
     */
    public function __invoke(LikeRequest $request)
    {
        /** @var \Envant\Likes\HasLikes $model */
        $model = ModelMapper::getEntity($request->model_type, $request->model_id);
        $model->toggleLike();

        response()->json([
            'success' => true,
        ], Response::HTTP_NO_CONTENT);
    }
}
