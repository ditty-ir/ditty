<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}
