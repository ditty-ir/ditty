<?php
namespace App\Repositories;

class Pages extends Repository
{
    public function model()
    {
        return \App\Models\Page::class;
    }

    public function existsByPath($path)
    {
        return $this->model
            ->where('path', $path)
            ->limit(1)
            ->exists();
    }

    public function getByPath($path)
    {
        return $this->model
            ->where('path', $path)
            ->first();
    }
}