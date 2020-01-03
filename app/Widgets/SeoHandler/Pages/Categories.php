<?php

namespace App\Widgets\SeoHandler\Pages;

use App\Repositories\CategoriesRepository;

class Categories
{

    public function get(array $parsedUri)
    {
        if (!empty($parsedUri[1]) && is_numeric($parsedUri[1])) {
            $category_id = $parsedUri[1];
            $categories = app(CategoriesRepository::class);
            $category = $categories->find($category_id);

            if (! empty($category)) {
                return $this->data($category);
            }
        }
    }


    private function data($category)
    {
        $data = [
            'title' => $category->title,
            'canonical' => url('categories', $category->id),
            'meta' => [
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:title',
                    'content' => $category->title,
                ],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:url',
                    'content' => $category->url,
                ],
                [
                    'attribute_title' => 'name',
                    'attribute_value' => 'robots',
                    'content' => 'index, follow',
                ],
                /* [
                    'attribute_title' => 'name',
                    'attribute_value' => 'keywords',
                    'content' => implode(',', $post->tags),
                ], */
            ]
        ];

        if ($category->image) {
            array_push(
                $data['meta'],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:image',
                    'content' => $category->image
                ],
                [
                    'attribute_title' => 'itemprop',
                    'attribute_value' => 'image',
                    'content' => $category->image
                ]
            );
        }

        return $data;
    }

}