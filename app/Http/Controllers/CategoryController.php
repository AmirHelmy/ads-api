<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return CategoryResource::collection(
            $this->repository->all()
        );
    }

    public function store(CategoryRequest $request)
    {
        return new CategoryResource(
            $this->repository->create($request->validated())
        );
    }


    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        return new CategoryResource(
            $this->repository->update($category, $request->validated())
        );
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
