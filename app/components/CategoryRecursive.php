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
    function categoryRecursive($parent_id_select,$id=0,$space = ''){
        // get all children của id
               $categories=$this->model->where("category_parent_id",$id)->get();
               foreach($categories as $category){
                    if($category["id"]===$parent_id_select){
                        $this->html .=  "<option selected value=\"{$category['id']}\">".$space. $category['category_name'] ."</option>" ;
                    }else{
                        $this->html.=  "<option value=\"{$category['id']}\">".$space. $category['category_name'] ."</option>" ;
                    }
                $this->categoryRecursive($parent_id_select,$category['id'],$space."--"); 
               }
               return $this->html;
               
    }


};

 