<?php

namespace App\Traits;

use Illuminate\Support\Str;


trait HasSlug
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    public static function bootHasSlug(): void
    {
        static::saving(function ($model) {
            if ($model->title) {
                $model->slug = Str::slug($model->title);
            } elseif ($model->name) {
                $model->slug = Str::slug($model->name);
            }

            // Generar un slug único considerando también registros con soft delete
            $originalSlug = $model->slug;
            $count = 2;

            if (method_exists(static::class, 'withTrashed')) {
                while (
                    static::withTrashed()
                        ->where('slug', $model->slug)
                        ->where('id', '!=', $model->id)
                        ->exists()
                ) {
                    $model->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }else{
                while (
                    static::query()
                        ->where('slug', $model->slug)
                        ->where('id', '!=', $model->id)
                        ->exists()
                ) {
                    $model->slug = "{$originalSlug}-{$count}";
                    $count++;
                }

            }

        });
    }

}