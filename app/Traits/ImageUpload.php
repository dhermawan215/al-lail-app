<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ImageUpload
{
    /**
     * @method store image logo
     * @return string path
     */
    public function storeImage($file, $folder = null, $fileName = null)
    {
        $newFileName = !is_null($fileName) ? $fileName : Str::random(10);
        $timeStamp = date('Ymdis');
        $pathFileName = $timeStamp . '-' . $newFileName . '.' . $file->getClientOriginalExtension();
        return $file->move($folder, $pathFileName);
    }
    /**
     * @method delete image logo
     * @param string path
     * @return bool
     */
    public function deleteImage($path)
    {
        if (file_exists($path)) {
            return unlink($path);
        }
        return \false;
    }
}
