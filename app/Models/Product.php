<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// tạo bảng để gen vào db
class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'active',
        'thumb',
        'in_stock'
    ];
    //Liên kết khóa phụ đến khóa chính ở model Menu
    public function menu(){
        return $this->hasOne(Menu::class, 'id', 'menu_id')
        ->withDefault(['name' => '']);
    }
}
