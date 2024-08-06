<?php

namespace App\Repository\Repositories;
use App\Models\product;
use App\Repository\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    protected $product;
    public function __construct(product $product)
    {
        $this->product = $product;
    }
    public function getAllWithPaginate($limit)
    {
        return $this->product->latest()->paginate($limit);
    }
    public function getAll() { }
    public function getDeletedProducts($limit){
        return $this->product::onlyTrashed()
        ->orderBy('created_at', 'desc') // Use 'created_at' or any other column you want to order by
        ->paginate($limit);
    }
    public function getPublishedProducts($productName = null)
    {
        $productsQuery = $this->product->where([
            ['product_isPublished', 1],
            ['product_isDraft', 0]
        ]);
        if (!empty($productName)) {
            $productsQuery = $productsQuery->where('product_name', 'like', "%{$productName}%");
        }
        return $productsQuery->latest()->paginate(5);
    }
    public function create( $data)
    {
        return $this->product->create($data);
    }

    public function findByIdAndUpdate($id,  $data, $options = [])
    {
        $product = $this->product->findOrFail($id);
        $product->update($data);
        return $product;
    }
    public function findById($id, $options = null)
    {
        return $this->product->find($id);
    }

    public function findByIdAndDelete($id)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();
        return $product;
    }
    public function restoreProductById($id)
    {
        try {
            // Find the soft-deleted product by ID
            $product = $this->product->withTrashed()->findOrFail($id);
            // Restore the product
            $product->restore();
            return ['code' => 200, 'message' => 'Khôi phục thành công!'];
        } catch (ModelNotFoundException $e) {
            return ['code' => 404, 'message' => 'Sản phẩm không tồn tại'];
        } catch (\Exception $e) {
            return ['code' => 500, 'message' => 'Đã xảy ra lỗi'];
        }
    }
    public function getDraftProductList($limit){
        return $this->product
        ->where([
            ['product_isDraft', 1],
            ['product_isPublished', 0],
        ])
        ->latest()
        ->paginate($limit);
    }

    public function getProductsByCategoryId($cid,$currentProductId){
      return  $this->product
       ->where('product_isPublished', true)
        ->where('product_category_id', $cid)
        ->where('id', '!=', $currentProductId)
        ->get();
    }
    public function searchProductByName($name,$limit){
        return$this->product->where('product_name', 'like', '%' . $name . '%')
        ->orWhere('product_description', 'like', '%' . $name . '%')
        ->latest()->paginate($limit);
      }

      public function getPublishedProductsWithOrderBy(array $orderby, $limit)
      {
          $query = $this->product->where('product_isPublished', true);
  
          foreach ($orderby as $column => $direction) {
              $query->orderBy($column, $direction);
          }
  
          return $query->limit($limit)->get();
      }
}