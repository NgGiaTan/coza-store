<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productAdminService)
    {
        $this->productService = $productAdminService;
    }






    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.list',[
            'title' => 'Danh sách Sản Phẩm',
            'products' => $this->productService->get() 
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuService = new MenuService;
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm',
            'menus' => $this->productService->getMenu()
            //'menus' => $menuService->getAll()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {   
        $this->productService->insert($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.edit',[
            'title' => "Chỉnh sửa sản phẩm",
            'product' => $product,
            'menus' => $this->productService->getMenu()

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $res = $this->productService->update($request, $product);
        if($res){
            return redirect('/admin/products/list');
        } return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = $this->productService->delete($request);
        if(!$result){

            return response(['error' => true]);
        }
        
        return response()->json([
            'error' => false,
            'message' =>'Xóa thành công sản phẩm'
        ]);
        // error: false: Được trả về khi xóa thành công, không có lỗi.
        // error: true: Được trả về khi việc xóa thất bại, có lỗi xảy ra.
        // Như vậy, error là biểu tượng của việc có lỗi hay không, 
        // vì thế false cho biết không có lỗi và true cho biết có lỗi.
    }
}
