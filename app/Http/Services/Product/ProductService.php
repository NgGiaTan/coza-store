<?php
namespace App\Http\Services\Product;

use App\Models\Product;

class ProductService {
    const  LIMIT = 8;
    public function show($id){
        return Product::where('id', $id)
        ->where('active', 1)->with('menu')->firstOrFail();
    }
    //Lấy sản phẩm cùng danh mục(menu_id)
    public function more($id, $menu_id){
        return Product::select('id', 'name','price','price_sale','thumb')
        ->where('active', 1)
        ->where('id', '!=', $id)
        ->where('menu_id', '=', $menu_id)
        ->limit(4)
        ->get();
    }

    public function get($page = null)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
        ->where('active', 1)
            ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
    }
}