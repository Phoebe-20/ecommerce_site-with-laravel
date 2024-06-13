<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getSingleSlug($slug)
    {
        return self::where('slug', '=', $slug)
                    ->where('category.status', '=', 0)
                    ->first();
    }

    static public function getRecord()
    {
        return self::select('category.*', 'users.name as create_by_name')
                ->join('users', 'users.id', '=', 'category.create_by')
                ->orderBy('category.id', 'desc')
                ->paginate(50);
    }

    static public function getRecordActive()
    {
        return self::select('category.*')
                ->join('users', 'users.id', '=', 'category.create_by')
                ->where('category.status', '=', 0)
                ->orderBy('category.name', 'asc')
                ->paginate(50);
    }

    //showing category data on website header menu
    static public function getRecordMenu()
    {
        return self::select('category.*')
                ->join('users', 'users.id', '=', 'category.create_by')
                ->where('category.status', '=', 0)
                ->paginate(50);
    }

    public function getSubCategory()
    {
        return $this->hasMany(SubCategory::class, "category_id")->where('subcategory.status', '=', 0);
    }
}
