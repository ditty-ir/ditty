<?php

namespace App\Contracts;

use Illuminate\Http\Request;


interface PayInterface
{
    public function pay();
    public function result(Request $request);
}