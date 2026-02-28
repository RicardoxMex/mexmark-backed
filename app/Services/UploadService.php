<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function upload(UploadedFile $file, string $folder, string $disk = 'public'): string
    {
        \Log::info('UploadService::upload called', [
            'folder' => $folder,
            'disk' => $disk,
            'original_name' => $file->getClientOriginalName(),
            'temp_path' => $file->getRealPath(),
            'is_valid' => $file->isValid(),
            'error' => $file->getError(),
        ]);
        
        $filename = md5(time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        
        \Log::info('Attempting to store file', [
            'filename' => $filename,
            'folder' => $folder,
            'disk' => $disk,
            'disk_root' => config("filesystems.disks.{$disk}.root"),
        ]);
        
        $path = $file->storeAs($folder, $filename, $disk);
        
        \Log::info('File stored successfully', ['path' => $path]);
        
        return $path;
    }

    public static function delete(string $path, $disk = 'public'): bool
    {
        if (!Storage::disk($disk)->exists($path)) {
            return false;
        }

        return Storage::disk($disk)->delete($path);
    }

    public static function url(string $path, $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }
}