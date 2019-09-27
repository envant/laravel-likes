<?php

namespace Envant\Likes\Events;

use Illuminate\Queue\SerializesModels;
use Envant\Likes\Like;

class LikeDeleted
{
    use SerializesModels;
    public $like;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}
