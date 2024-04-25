<?php

return [
   'access'=>[
    'list-category'=>'list_category',
    'add-category'=>'add_category',
    'edit-category'=>'edit_category',
    'delete-category'=>'delete_category',
   // ---------------
    'list-product'=>'list_product',
    'add-product'=>'add_product',
    'edit-product'=>'edit_product',
    'delete-product'=>'delete_product',
   ],
   "table_module"=>[
      "category",
      "slider",
      "menu",
      "product",
      "setting",
      "user",
      "role"
   ],
   "module_children"=>[
      "list",'add','edit',"delete"
   ]

];