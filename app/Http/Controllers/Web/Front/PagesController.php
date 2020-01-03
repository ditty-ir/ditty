<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Pages;

class PagesController extends Controller
{
    public function index(Pages $pages, $path)
    {
        if ($pages->existsByPath(clean($path))) {
            return view('front.main');
        }

        return response()->view('front.main', [
            'httpCode' => 404
        ], 404);
    }
}
