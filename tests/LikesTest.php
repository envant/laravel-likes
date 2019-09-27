<?php

namespace Envant\Likes\Tests;

class LikesTest extends TestCase
{
    public function testToggleLike()
    {
        // attach like
        $this->testPost->toggleLike();
        $this->assertEquals($this->testPost->likes()->count(), 1);

        // detach like
        $this->testPost->toggleLike();
        $this->assertEquals($this->testPost->likes()->count(), 0);
    }
}
