<?php

namespace Envant\Likes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    protected static function bootHasLikes()
    {
        // delete attached likes

        static::deleting(function ($model) {
            /** @var \Envant\Likes\HasLikes $model */
            $model->likes()->delete();
        });
    }

    /**
     * Return all likes for this model.
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(config('likes.model'), 'model');
    }

    /**
     * Attach or detach a like from this model.
     *
     * @return bool
     * @throws \Exception
     */
    public function toggleLike(): bool
    {
        return $this->toggleLikeAsUser(auth()->user());
    }

    /**
     * Attach or detach a like from this model as a specific user.
     *
     * @param Model|null $user
     * @return bool
     * @throws \Exception
     */
    public function toggleLikeAsUser(?Model $user): bool
    {
        $like = $this->likes()->where('user_id', $user->getKey())->first();

        if ($like) {
            $like->delete();

            return false;
        }

        $this->likes()->create([
            'user_id' => $user->getKey(),
        ]);

        return true;
    }

    /**
     * Check if user already liked the model
     *
     * @return boolean
     */
    public function getIsLikedAttribute(): bool
    {
        return $this->likes()->where('user_id', auth()->user()->getKey())->exists();
    }
}
