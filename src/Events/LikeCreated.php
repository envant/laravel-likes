<?php

namespace Envant\Likes\Events;

use Illuminate\Queue\SerializesModels;
use Envant\Likes\Like;

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
