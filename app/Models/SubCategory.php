<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'subcategory';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getSingleSlug($slug)
    {
        return self::where('slug', '=', $slug)
                    ->where('subcategory.status', '=', 0)
                    ->first();
    }

    static public function getRecord()
    {
        return self::select('subcategory.*', 'users.name as create_by_name', 'category.name as category_name')
                ->join('category', 'category.id', '=', 'subcategory.category_id')
                ->join('users', 'users.id', '=', 'subcategory.create_by')
                ->orderBy('subcategory.id', 'desc')
                ->paginate(50);
               
    }

    static public function getRecordSubCategory($category_id)
    {
        return self::select('subcategory.*')
                ->join('users', 'users.id', '=', 'subcategory.create_by')
                ->where('subcategory.status', '=', 0)
                ->where('subcategory.category_id', '=', $category_id)
                ->orderBy('subcategory.name', 'asc')
                ->get();
               
    }

    public function TotalProduct() 
    {
        return $this->hasMany(Product::class, 'subcategory_id')
                ->where('product.status', '=', 0)
                ->count();
    }

}
