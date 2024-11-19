<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Session;

class MenuService{

    public function getParent(){
        return Menu::where('parent_id', 0)->get();

    }

    public function show(){
        return Menu::orderbyDesc('id')
        ->where('parent_id', 0)
        ->get();

    }
    public function getAll(){
        return Menu::orderbyDesc('id')->paginate(10);

    }
    
    public function create($request)
    {
        try{
            Menu::create([
            'name' => (string) $request->input('name'),
            'parent_id' => (int) $request->input('parent_id'),
            'description' => (string) $request->input('description'),
            'content' => (string)$request->input('content'), //strip_tags( $request->input('content')) lưu nội dung dưới dạng văn bản thuần túy 
            'active' => (string) $request->input('active'),
            ]);
            
            Session::flash('success','Tạo danh mục thành công');
        }catch(\Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
        return true;
    }
    //Xóa danh mục đa cấp: 
    // public function Remove(int $idMenu)
    // {
    //     try {
    //         //Xoá Root
    //         Menu::where('id', $idMenu)->delete();
    //         //Lấy danh sách con của Root
    //         $listMenu = Menu::where('parent_id', $idMenu)->get();
    //         //Duyệt danh sách con
    //         foreach ($listMenu as $menu) {
    //             //Gọi đệ quy
    //             $this->Remove($menu->id);
    //             //Xoá danh sách con
    //             Menu::destroy($menu);
    //         }
    //         return true;
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }
    //Xóa danh mục 1 - 2 cấp
    public function destroy($request){
        $id = $request->input('id');
        $menu = Menu::where('id',$request->input('id'))->first();

        if($menu){
            return Menu::where('id',$id)->orWhere('parent_id', $id)->delete();
        }
    }

    public function update($request, $menu): bool
    {
        
        try{
            $menu->name = (string) $request->input('name');
            $menu->parent_id = (int) $request->input('parent_id');
            $menu->description= (string) $request->input('description');
            $menu->content = (string) $request->input('content');
            $menu->active = (string) $request->input('active');
            $menu->save();

            Session::flash('success','Cập nhật danh mục thành công');
            return true;
        }catch(\Exception $e){
            Session::flash('error',$e->getMessage());
            return false;
        }
        return true;
    }
    
    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($menu, $request)
    {
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}
