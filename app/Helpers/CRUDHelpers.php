<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CRUDHelper
{
    public static function processAndStoreImage(UploadedFile $image, string $folder, string $imageType = "", ?string $oldImagePath = null): array
    {
        if ($oldImagePath && Storage::exists('public/' . $oldImagePath)) {
            Storage::delete('public/' . $oldImagePath);
        }

        $filename = Str::random(15) . strtotime(date('Y-m-d')) . '.' . $image->getClientOriginalExtension();
        $path = 'uploads/' . $folder . '/' . $filename;

        $fullStoragePath = storage_path('app/public/uploads/' . $folder);

        $folderPermission = 0777;
        $filePermission = 0644;

        if (!file_exists($fullStoragePath)) {
            Storage::makeDirectory('public/uploads/' . $folder);
            chmod($fullStoragePath, $folderPermission);
        }

        if ($image->getSize() > 4 * 1024 * 1024) {
            $img = Image::make($image->getRealPath());
            $img->resize(2000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $fullPath = storage_path('app/public/' . $path);
            $img->save($fullPath, 80);
        } else {
            $image->storeAs('public/uploads/' . $folder, $filename);
            $fullPath = storage_path('app/public/' . $path);
        }

        chmod($fullPath, $filePermission);

        return [
            'image_type' => $imageType,
            'image_path' => $path,
            'original_name' => $image->getClientOriginalName()
        ];
    }

    public static function deleteOldFile(string $oldFilePath): void
    {
        if ($oldFilePath) {
            Storage::delete('public/' . $oldFilePath);
        }
    }

    public static function processAndStoreFormImage(UploadedFile $form, string $folder, string $formType, string $userName, ?string $oldFormPath = null): array
    {
        if ($oldFormPath && Storage::exists('public/' . $oldFormPath)) {
            Storage::delete('public/' . $oldFormPath);
        }

        $author = empty($userName) ? Auth::user() : $userName;

        $filename = Str::slug($formType . '_' . $author . '_' . getFlatpickrDate(date('Y-m-d')) . '-' . date('H:i:s') . rand(1, 10));
        $originalExtension = $form->getClientOriginalExtension();

        Storage::makeDirectory('public/uploads/' . $folder);
        chmod(storage_path('app/public/uploads/' . $folder), 0777);
        
        $filename .= '.pdf';
        $path = 'uploads/' . $folder . '/' . $filename;
        
        if (strtolower($originalExtension) == 'pdf') {
            Storage::putFileAs('public/uploads/' . $folder, $form, $filename);
        } else {
            $img = Image::make($form->getRealPath());
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $imageData = $img->encode('jpg', 80)->encoded;
            $base64Image = base64_encode($imageData);

            $html = '<img src="data:image/jpeg;base64,' . $base64Image . '" style="width: 100%;">';

            $pdf = Pdf::loadHtml($html);
            $pdf->setPaper('A4', 'portrait');

            Storage::put('public/' . $path, $pdf->output());
        }

        if(chmod(storage_path('app/public/' . $path), 0777)) {
            $msg = 'chmod success';
        } else {
            $msg = 'chmod failed';
        }
        

        return [
            'form_type' => $formType,
            'form_path' => $path,
            'msg' => $msg
        ];
    }
}
