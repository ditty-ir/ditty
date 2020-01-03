<?php
namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsRepository extends Repository
{
    public function model()
    {
        return Comment::class;
    }

    public function all()
    {
        return $this->model->with(['commentable' => function($query) {
            $query->select('title', 'id');
        }])
        ->latest('id')
        ->get();
    }

    public function paginate($limit = 15)
    {
        return $this->model->with(['commentable' => function($query) {
            $query->select('title', 'id');
        }])
        ->with('user')
        ->latest('id')
        ->paginate($limit);
    }

    public function create(array $data)
    {
        return new $this->model($data);
    }

    public function latestApproved($limit = 10)
    {
        return $this->model
            ->where('status', Comment::STATUS_APPROVED)
            ->limit($limit)
            ->latest('id')
            ->select('text', 'id', 'user_id', 'name', 'commentable_id', 'commentable_type')
            ->with(
                [
                    'commentable' => function($query) {
                        $query->select('id', 'title', 'slug');
                    },
                    'user' => function($query) {
                        $query->select('id', 'name', 'avatar');
                    }
                ]
            )
            ->get();
    }
}