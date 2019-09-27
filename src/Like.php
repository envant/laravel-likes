<?php

namespace Envant\Likes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    use HasLikes;

    /** @var array */
    protected $fillable = [
        'user_id',
    ];

    /** @var array */
    protected $hidden = [
        'model_id',
        'model_type',
        'created_at',
        'updated_at',
    ];

    /**
     * Override default model name
     *
     * @return string
     */
    public function getTable()
    {
        return config('likes.table');
    }

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    /**
     * Liker
     * 
     * @return BelongsTo|User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(static::getAuthModelName(), 'user_id');
    }

    /**
     * Related model
     *
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /*
     |--------------------------------------------------------------------------
     | Helpers
     |--------------------------------------------------------------------------
     */

    /**
     * Get auth model
     *
     * @return string
     * @throws Exception
     */
    public static function getAuthModelName()
    {
        if (config('likes.user_model')) {
            return config('likes.user_model');
        }

        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the liker model name.');
    }
}
