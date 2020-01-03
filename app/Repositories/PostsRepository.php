<?php
namespace App\Repositories;

use App\Models\{Post, FeaturedPost};
// use App\Contracts\PostsRepositoryInterface;

class PostsRepository extends Repository // implements PostsRepositoryInterface
{

    public function model()
    {
        return Post::class;
    }

    public function exists($post_id, $status = Post::STATUS_PUBLISHED)
    {
        return DB::table('posts')
            ->where('id', get_post_id($post_id))
            ->where('status', $status)
            ->select('id')
            ->exists();
    }

    public function paginate($limit = 10, int $status = 3)
    {
        return $this->model
            ->select($this->model->necessaryFields())
            ->where('status', '>=', $status)
            ->orderBy('id', 'desc')
            ->with(['tagged', 'featured'])
            ->paginate($limit);
    }

    public function search($request)
    {
        return $this->model
            ->select($this->model->necessaryFields())
            // ->where('status', '>=', )
            ->when($request->id, function($query, $id) {
                if (preg_match('/^[A-Za-z0-9]{5}$/', $id)) {
                    $id = get_post_id($id);
                    if ($id == null) {
                        return;
                    }
                }
                return $query->where('id', $id);
            })
            ->when($request->title, function($query, $title) {
                return $query->where('title', 'like', "%$title%");
            })
            ->when($request->category_id, function($query, $category_id) {
                return $query->where('category_id', $category_id);
            })
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->with(['tagged', 'featured'])
            ->paginate();
    }

    public function getByCategoryId($category_id, $limit = 10, int $status = 3, $paginate = true)
    {
        $posts = $this->model
            ->select($this->model->necessaryFields())
            ->where('category_id', $category_id)
            ->isPublished()
            ->orderBy('id', 'desc')
            ->where('status', $status)
            ->limit($limit);

        return $paginate ? $posts->paginate($limit) : $posts->get();
    }

    public function getByUserId($user_id, $limit = 10, $status = 3)
    {
        return $this->model
            ->select($this->model->necessaryFields())
            ->where('status', '>=', $status)
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->with('tagged')
            ->paginate($limit);
    }

    public function getByTag($tag, $limit = 10, int $status = 3, $paginate = true) {
        $posts = $this->model
            ->select($this->model->necessaryFields())
            ->where('status', '>=', $status)
            ->orderBy('id', 'desc')
            ->withAnyTag($tag)
            ->limit($limit);

        return $paginate ? $posts->paginate() : $posts->get();
    }

    public function find($id, int $status = 3)
    {
        return $this->model
            ->where('id', $id)
            ->where('status', '>=', $status)
            ->first();
    }

    public function related($post, $limit = 6, int $status = 3)
    {
        return $this->model
            ->select($this->model->necessaryFields())
            ->where('category_id', $post->category_id)
            ->where('id', '<>', $post->id)
            ->isPublished()
            ->where('status', '>=' ,$status)
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function featured($limit = 4)
    {
        return FeaturedPost::limit($limit)
            ->latest('id')
            ->with(['post' => function($query) {
                $query->where('status', Post::STATUS_PUBLISHED)->select($this->model->necessaryFields());
            }])
            ->get()
            ->pluck('post');
    }

    public function published()
    {
        return $this->model
            ->select($this->model->necessaryFields())
            ->where('status', Post::STATUS_PUBLISHED)
            ->latest('id')
            ->get();
    }
}