<?php

namespace App\Widgets\SeoHandler\Pages;

class Home
{

    public function get(array $parsedUri)
    {
        return $this->data();
    }


    private function data()
    {
        return [
            'title' => config('app.title'),
            'canonical' => url('/'),
            'meta' => [
                [
                    'attribute_title' => 'name',
                    'attribute_value' => 'description',
                    'content' => config('app.description'),
                ],
                /* [
                    'attribute_title' => 'itemprop',
                    'attribute_value' => 'image',
                    'content' => url('/') . $post->cover_image,
                ], */
                /* [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:type',
                    'content' => 'article',
                ], */
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:title',
                    'content' => config('app.name'),
                ],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:url',
                    'content' => url('/'),
                ],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:description',
                    'content' => config('app.description'),
                ],
                /* [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:image',
                    'content' => url('/') . $post->cover_image,
                ], */
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
    }
}