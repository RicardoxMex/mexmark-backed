<?php

namespace Modules\Categories\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;
    protected $fillable = [
        'name',
        'slug',
    ];
}
