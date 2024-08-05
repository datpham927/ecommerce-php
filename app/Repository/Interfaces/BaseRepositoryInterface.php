<?php

namespace App\Repository\Interfaces;


interface BaseRepositoryInterface
{
    function getAll();
    function getAllWithPaginate($options);
    function create($data);
    function findByIdAndUpdate($id, $data, $options = []);
    function findById($id,$option = null);
    function findByIdAndDelete($id);
}