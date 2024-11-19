<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Product\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }

    public function index($id = '', $slug = ''){
        $product = $this->productService->show($id);
        $menu_id = $product->menu->id;
        $productMore = $this->productService->more($id,  $menu_id);
        return view('products.content',[
            'title' =>$product->name,
            'product' => $product,
            'products' => $productMore 
        ]);
    }
}
