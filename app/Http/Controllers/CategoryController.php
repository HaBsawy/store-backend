<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Repository\Category\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->index();

        return JsonResponder::make($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->category->store($request->all());

        return JsonResponder::make($category, true, 201, 'category is created successfully');
    }

    public function update($id, StoreCategoryRequest $request)
    {
        $category = $this->category->update($id, $request->all());

        return $category ?
            JsonResponder::make($category, true, 202, 'category is updated successfully'):
            JsonResponder::make(null, false, 404, 'category not found');
    }

    public function delete($id)
    {
        $delete = $this->category->delete($id);

        return $delete ?
            JsonResponder::make(null, true, 202, 'category is deleted successfully'):
            JsonResponder::make(null, false, 404, 'category not found');
    }
}
