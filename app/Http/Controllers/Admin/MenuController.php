<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Menu\MenuService;
use App\Http\Requests\Menu\CreateFromRequest;
use Illuminate\Foundation\Http\FormRequest;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function create()
    {
        return view('admin.menu.add', [
            'title' => 'Thêm danh mục',
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(CreateFromRequest $request)
    {
        $this->menuService->create($request);

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.menu.list', [
            'title' => 'Thêm danh mục',
            'menus' => $this->menuService->getAll()
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $result = $this->menuService->destroy($request);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => ' Xóa thành công danh mục'
            ]);
        } else {
            return response()->json([
                'error' => true
            ]);
        }
    }

    public function show(Menu $menu) // tự động kiểm tra id có tồn tại ko?
    {
        return view('admin.menu.edit', [
            'title' => 'Chỉnh sửa danh mục ' . $menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function update(Menu $menu, CreateFromRequest $request) // tự động kiểm tra id có tồn tại ko?
    {
        $this->menuService->update($request, $menu);

        return redirect('/admin/menus/list');
    }
}
