<?php

namespace App\Repository\Interfaces\ProductRepositoryInterface;

use App\Repository\Interfaces\BaseRepositoryInterface;

interface ProductRepositoryInterface  extends BaseRepositoryInterface
{
    public function getPublishedProducts($productName);
    public function getDeletedProducts($limit);
    public function  restoreProductById($id);
    public function  getDraftProductList($limit);
}