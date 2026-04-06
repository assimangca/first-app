<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     * (Controls access to the Index page)
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can see the list of posts
    }

    /**
     * Determine whether the user can view the model.
     * (Controls access to the Show page)
     */
    public function view(?User $user, Post $post): bool
    {
        return true; // Anyone can view an individual post
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any logged-in user can create a post
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // Only the user who created the post can edit it
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // Only the user who created the post can delete it
        return $user->id === $post->user_id;
    }

    /**
     * These usually default to the same logic as update/delete
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}