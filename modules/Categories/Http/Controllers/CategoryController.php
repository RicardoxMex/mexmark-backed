<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Categories\Http\Requests\CategoryStoreRequest;
use Modules\Categories\Http\Requests\CategoryUpdateRequest;
use Modules\Categories\Http\Resources\CategoryResource;
use Modules\Categories\Interfaces\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;

class CategoryController extends Controller
{
    public function __construct(protected readonly CategoryRepositoryInterface $categoryRepository)
    {
    }
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);
        $search = trim((string) ($request->query('search', $request->query('q', ''))));
        $paginate = $request->boolean('paginate', true);
        $categories = $this->categoryRepository->list($search, $perPage, $paginate);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
