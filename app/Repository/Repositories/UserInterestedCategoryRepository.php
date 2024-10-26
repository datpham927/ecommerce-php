<?php

namespace App\Repository\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\user_interested_category;
use App\Models\View;
use App\Repository\Interfaces\UserInterestedCategoryRepositoryInterface; 

class UserInterestedCategoryRepository implements UserInterestedCategoryRepositoryInterface
{
    protected $user_interested_category;
    public function __construct(user_interested_category $user_interested_category)
    {
        $this->user_interested_category = $user_interested_category;
    }
    public function createOrUpdateViews($cid, $userId)
    {
        // Sử dụng updateOrCreate để tìm bản ghi hoặc tạo mới nếu không tồn tại
        $this->user_interested_category->updateOrCreate(
            ['category_id' => $cid, 'user_id' => $userId],
            ['views' => DB::raw('views + 1')]
        );
    }
    public function getUserInterestedCategoryByUserId($uid)
    {
        // Kiểm tra nếu $uid có giá trị hợp lệ
        if (!$uid) { return null; }
        // Truy vấn và lấy category_id có số lượt xem cao nhất
        return user_interested_category::where('user_id', $uid)
        ->orderBy('views', 'desc')
            ->value('category_id'); // Lấy giá trị của cột category_id trực tiếp
}        
}