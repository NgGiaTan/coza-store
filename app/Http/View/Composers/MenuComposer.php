<?php


namespace App\Http\View\Composers;
use App\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    protected $users;

    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $menu = Menu::select('id', 'name', 'parent_id')->where('active', 1)->orderBy('id')->get();

        $view->with('menus', $menu);// truyền dữ liệu đi ra view, view sẽ nhận dữ liệu lại trong biến $menus
    }
}
