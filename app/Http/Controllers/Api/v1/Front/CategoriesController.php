<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Models\Category;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostsRepository;
use App\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{

    private $categories;

    public function __construct(CategoriesRepository $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $categories = $this->categories->inHomePage();

        return Response::success('', $categories);
    }

    public function inHomePage()
    {
        $categories = $this->categories->inHomePage();

        return Response::success('', $categories);
    }

    public function show(Post $post)
    {
        return Response::success('', $post);
    }

    public function posts(Category $category, PostsRepository $postsRepo)
    {
        $posts = $postsRepo->getByCategory($category->id);

        return Response::success('', $posts);
    }

    public function single(Category $category)
    {
        return Response::success('', $category);
    }
}
