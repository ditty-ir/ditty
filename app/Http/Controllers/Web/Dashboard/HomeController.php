<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{

    public function index()
    {
        return view('dashboard.index');
    }
}
