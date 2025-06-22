<?php

function uploadImage($file, $folder = 'uploads', $prefix = 'img_')
{
    if (!$file || !$file->isValid()) {
        return null;
    }

    $extension = $file->getClientOriginalExtension();
    $filename  = $prefix . time() . '.' . $extension;
    $publicPath = public_path('uploads/' . $folder);
    if (!file_exists($publicPath)) {
        mkdir($publicPath, 0777, true);
    }
    $file->move($publicPath, $filename);
    return 'uploads/' . $folder . '/' . $filename;
}
function updateImage($newFile, $oldPath = null, $folder = 'uploads', $prefix = 'img_')
{
    if (!$newFile || !$newFile->isValid()) {
        return $oldPath;
    }

    if ($oldPath && file_exists(public_path($oldPath))) {
        @unlink(public_path($oldPath));
    }
    return uploadImage($newFile, $folder, $prefix);
}
