<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Traits\Image;
use App\Classes\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoUploadController extends Controller
{

    use Image;

    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image'
        ]);

        try {
            $name = Str::random(32);
            $encode = $request->file('image')->getClientOriginalExtension();
            $image = $this->storeImage($request->file('image'), 'general', null, $name, $encode);
            $url = url('assets/images/general/' . $name . '.jpg');

            return Response::success('', ['url' => $url]);
        } catch(Excpetion $e) {
            return Response::error('', 422);
        }


    }
}
