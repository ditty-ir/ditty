<?php

namespace App\Widgets\GroupPosts;

use App\Classes\Response;
use Illuminate\Http\Request;
use Arrilot\Widgets\AbstractWidget;
use App\Repositories\PostsRepository;
use Illuminate\Support\Facades\Validator;

class GroupPosts extends AbstractWidget
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
    public function run()
    {
        //

        return view('widgets.group_posts.group_posts', [
            'config' => $this->config,
        ]);
    }

    public function index()
    {
        return Response::success('', GroupPost::all());
    }

    public function posts(PostsRepository $posts)
    {
        $groups = GroupPost::all();
        $output = [];

        foreach ($groups as $group) {
            if ($group->type == 'tag') {
                $items = $posts->getByTag($group->value, 10, 3, false);
                if ($items->count() > 0) {
                    $output[$group->title] = $items;
                }
            } else if ($group->type == 'category') {
                $items = $posts->getByCategoryId($group->value, 10, 3, false);
                if ($items->count() > 0) {
                    $output[$group->title] = $items;
                }
            }
        }

        return Response::success('', $output);
    }

    private function validate($request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:category,tag',
            'value' => 'required',
        ])->validate();
    }

    public function store(Request $request)
    {
        $this->validate($request);

        $group = GroupPost::create(
            $request->only(['title', 'type', 'value'])
        );

        return Response::success('', $group);
    }


    public function update(Request $request, GroupPost $groupPost)
    {
        $this->validate($request);

        $groupPost->update($request->only(['title', 'type', 'value']));
        $groupPost->save();

        return Response::success('', $groupPost);
    }

    public function destroy(GroupPost $groupPost)
    {
        $groupPost->delete();

        return Response::success('', $groupPost);
    }
}
