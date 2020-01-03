<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostObserver
{

    public function creating(Post $post)
    {
        $post->user_id = Auth::id();
    }
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        $post->tag(request()->tags);
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        if ($post->isDirty('cover_image')) {
            if (! empty($image = $post->getOriginal('cover_image'))) {
                $file = public_path() . '/assets/images/cover-images/' . $image . '.jpg';
                File::delete($file);
            }
        }
        $post->retag(request()->tags);
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        if ($post->cover_image) {
            File::delete(public_path() . $post->cover_image);
        }
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
