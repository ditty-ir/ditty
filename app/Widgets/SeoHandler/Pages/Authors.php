<?php

namespace App\Widgets\SeoHandler\Pages;

class Authors
{

    public function get(array $parsedUri)
    {
        if (! empty($parsedUri[0])) {
            $users = app('users');
            $username = substr($parsedUri[0], 1);

            if ($user = $users->findByUsername($username)) {
                return $this->data($user);
            }
        }
    }


    private function data($user)
    {
        $data = [
            'title' => $user->name,
            'canonical' => $user->url,
            'meta' => [
                [
                    'attribute_title' => 'name',
                    'attribute_value' => 'description',
                    'content' => $user->biography,
                ],
                /* [
                    'attribute_title' => 'name',
                    'attribute_value' => 'author',
                    'content' => $post->user->name,
                ], */
                /* [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:type',
                    'content' => 'article',
                ], */
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:title',
                    'content' => $user->name,
                ],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:url',
                    'content' => $user->url,
                ],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:description',
                    'content' => $user->biography,
                ],
                [
                    'attribute_title' => 'name',
                    'attribute_value' => 'robots',
                    'content' => $user->isAuthor() ? 'index, follow' : 'noindex',
                ],
                /* [
                    'attribute_title' => 'name',
                    'attribute_value' => 'keywords',
                    'content' => implode(',', $post->tags),
                ], */
            ]
        ];

        if ($user->avatar) {
            array_push(
                $data['meta'],
                [
                    'attribute_title' => 'property',
                    'attribute_value' => 'og:image',
                    'content' => $user->avatar()
                ],
                [
                    'attribute_title' => 'itemprop',
                    'attribute_value' => 'image',
                    'content' => $user->avatar(),
                ]
            );
        }

        return $data;
    }

}