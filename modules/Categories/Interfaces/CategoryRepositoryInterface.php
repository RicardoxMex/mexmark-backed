<?php

namespace Modules\Categories\Interfaces;
use Modules\Categories\Models\Category;
interface CategoryRepositoryInterface {
    
    public function list(string $search, int $perPage, bool $paginate = true);
    public function find(Category $category);
    public function create(array $data);
    public function update(array $data, Category $category);
    public function delete(Category $category);
}