<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

trait Image
{
    public function storeImage($image, $dir, $size = null, $name = null, $encode = 'jpg')
    {
        $id = $name ?? Str::random(5);
        $img = InterventionImage::make($image);

        if ($size <> null) {
            $height = null;
            if (is_array($size)) {
                $width = $size[0];
                if (count($size) == 2) {
                    $height = $size[1];
                }
            } else {
                $width = $size;
            }

            $img->resize($width, $height, function ($constraint) use ($width, $height) {
                if (is_null($height)) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            });
        }

        $img->encode($encode)->save(
            public_path() . '/assets/images/' . $dir . '/' . $id . '.' . $encode
        );

        return $id;
    }

    public function deleteImage($path, $image)
    {
        File::delete(public_path() . '/assets/images/' . $path . '/' . $image . '.jpg');
    }


    /**
     * Needs to go to a separate file
     */

    public function storeFile($file, $dir)
    {
        $filename = md5(generateRandomCharacters(5)) . '.' . $file->getClientOriginalExtension();
        Storage::disk('public_files')->PutFileAs($dir, $file, $filename);

        return $filename;
    }

    public function deleteFile($file)
    {
        return Storage::disk('public_files')->delete($file);
    }
}