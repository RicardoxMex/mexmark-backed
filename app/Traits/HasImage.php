<?php
namespace App\Traits;

use App\Services\UploadService;
trait HasImage
{
    public function getImage()
    {
        return $this->image ? UploadService::url($this->image) : null;
    }
}
