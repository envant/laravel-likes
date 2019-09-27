<?php

namespace Envant\Likes\Tests\Models;

use Envant\Likes\HasLikes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasLikes;
    protected $guarded = [];
}
