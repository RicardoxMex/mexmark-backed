<?php

namespace Modules\Categories\Services;

use App\Traits\HandlesFileUploads;
use Modules\Categories\Interfaces\CategoryServiceInterface;
use Modules\Categories\Interfaces\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;

class CategoryService implements CategoryServiceInterface
{
    use HandlesFileUploads;

    public function __construct(
        protected readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function getAllCategories(string $search, int $perPage, bool $paginate = true)
    {
        return $this->categoryRepository->list($search, $perPage, $paginate);
    }

    public function getCategoryById(Category $category)
    {
        return $this->categoryRepository->find($category);
    }

    public function createCategory(array $data)
    {
        \Log::info('Creating category - BEFORE handleFileUploads', ['data' => $data]);
        $data = $this->handleFileUploads($data, null, 'category');
        \Log::info('Creating category - AFTER handleFileUploads', ['data' => $data]);
        $result = $this->categoryRepository->create($data);
        \Log::info('Category created', ['result' => $result]);
        return $result;
    }

    public function updateCategory(array $data, Category $category)
    {
        \Log::info('Updating category', ['category_id' => $category->id, 'data' => $data]);
        $data = $this->handleFileUploads($data, $category, 'category');
        return $this->categoryRepository->update($data, $category);
    }

    public function deleteCategory(Category $category)
    {
        $this->deleteModelFiles($category);
        return $this->categoryRepository->delete($category);
    }
}
