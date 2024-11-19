<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'parent_id',
        'description',
        'content',
        'active'
    ];
    // tạo liên kết khóa phụ đến product
    public function products(){
        return $this->hasMany(Product::class, 'menu_id', 'id');
    }
}
