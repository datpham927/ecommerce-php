<?php
namespace App\Components;

use App\Models\Category;

class CategoryRecursive{
    private $html,$model;
    function __construct($model)
    {
        $this->html='';
        $this->model=$model;
    }
    // function categoryRecursive($parent_id_select, $id = 0, $space = "") {
    //     // Get all children of the current id
    //     $categories = $this->model->where("category_parent_id", $id)->get();
    
    //     foreach ($categories as $category) {
    //         $selected = ($category["id"] === $parent_id_select) ? "selected" : "";
    //         $this->html .= "<option {$selected} value=\"{$category['id']}\">{$space}{$category['category_name']}</option>";
    //         // Recursive call for child categories
    //         $this->categoryRecursive($parent_id_select, $category['id'], "--{$space}");
    //     }
    
    //     return $this->html;
    // }
    


};

 