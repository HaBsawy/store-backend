<?php


namespace App\Repository\Category;


use App\Models\Category;

class CategoryEloquent implements CategoryInterface
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return auth()->user()->categories;
    }

    public function store(array $data)
    {
        return $this->category->create([
            'user_id'   => auth()->user()->id,
            'name'      => $data['name'],
        ]);
    }

    public function update($id, array $data)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return null;
        }

        $category->name = $data['name'];
        $category->save();

        return $category;
    }

    public function delete($id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return null;
        }
        return $category->delete() ? true : false;
    }
}
