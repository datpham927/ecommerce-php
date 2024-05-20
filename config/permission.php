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
     // ---------------
     'list-slider'=>'list_slider',
     'add-slider'=>'add_slider',
     'edit-slider'=>'edit_slider',
     'delete-slider'=>'delete_slider',
 // ---------------
      'list-staff' => 'list_staff',
      'add-staff' => 'add_staff',
      'edit-staff' => 'edit_staff',
      'delete-staff' => 'delete_staff',
      // ---------------

      'list-customer' => 'list_customer',
      'add-customer' => 'add_customer',
      'edit-customer' => 'edit_customer',
      'delete-customer' => 'delete_customer',
      // ---------------

      'list-role' => 'list_role',
      'add-role' => 'add_role',
      'edit-role' => 'edit_role',
      'delete-role' => 'delete_role',
      // --------------- 

      'list-brand' => 'list_brand',
      'add-brand' => 'add_brand',
      'edit-brand' => 'edit_brand',
      'delete-brand' => 'delete_brand',
      // ---------------

      'list-order' => 'list_order',
      'add-order' => 'add_order',
      'edit-order' => 'edit_order',
      'delete-order' => 'delete_order',


   ],
   "table_module"=>[
      "category",
      "customer",
      "setting",
      "product",
      "slider", 
      "order",
      "staff", 
      "role",
   ],
   "module_children"=>[
      "list",'add','edit',"delete"
   ]

];