<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;


class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    static public function getSingle($id)
    {
        return self::find($id);
    }


    static public function getRecord()
    {
        return self::select('product.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'product.created_by')
                    ->orderBy('product.id', 'desc')
                    ->paginate(10);
    }

    static public function getProduct($category_id = '', $subcategory_id = '')
    {
        $return = Product::select('product.*', 'users.name as created_by_name', 'category.name as category_name', 'category.slug as category_slug',
                'subcategory.name as subcategory_name', 'subcategory.slug as subcategory_slug')
                    ->join('users', 'users.id', '=', 'product.created_by')
                    ->join('category', 'category.id', '=', 'product.category_id')
                    ->join('subcategory', 'subcategory.id', '=', 'product.subcategory_id');

                    if (!empty($category_id)) 
                    {
                       $return = $return->where('product.category_id', '=', $category_id) ;
                    }

                    if (!empty($subcategory_id)) 
                    {
                        $return = $return->where('product.subcategory_id', '=', $subcategory_id) ;
                    }
                    
                    if (!empty(Request::get('subcategory_id')))
                    {
                        $subcategory_id = rtrim(Request::get('subcategory_id'), ',');

                        $subcategory_id_array = explode(",", $subcategory_id);

                        $return = $return->whereIn('product.subcategory_id', $subcategory_id_array) ;
                    } 
                    else 
                    {                        
                        if (!empty(Request::get('old_category_id')))
                        {
                        $return = $return->where('product.category_id', '=', Request::get('old_category_id')) ;
                        }

                        if (!empty(Request::get('old_subcategory_id')))
                        {
                            $return = $return->where('product.subcategory_id', '=', Request::get('old_subcategory_id')) ;
                        }
                    }

                    if (!empty(Request::get('color_id')))
                    {
                        $color_id = rtrim(Request::get('color_id'), ',');

                        $color_id_array = explode(",", $color_id);

                        $return = $return->join('product_color', 'product_color.product_id', '=', 'product.id');
                        $return = $return->whereIn('product_color.color_id', $color_id_array) ;
                    } 

                    if (!empty(Request::get('brand_id')))
                    {
                        $brand_id = rtrim(Request::get('brand_id'), ',');

                        $brand_id_array = explode(",", $brand_id);
                        $return = $return->whereIn('product.brand_id', $brand_id_array) ;
                    } 

                    // Cette fonction vérifie si les variables start_price et end_price ne sont pas vides. 
                    // Si elles sont fournies, elle supprime le signe dollar des valeurs 
                    // et applique les conditions de filtrage au champ product.price. 
                    // Le résultat inclura les produits dans la plage de prix spécifiée.
                    if (!empty(Request::get('start_price')) && !empty(Request::get('end_price')))
                    {
                        $start_price = str_replace('cfa', '', Request::get('start_price'));
                        $end_price = str_replace('cfa', '', Request::get('end_price'));

                        $return = $return->where('product.price', '>=', $start_price);
                        $return = $return->where('product.price', '<=', $end_price);
                    }

                    if(!empty(Request::get('q')))
                    {
                        $return = $return->where('product.title', 'like', '%'.Request::get('q').'%');
                    }

                    $return = $return->where('product.status', '=', 0)
                        ->groupBy('product.id')
                        ->orderBy('product.id', 'desc')
                        ->paginate(10);

        return $return;
    }

    static public function getRelatedProduct($product_id, $subcategory_id)
    {
        $return = Product::select('product.*', 'users.name as created_by_name', 'category.name as category_name', 'category.slug as category_slug',
        'subcategory.name as subcategory_name', 'subcategory.slug as subcategory_slug')
            ->join('users', 'users.id', '=', 'product.created_by')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->join('subcategory', 'subcategory.id', '=', 'product.subcategory_id')
            ->where('product.id', '!=', $product_id)
            ->where('product.subcategory_id', '=', $subcategory_id)
            ->where('product.status', '=', 0)
            ->groupBy('product.id')
            ->orderBy('product.id', 'desc')
            ->limit(10) //Une limite d'affichage de 10 articles
            ->get();

        return $return;    
    }

    public function getImageSingle()
    {
        return $this->hasMany(ProductImage::class,"product_id")->orderBy('order_by', 'asc')->first();
    }

    static public function getSingleSlug($slug)
    {
        return self::where('slug', '=', $slug)
                ->where('product.status', '=', 0)
                ->first();
    }

    static public function checkSlug($slug)
    {
        return self::where('slug', '=', $slug)->count();
    }


    public function getColor()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function getSize()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function getImage()
    {
        return $this->hasMany(ProductImage ::class, 'product_id')->orderBy('order_by', 'asc');
    }
   
    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getSubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
}
