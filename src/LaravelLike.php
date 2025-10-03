<?php

namespace stevecreekmore\LaravelLike;

use Carbon\Carbon;
use stevecreekmore\LaravelLike\Models\Like;

trait LaravelLike
{
    /**
     * Like the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function like(mixed $user): void
    {
        $user_id = is_int($user) ? $user : $user->id;

        Like::firstOrCreate([
            'user_id' => $this->id,
            'liking_id' => $user_id,
        ]);
    }

    /**
     * Unlike the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function unlike(mixed $user): void
    {
        $user_id = is_int($user) ? $user : $user->id;

        Like::where('user_id', $this->id)
            ->where('liking_id', $user_id)
            ->delete();
    }

    /**
     * Check if a user is blocking the given user.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function isLiking(mixed $user): bool
    {
        $user_id = is_int($user) ? $user : $user->id;

        if (cache()->has('liking.' . $this->id)) {
            if (in_array($user_id, $this->getLikingCache())) {
                return true;
            }

            return false;
        }

        $isLiking = Like::toBase()
            ->where('user_id', $this->id)
            ->where('liking_id', $user_id)
            ->first();

        if ($isLiking) {
            return true;
        }

        return false;
    }

    /**
     * Check if a user is liked by the given user.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function isLikedBy(mixed $user): bool
    {
        $user_id = is_int($user) ? $user : $user->id;

        if (cache()->has('likers.' . $user_id)) {
            if (in_array($user_id, $this->getLikersCache())) {
                return true;
            }

            return false;
        }

        $isLikedBy = Like::toBase()
            ->where('user_id', $user_id)
            ->where('liking_id', $this->id)
            ->first();

        if ($isLikedBy) {
            return true;
        }

        return false;
    }

    /**
     * Returns the users a user is liking
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLiking()
    {
        return Like::where('user_id', $this->id)
            ->with('liking')
            ->get();
    }

    /**
     * Returns the users who are liking a user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLikers()
    {
        return Like::where('liking_id', $this->id)
            ->with('likers')
            ->get();
    }

    /**
     * Returns IDs of the users a user is liking.
     *
     * @return array
     */
    public function getLikingIds(): array
    {
        return Like::toBase()
            ->where('user_id', $this->id)
            ->pluck('liking_id')
            ->toArray();
    }

    /**
     * Returns IDs of the users who are liking a user.
     *
     * @return array
     */
    public function getLikersIds(): array
    {
        return Like::toBase()
            ->where('liking_id', $this->id)
            ->pluck('user_id')
            ->toArray();
    }

    /**
     * Returns IDs of the users a user is liking.
     * Returns IDs of the users who are liking a user.
     *
     * @return array
     */
    public function getLikingAndLikersIds(): array
    {
        return [
            'liking' => $this->getLikingIds(),
            'likers' => $this->getLikersIds(),
        ];
    }

    /**
     * Caches IDs of the users a user is liking.
     *
     * @param  mixed  $duration
     * @return void
     */
    public function cacheLiking(mixed $duration = null): void
    {
        $duration ?? Carbon::now()->addDay();

        cache()->forget('liking.' . $this->id);

        cache()->remember('liking.' . $this->id, $duration, function () {
            return $this->getLikingIds();
        });
    }

    /**
     * Caches IDs of the users who are liking a user.
     *
     * @param  mixed|null  $duration
     * @return void
     */
    public function cacheLikers(mixed $duration = null): void
    {
        $duration ?? Carbon::now()->addDay();

        cache()->forget('likers.' . $this->id);

        cache()->remember('likers.' . $this->id, $duration, function () {
            return $this->getLikersIds();
        });
    }

    /**
     * Returns IDs of the users a user is liking.
     *
     * @return array
     *
     * @throws
     */
    public function getLikingCache(): array
    {
        return cache()->get('liking.' . $this->id) ?? [];
    }

    /**
     * Returns IDs of the users who are liking a user.
     *
     * @return array
     *
     * @throws
     */
    public function getLikersCache(): array
    {
        return cache()->get('likers.' . $this->id) ?? [];
    }

    /**
     * Clears the liking cache.
     *
     * @return void
     */
    public function clearLikingCache(): void
    {
        cache()->forget('liking.' . $this->id);
    }

    /**
     * Clears the Likers cache.
     *
     * @return void
     */
    public function clearLikersCache(): void
    {
        cache()->forget('likers.' . $this->id);
    }
}
