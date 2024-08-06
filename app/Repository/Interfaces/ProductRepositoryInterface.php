<?php

namespace App\Repository\Interfaces;

use App\Repository\Interfaces\BaseRepositoryInterface;

interface ProductRepositoryInterface  extends BaseRepositoryInterface
{
    public function getPublishedProducts($productName);
    public function getPublishedProductsWithOrderBy(array $orderby,$limit);
    public function getDeletedProducts($limit);
    public function  restoreProductById($id);
    public function  getDraftProductList($limit);
    public function  getProductsByCategoryId($cid,$currentProductId);
    public function searchProductByName ($name,$limit);
}