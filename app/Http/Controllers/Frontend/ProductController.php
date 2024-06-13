<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Color;
use App\Models\Brand;

// Afficher les données des produits(caracteristiques) de la base de donnée sur le frontend
class ProductController extends Controller
{
    public function getProductSearch()
    {
        $data['meta_title'] = 'Search';
        $data['meta_description'] = '';
        $data['meta_keywords'] = '';

        $getProduct = Product::getProduct();

        // Frontend: "Seach"
        $page = 0;
        if (!empty($getProduct->nextPageUrl())) 
        {
            $parse_url = parse_url($getProduct->nextPageUrl());
            if (!empty($parse_url['query'])) 
            {
                parse_str($parse_url['query'], $get_array);
                $page = !empty($get_array['page']) ? $get_array['page'] : 0;
            }
        }
        $data['page'] = $page;
        $data['getProduct'] = $getProduct;

        $data['getColor'] = Color::getRecordActive();
        $data['getBrand'] = Brand::getRecordActive();

        return view('frontend.product.index', $data);
    }

    public function getCategory($slug, $subslug = '')
    {

        $getProductSingle= Product::getSingleSlug($slug);

        $getCategory= Category::getSingleSlug($slug);
        $getSubCategory= SubCategory::getSingleSlug($subslug);

        $data['getColor'] = Color::getRecordActive();
        $data['getBrand'] = Brand::getRecordActive();

        if (!empty($getProductSingle)) 
        {
            $data['meta_title'] = $getProductSingle->title;
            $data['meta_description'] = $getProductSingle->description;

            $data['getProduct'] = $getProductSingle;

            $data['getRelatedProduct'] = Product::getRelatedProduct($getProductSingle->id, $getProductSingle->subcategory_id);

            return view('frontend.product.detail', $data);
        }
        else if (!empty($getCategory) && !empty($getSubCategory))
        {
            $data['meta_title'] = $getSubCategory->meta_title;
            $data['meta_description'] = $getSubCategory->meta_description;
            $data['meta_keywords'] = $getSubCategory->meta_keywords;

            $data['getSubCategory'] = $getSubCategory;
            $data['getCategory'] = $getCategory;

            $getProduct = Product::getProduct($getCategory->id, $getSubCategory->id);
            
            // Frontend: "Voir Plus"
            $page = 0;
            if (!empty($getProduct->nextPageUrl())) 
            {
                $parse_url = parse_url($getProduct->nextPageUrl());
                if (!empty($parse_url['query'])) 
                {
                    parse_str($parse_url['query'], $get_array);
                    $page = !empty($get_array['page']) ? $get_array['page'] : 0;
                }
            }
            $data['page'] = $page;

            $data['getProduct'] = $getProduct;

            $data['getSubCategoryFilter'] = SubCategory::getRecordSubCategory($getCategory->id);

            return view('frontend.product.index', $data);
        }
        else if (!empty($getCategory)) 
        {
            $data['getSubCategoryFilter'] = SubCategory::getRecordSubCategory($getCategory->id);
            //dd($data['getSubCategoryFilter']);

            $data['getCategory'] = $getCategory;

            $data['meta_title'] = $getCategory->meta_title;
            $data['meta_description'] = $getCategory->meta_description;
            $data['meta_keywords'] = $getCategory->meta_keywords;

            $getProduct = Product::getProduct($getCategory->id);

            // Frontend: "Voir Plus"
            $page = 0;
            if (!empty($getProduct->nextPageUrl())) 
            {
                $parse_url = parse_url($getProduct->nextPageUrl());
                if (!empty($parse_url['query'])) 
                {
                    parse_str($parse_url['query'], $get_array);
                    $page = !empty($get_array['page']) ? $get_array['page'] : 0;
                }
            }
            $data['page'] = $page;

            $data['getProduct'] = $getProduct;

            return view('frontend.product.index', $data);
        }
        else 
        {
            abort(404);
        }
        
    }

    public function getFilterProductAjax(Request $request)
    {
        $getProduct = Product::getProduct();

        // Frontend: "Voir Plus"
        $page = 0;
        if (!empty($getProduct->nextPageUrl())) 
        {
            $parse_url = parse_url($getProduct->nextPageUrl());
            if (!empty($parse_url['query'])) 
            {
                parse_str($parse_url['query'], $get_array);
                $page = !empty($get_array['page']) ? $get_array['page'] : 0;
            }
        }
        
        return response()->json([
            "status" => true,
            "page" => $page,
            "success" => view("frontend.product._list", [                   
                "getProduct" => $getProduct,
                ])->render(),
        ], 200);
        //dd($getProduct);
    }
    
}
