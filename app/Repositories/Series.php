<?php
namespace App\Repositories;

use App\Models\Series as Model;
use App\Models\SeriesPost;
use Carbon\Carbon;

class Series extends Repository
{
    public function model()
    {
        return Model::class;
    }

    public function attachPosts(Model $series, array $postIds)
    {
        $toInsert = [];
        $now = Carbon::now();

        foreach ($postIds as $post_id) {
            $toInsert[] = [
                'series_id' => $series->id,
                'post_id' => $post_id,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        SeriesPost::insert($toInsert);
    }

    public function syncPosts(Model $series, array $postIds)
    {
        $this->detachPosts($series);
        $this->attachPosts($series, $postIds);
    }

    public function detachPosts(Model $series)
    {
        SeriesPost::where('series_id', $series->id)->delete();
    }
}