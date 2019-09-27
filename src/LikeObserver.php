<?php

namespace Envant\Likes;

use Envant\Likes\Like;
use Envant\Likes\Events\LikeCreated;
use Envant\Likes\Events\LikeUpdated;
use Envant\Likes\Events\LikeDeleted;
use Illuminate\Support\Facades\Event;

class LikeObserver
{
    /**
     * Handle the like "created" event
     *
     * @param Like $like
     * @return void
     */
    public function created(Like $like)
    {
        Event::dispatch(new LikeCreated($like));
    }

    /**
     * Handle the like "deleted" event
     *
     * @param Like $like
     * @return void
     */
    public function deleted(Like $like)
    {
        Event::dispatch(new LikeDeleted($like));
    }
}
