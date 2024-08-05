<?php

namespace App\Repository\Repositories;

use App\Models\Brand;
use App\Repository\Interfaces\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    protected $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getAllWithPaginate($limit)
    {
        return $this->brand->latest()->paginate($limit);
    }

    public function getAll()
    {
        return $this->brand->all();
    }

    public function create( $data)
    {
        return $this->brand->create($data);
    }

    public function findByIdAndUpdate($id,  $data, $options = [])
    {
        $brand = $this->brand->findOrFail($id);
        $brand->update($data);
        return $brand;
    }

    public function findById($id, $options = null)
    {
        return $this->brand->find($id);
    }

    public function findByIdAndDelete($id)
    {
        $brand = $this->brand->findOrFail($id);
        $brand->delete();
        return $brand;
    }
}
