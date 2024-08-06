<?php

namespace App\Repository\Repositories;
use App\Models\Slider;
use App\Repository\Interfaces\SliderRepositoryInterface;

class SliderRepository implements SliderRepositoryInterface
{
    protected $role;
    public function __construct(Slider $role)
    {
        $this->role = $role;
    }
    public function getAllWithPaginate($limit)
    {
        return $this->role->latest()->paginate($limit);
    }

    public function getAll()
    {
        return $this->role->all();
    }

    public function create( $data)
    {
        return $this->role->create($data);
    }

    public function findByIdAndUpdate($id,  $data, $options = [])
    {
        $slider =  $this->role->find($id);
        $slider->update($data);
        return $slider;
    }

    public function findById($id, $options = null)
    {
        return $this->role->find($id);
    }

    public function findByIdAndDelete($id)
    {
        $slider = $this->role->findOrFail($id);
        $slider->delete();
        return $slider;
    }
    
}
