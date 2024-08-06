<?php

namespace App\Repository\Repositories;

use App\Models\Category;
use App\Models\user_interested_category;
use App\Repository\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $Category;

    public function __construct(Category $Category)
    {
        $this->Category = $Category;
    }

    public function getAllWithPaginate($limit)
    {
        return $this->Category->latest()->paginate($limit);
    }

    public function getAll()
    {
        return $this->Category->all();
    }

    public function create( $data)
    {
        return $this->Category->create($data);
    }

    public function findByIdAndUpdate($id,  $data, $options = [])
    {
        $Category = $this->Category->findOrFail($id);
        $Category->update($data);
        return $Category;
    }

    public function findById($id, $options = null)
    {
        return $this->Category->find($id);
    }

    public function findByIdAndDelete($id)
    {
        $Category = $this->Category->findOrFail($id);
        $Category->delete();
        return $Category;
    }
   
    }        