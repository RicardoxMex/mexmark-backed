<?php

namespace App\Traits;

use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

trait HandlesFileUploads
{
    /**
     * Handle file uploads for the given data and model
     * 
     * @param array $data
     * @param Model|null $model
     * @param string $folder
     * @param array $fileFields Fields to check for uploads (default: ['image', 'file'])
     * @return array
     */
    protected function handleFileUploads(
        array $data, 
        ?Model $model = null, 
        string $folder = 'uploads',
        array $fileFields = ['image', 'file']
    ): array {
        foreach ($fileFields as $field) {
            if (isset($data[$field])) {
                \Log::info("Processing field: {$field}", [
                    'is_uploaded_file' => $data[$field] instanceof UploadedFile,
                    'type' => gettype($data[$field]),
                    'class' => is_object($data[$field]) ? get_class($data[$field]) : 'not an object'
                ]);
                
                if ($data[$field] instanceof UploadedFile) {
                    // Delete old file if updating
                    if ($model && $model->{$field}) {
                        UploadService::delete($model->{$field});
                    }
                    
                    // Upload new file
                    $uploadedPath = UploadService::upload($data[$field], $folder);
                    $data[$field] = $uploadedPath;
                    
                    \Log::info("File uploaded successfully", [
                        'field' => $field,
                        'path' => $uploadedPath
                    ]);
                } else {
                    \Log::warning("Field {$field} is not an UploadedFile instance");
                    unset($data[$field]); // Remove invalid file data
                }
            }
        }

        return $data;
    }

    /**
     * Delete files from model
     * 
     * @param Model $model
     * @param array $fileFields
     * @return void
     */
    protected function deleteModelFiles(Model $model, array $fileFields = ['image', 'file']): void
    {
        foreach ($fileFields as $field) {
            if ($model->{$field}) {
                UploadService::delete($model->{$field});
            }
        }
    }
}
