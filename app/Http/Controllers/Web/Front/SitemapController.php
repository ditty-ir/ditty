<?php

namespace App\Http\Controllers\Web\Front;

use App\Models\Post;
use App\Models\Page;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{

    public function index()
    {
        return response()->view('front.sitemap', [
            'posts' => $this->posts(),
            'categories' => $this->categories(),
            'authors' => $this->authors(),
            'pages' => $this->pages(),
        ])->header('Content-Type', 'text/xml');
    }

    private function posts()
    {
        return Cache::remember('sitemap_posts', 3600, function() {
            return Post::select('title', 'id', 'slug', 'updated_at')
                ->where('status', Post::STATUS_PUBLISHED)
                ->get();
        });
    }

    private function categories()
    {
        return Cache::remember('sitemap_categories', 3600, function() {
            return Category::select('id', 'title')->get();
        });
    }

    private function authors()
    {
        return [];

        /* return Cache::remember('sitemap_users', 3600, function() {
            return User::select('username')->get();
        }); */
    }

    private function pages()
    {
        return Cache::remember('sitemap_pages', 3600, function() {
            return Page::select('path')->get();
        });
    }
}
