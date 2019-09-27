<?php

namespace Envant\Likes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
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
     * @param string $body
     * @return bool
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
     */
    public function toggleLikeAsUser(?Model $user): bool
    {
        $like = $this->likes()->where('user_id', $user->getKey())->first();

        if ($like) {
            $like->delete();

            return false;
        }

        $like = $this->likes()->create([
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
