<?php

namespace Envant\Likes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Exception;

class Like extends Model
{
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
    public function getTable(): string
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(static::getAuthModelName(), 'user_id');
    }

    /**
     * Related model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
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
    public static function getAuthModelName(): string
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
