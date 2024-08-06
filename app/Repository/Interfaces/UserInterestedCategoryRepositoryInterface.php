<?php

namespace App\Repository\Interfaces; 

interface UserInterestedCategoryRepositoryInterface 
{
    function createOrUpdateViews($pid,$userId);
    public function getUserInterestedCategoryByUserId($uid);

}