<?php

namespace Envant\Likes\Events;

use Envant\Likes\Like;
use Illuminate\Queue\SerializesModels;

class LikeCreated
{
    use SerializesModels;

    /** @var \Envant\Likes\Like */
    public $like;

    /**
     * Create a new event instance.
     *
     * @param \Envant\Likes\Like $like
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}
