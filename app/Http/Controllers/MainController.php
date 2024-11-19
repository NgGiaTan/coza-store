<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Product\ProductService;

class MainController extends Controller
{   
    protected $slider;
    protected $menu;
    protected $product;
    public function __construct(SliderService $sliderS, MenuService $menuS, ProductService $productS){
        $this->slider = $sliderS;
        $this->menu = $menuS;
        $this->product = $productS;
    }

    public function index()
    {
        return view('home', [
            'title' => 'Shop Nước Hoa T',
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get()
        ]);
    }

    // loadMore san pham o trang chu
    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);
        if (count($result) != 0) {
            $html = view('products.list', ['products' => $result ])->render();

            return response()->json([ 'html' => $html ]);
        }

        return response()->json(['html' => '' ]);
    }
}
