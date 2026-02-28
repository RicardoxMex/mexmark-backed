<?php

namespace Modules\Categories\Interfaces;

use Modules\Categories\Models\Category;

interface CategoryServiceInterface
{
    public function getAllCategories(string $search, int $perPage, bool $paginate = true);
    
    public function getCategoryById(Category $category);
    
    public function createCategory(array $data);
    
    public function updateCategory(array $data, Category $category);
    
    public function deleteCategory(Category $category);
}
