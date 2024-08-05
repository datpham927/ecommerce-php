<?php

namespace App\Repository\Repositories;

use App\Models\Role;
use App\Repository\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    protected $role;
    public function __construct(Role $role)
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
        $Role =  $this->role->where(["role_id"=>$id]);
        $Role->update($data);
        return $Role;
    }

    public function findById($id, $options = null)
    {
        return $this->role->where('role_id',$id)->first();
    }

    public function findByIdAndDelete($id)
    {
        $Role = $this->role->findOrFail($id);
        $Role->delete();
        return $Role;
    }
    
}
