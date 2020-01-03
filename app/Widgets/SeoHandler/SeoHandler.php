<?php

namespace App\Widgets\SeoHandler;

use App\Repositories\Pages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Arrilot\Widgets\AbstractWidget;

class SeoHandler extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(Request $request)
    {
        $validRoots = ['posts', 'categories'];

        if (! empty($path = $request->path())) {
            $parsedPath = explode('/', $path);
            $root = $parsedPath[0];

            if ($request->path() == '/') {
                $class = __NAMESPACE__ . "\Pages\Home";
            } else if (in_array($root, $validRoots)) {
                $class = __NAMESPACE__ . "\Pages\\" . Str::studly($root);
            } else if ($request->route()->parameter('username')) {
                $class = __NAMESPACE__ . "\Pages\Authors";
            } else if ($this->isPage($root)) {
                $class = __NAMESPACE__ . "\Pages\Posts";
            }

            if (isset($class)) {
                $seoItems = (new $class)->get($parsedPath);

                return view('widgets.seo_handler.seo_handler', [
                    'items' => $seoItems
                ]);
            }
        }

        return '';
    }

    private function isPage($path)
    {
        return app(Pages::class)->existsByPath($path);
    }
}
