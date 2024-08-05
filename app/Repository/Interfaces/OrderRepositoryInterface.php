<?php

namespace App\Repository\Interfaces;

use App\Repository\Interfaces\BaseRepositoryInterface;

interface OrderRepositoryInterface  extends BaseRepositoryInterface
{
    public function findByCodeAndStatus($code, $status ,$date);
    public function filterByStatusAndDate($status, $date = null,$limit) ;
    public function  calculateProfitAndQuantity ($order);
    public function  findOrdersByUserIdAndStatus($userId, $statusKey);
}