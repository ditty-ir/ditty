<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{

    public function index()
    {
        return view('front.main');
    }

    public function notFound()
    {
        return response()->view('front.main', [
            'httpCode' => 404
        ], 404);
    }
}
