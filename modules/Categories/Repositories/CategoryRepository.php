<?php

namespace Modules\Categories\Repositories;

use Modules\Categories\Interfaces\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function list(string $search, int $perPage, bool $paginate = true)
    {
        $query = Category::query();
        
        if ($search !== '') {
            $query->search($search);
        }

        return $paginate
            ? $query->latest()->paginate($perPage)
            : $query->latest()->get();
    }

    public function find(Category $category)
    {
        
        
        return $category;
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(array $data, Category $category)
    {
        $category->update($data);
        return $category->fresh();
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}