<?php

namespace App\Repository\Repositories;
use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function getAllWithPaginate($limit)
    {
        return $this->user->latest()->paginate($limit);
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function create( $data)
    {
        return $this->user->create($data);
    }

    public function findByIdAndUpdate($id,  $data, $options = [])
    {
        $User = $this->user->findOrFail($id);
        $User->update($data);
        return $User;
    }

    public function findById($id, $options = null)
    {
        return $this->user->find($id);
    }

    public function findByIdAndDelete($id)
    {
        $User = $this->user->findOrFail($id);
        $User->delete();
        return $User;
    }
    public function findUserByName($userName,$limit)
    {
        return $this->user->where('user_name', 'like', "%{$userName}%")->paginate($limit);
    }
    public function findCustomer($limit)
    {
        return $this->user->where('user_type','customer')->paginate($limit);
    }
    public function findAdmin($limit)
    {
        return $this->user::whereIn('user_type', ['employee', 'admin'])->latest()->paginate($limit);
    }
    public function findByIdAndDeleteStaff($id)
    {
        $staff=$this->user->find($id);
        $staff->roles()->detach();
        $staff->delete();
        return $staff;
    }
}
