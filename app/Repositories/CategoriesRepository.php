<?php
namespace App\Repositories;

use Illuminate\Http\Request;

class CategoriesRepository extends Repository
{
    public function model()
    {
        return \App\Models\Category::class;
    }

    public function inHomePage()
    {
        return $this->model
            ->where('in_home_page', 1)
            ->get();
    }
}