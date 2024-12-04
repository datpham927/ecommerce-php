<?php

namespace App\Http\Controllers;

use App\Models\attribute;
use App\Models\Category;
use App\Models\Images;
use App\Models\product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\HttpClientKernel;
use Illuminate\Support\Str;

class CrawlerControllers extends Controller
{
    
     // -------------- lấy link danh mục
    //    public function crawler(){
    //         $url='https://juno.vn/products/dam-mini-sat-nach-cai-hoa-tra';
    //         $html=file_get_contents($url);  
    //         echo $html; die();
    //         $crawler=new Crawler( $html);
    //         $categorys=$crawler->filter('.DMfHy');
    //        dd("cout",count($categorys));
    //         $items = [];
    //         if (count($categorys)) {
    //             foreach ($categorys as $category) {
    //                 $newCrawler=new Crawler( $category);
    //                 $items[] = [
    //                     'title' => $newCrawler->filter('.styles__TreeName-sc-1uq9a9i-3')->text(),
    //                     'link' => "https://tiki.vn" .$newCrawler->filter('a')->attr('href')
    //                 ];
    //             }
    //         }
    //         dd($items);  
    //    }
   public  $categoryLinks = [
        [
            'url' => 'https://juno.vn/collections/dam-va-jumpsuit?itm_source=homepage&itm_medium=sbmenu&itm_campaign=quanao&itm_content=dam',
            'name' => 'Đầm và Jumpsuit',
            'description' => 'Danh mục chứa các sản phẩm đầm và jumpsuit'
        ],
        [
            'url' => 'https://juno.vn/collections/ao?itm_source=homepage&itm_medium=sbmenu&itm_campaign=quanao&itm_content=ao',
            'name' => 'Áo',
            'description' => 'Danh mục chứa các sản phẩm áo'
        ],
        [
            'url' => 'https://juno.vn/collections/quan?itm_source=homepage&itm_medium=sbmenu&itm_campaign=quanao&itm_content=quan',
            'name' => 'Quần',
            'description' => 'Danh mục chứa các sản phẩm quần'
        ],
        [
            'url' => 'https://juno.vn/collections/vay?itm_source=homepage&itm_medium=sbmenu&itm_campaign=quanao&itm_content=vay',
            'name' => 'Váy',
            'description' => 'Danh mục chứa các sản phẩm váy'
        ],
        [
            'url' => 'https://juno.vn/collections/khoac?itm_source=homepage&itm_medium=sbmenu&itm_campaign=quanao&itm_content=khoac',
            'name' => 'Áo khoác',
            'description' => 'Danh mục chứa các sản phẩm áo khoác'
        ]
    ];
    
   
    public function crawler(){
        set_time_limit(20000);
        foreach ($this->categoryLinks as $categoryLink) {
            $category = Category::create([
                'category_name' => $categoryLink["name"],
                'category_description' => $categoryLink["description"],
                'category_slug' => Str::of($categoryLink["name"])->slug('-')
            ]);
            $this->crawlerListProduct($categoryLink['url'], $category->id);
        }
    }
    // -- danh sach link sản phẩm
    public function crawlerListProduct($categoryUrl,$categoryId){
        $html=file_get_contents($categoryUrl);   
        $crawler=new Crawler( $html);
        $products=$crawler->filter('.product-block');
        // dd($products->text());
        // dd("cout",count($products));
        $productLinks = [];
        if (count($products)) {
            foreach ($products as $product) {
                $newCrawler=new Crawler( $product);
                $productLinks[] = [
                    'link' => "https://juno.vn" .$newCrawler->filter("a")->attr('href'),
                   'product_thumb' => "https:" . $newCrawler->filter("picture > img.img-loop")->attr('data-src'),

                ];
            }
        } 
        foreach ($productLinks as $productLink) {
            $this->crawlerDetail($productLink['link'],$productLink['product_thumb'],$categoryId);
      }
    }
    // -- lấy chi tiết sản phẩm
    public function crawlerDetail($productLink,$productThumb,$categoryId){
        // $productLink $brand_id  $categoryId  
        $html=file_get_contents($productLink);   
        $crawler=new Crawler( $html);
         // -------------  image  ------------- 
         $dataImages = [];
         $images = $crawler->filter(".removeImgMobile");
         // dd("cout",count($images));
         if ($images->count()) {
             $images->each(function (Crawler $node) use (&$dataImages) {
                 $dataImages[] = [
                     'src' =>"https:". $node->attr('src')
                 ];
             });
         } 
          // -------------  size  ------------- 
          $dataSizes = [];
          $sizes = $crawler->filter(".Size");
          // Thu thập dữ liệu kích thước
          if ($sizes->count()) {
              $sizes->each(function (Crawler $node) use (&$dataSizes) {
                  $dataSizes[] = [
                      'size_name' =>  $node->filter("span")->text()
                  ];
              });
          }
          // Loại bỏ các phần tử trùng lặp
          $uniqueSizeNames = array_unique(array_column($dataSizes, 'size_name'));
          // Tạo mảng mới chứa thông tin kích thước và số lượng sản phẩm
          $newSizes = [];
          $productStock=0; // số lượng sản phẩm
          foreach ($uniqueSizeNames as $sizeName) {
              $productQuantity = rand(1, 100); // Số lượng sản phẩm ngẫu nhiên
              $productStock+= $productQuantity;
              $newSizes[] = [
                  'size_name' => $sizeName,
                  'size_product_quantity' => $productQuantity
              ];
          }
          // Kiểm tra kết quả
        //   dd($newSizes);
          // -------------  attribute  -------------  
          $attributes = $crawler->filter("#2b > .main_details div ul li ");
        //   dd("count",count($attributes));
          // Kiểm tra số lượng phần tử
          $dataAttributes = [];
          if ($attributes->count()) {
              $attributes->each(function (Crawler $node) use (&$dataAttributes) {
                if( count($node->filter(".infobe"))){
                    $dataAttributes[] = [
                        'attribute_name' =>  $node->filter(".infobe")->text(),
                        'attribute_description' =>  $node->filter(".infoaf")->text()
                    ];
                }
              });
          }
        // -------------  product ------------- 
        $dataProduct=[];
        $pid = Str::uuid(); // Generate a UUID
        $dataProduct['id']=$pid ;
        $dataProduct["product_name"]= $crawler->filter(".product-title h1")->text();
        $dataProduct["product_slug"]=  Str::of($crawler->filter(".product-title h1")->text())->slug('-');
        $dataProduct["product_brand_id"]= rand(1, 10);
        $dataProduct["product_category_id"]= $categoryId;
        $dataProduct["product_description"] = $crawler->filter(".description-productdetail")->html();
        $dataProduct["product_discount"]= rand(5, 20);
        $dataProduct["product_thumb"]=$productThumb;
        $dataProduct["product_price"]=intval(preg_replace('/[^\d]/', '', $crawler->filter(".pro-price")->text()));
        $dataProduct["product_origin_price"]=intval(preg_replace('/[^\d]/', '', $crawler->filter(".pro-price")->text()))-20000;
        $dataProduct["product_stock"]= $productStock;
         try {
            DB::beginTransaction();
             //  ---------------   insert product   ---------------
                $product =product::create($dataProduct);
                //  ---------------   insert images   ---------------
                foreach ($dataImages as $image) {
                    Images::create([
                        "image_name"=> "link",
                        "image_url"=> $image["src"],
                        "image_product_id"=>$pid
                    ]);
                }
                //   ---------------   insert attribute   ---------------
                foreach ($dataAttributes as $attribute) {
                    attribute::create([
                        "attribute_product_id"=>$pid ,
                        'attribute_name' =>  $attribute['attribute_name'],
                        'attribute_description' =>  $attribute['attribute_description']
                    ]);
                }
            //   ---------------   insert attribute   ---------------
            foreach ($newSizes as $size) {
                 Size::create([
                    "size_product_id"=>$pid ,
                    'size_name' => $size['size_name'],
                    'size_product_quantity' => $size['size_product_quantity']
                ]);
            }
            DB::commit();
         } catch (\Throwable $th) {
            DB::rollBack(); //khôi phục giao dịch (không lưu)
            dd($ $th->getMessage());
         }
        // dd($newSizes);
        // dd($dataImages);
        // dd($dataAttribute);
        // dd($dataProduct);
    }
}