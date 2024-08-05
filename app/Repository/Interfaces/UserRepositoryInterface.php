<?php

namespace App\Repository\Interfaces;
use App\Repository\Interfaces\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    function findUserByName($userName,$limit);
    function findCustomer($limit);
    function findAdmin($limit);
    function findByIdAndDeleteStaff($limit);
}