<?php

namespace App\Traits;

trait FileUploadTrait
{
    public function uploadFile($file, $folder = null)
    {
        $file_name = time().uniqid(rand()).'.'.$file->getClientOriginalExtension();
        $file->move(storage_path('app/public/uploads') . '/' . $folder, $file_name);

        return $file_name;
    }
}
