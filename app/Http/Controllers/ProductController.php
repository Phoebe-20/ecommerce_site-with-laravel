<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['getRecord'] = Product::getRecord();
        $data['header_title'] = 'Product';
        return view('product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*$product = Product::getSingle($product_id);
        if(!empty($product))
        {
            $data['getCategory'] = Category::getRecordActive();
            $data['getBrand'] = Brand::getRecordActive();
            $data['getColor'] = Color::getRecordActive();
            $data['product'] = $product;
            $data['getSubCategory'] = SubCategory::getRecordSubCategory($product->category_id);
            $data['header_title'] = 'Add New Product';
            
            return view('product.create', $data);
        }*/

        $data['getCategory'] = Category::getRecord();
        $data['getSubCategory'] = SubCategory::getRecord();
        $data['getBrand'] = Brand::getRecord();
        $data['getColor'] = Color::getRecord();
        $data['getSize'] = ProductSize::getRecord();
        $data['header_title'] = 'Add New Product';
        return view('product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $title = trim($request->title);
        $product = new Product;
        $product->title = $title;
        $product->created_by = Auth::user()->id;
        $product->save();

        $slug = Str::slug($title, "-");

       $checkSlug = Product::checkSlug($slug);
       if(empty($checkSlug))
       {
            $product->slug = $slug;
            $product->save();
       }
       else
       {
            $new_slug = $slug.'-'.$product->id;
            $product->slug = $new_slug;
            $product->save();
       }

       return redirect('product')->with('status', 'Product Created Sucessfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product_id)
    {
        $product = Product::getSingle($product_id);
        if(!empty($product))
        {
            $data['getCategory'] = Category::getRecordActive();
            $data['getBrand'] = Brand::getRecordActive();
            $data['getColor'] = Color::getRecordActive();
            $data['product'] = $product;
            $data['getSubCategory'] = SubCategory::getRecordSubCategory($product->category_id);
            $data['header_title'] = 'Edit Product';
            
            return view('product.edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product_id)
    {
        //dd($request->all());
        $product = Product::getSingle($product_id);
        if(!empty($product))
        {
            $product->title = $request->title;
            $product->sku = $request->sku;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->brand_id = $request->brand_id;
            $product->price = $request->price;
            $product->old_price = $request->old_price;
            $product->description = $request->description;
            $product->additional_info = $request->additional_info;
            $product->shipping_returns = $request->shipping_returns;
            $product->status = $request->status;
            $product->save();


            ProductColor::DeleteRecord($product->id);
            if(!empty($request->color_id))
            {
                foreach($request->color_id as $color_id)
                {
                    $color = new ProductColor;
                    $color->color_id = $color_id;
                    $color->product_id = $product->id;
                    $color->save();

                }
            }

            ProductSize::DeleteRecord($product->id);
            if(!empty($request->size))
            {
                foreach($request->size as $size)
                {
                    if (!empty($size['name'])) 
                    {
                        $saveSize = new ProductSize;
                        $saveSize->name = $size['name'];
                        $saveSize->price = !empty($size['price']) ? $size['price'] : 0;
                        $saveSize->product_id = $product->id;
                        $saveSize->save();
                    }
                    

                }
            }

            //upload product images
            if (!empty($request->file('image'))) 
            {
                foreach ($request->file('image') as $value) 
                {
                    if ($value->isValid()) 
                    {
                        $ext = $value->getClientOriginalExtension();
                        $randomStr = $product->id.Str::random(20);
                        $filename = strtolower($randomStr).'.'.$ext;
                        $value->move('upload/product/', $filename);

                        $imageupload = new ProductImage;
                        $imageupload->image_name = $filename;
                        $imageupload->image_extension = $ext;
                        $imageupload->product_id = $product->id;
                        $imageupload->save();

                    }
                }
            }

            return redirect('product')->with('status', 'Product Sucessfully Updated');

        }
        else
        {
            abort(404);
        }


    }

    /**
     * Remove images from storage.
     */
    public function image_delete($id)
    {
        $image = ProductImage::getSingle($id);
        if (!empty($image->getLogo())) 
        {
            unlink('upload/product/'.$image->image_name);
        }
        $image->delete();

        return redirect('product')->with('status', 'Product Image Sucessfully Delete');

    }

    // Sortable image
    public function product_image_sortable(Request $request)
    {
        //dd($request->all());
        if(!empty($request->photo_id))
        {
            $i = 1;
            foreach($request->photo_id as $photo_id)
            {
                $image = ProductImage::getSingle($photo_id);
                $image->order_by = $i;
                $image->save();

                $i++;
            }
        }

        $json['success'] = true;
        echo json_encode($json);
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('product')->with('status', 'Product Deleted Successfully');
    }
}
