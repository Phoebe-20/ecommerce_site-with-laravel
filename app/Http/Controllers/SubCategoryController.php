<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['getRecord'] = SubCategory::getRecord();
        $data['header_title'] = 'Sub Category';
        return view('subcategory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['getCategory'] = Category::getRecord();
        $data['header_title'] = 'Add Sub Category';
        return view('subcategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* dd($insert->all());*/

       $request->validate([
        'slug' => 'required|unique:subcategory'
        
    ]);

    $subcategory = new SubCategory();
    $subcategory->category_id = $request->category_id;
    $subcategory->name = $request->name;
    $subcategory->slug = $request->slug;
    $subcategory->meta_title = $request->meta_title;
    $subcategory->meta_description = $request->meta_description;
    $subcategory->meta_keywords = $request->meta_keywords;
    $subcategory->status = $request->status;
    $subcategory->create_by = Auth::user()->id;
    $subcategory->save();

    return redirect('subcategory')->with('status', 'Sub Category Successfully Created');
    
    }

    /**
     * Display the specified resource.
     */
    /*public function show(string $id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['getCategory'] = Category::getRecord();
        $data['getRecord'] = SubCategory::getSingle($id);
        $data['header_title'] = 'Edit Sub Category';
        return view('subcategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slug' => 'required|unique:subcategory,slug'
            
        ]);
    
        $subcategory = SubCategory::getSingle($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        $subcategory->meta_keywords = $request->meta_keywords;
        $subcategory->status = $request->status;
        $subcategory->save();
    
        return redirect('subcategory')->with('status', 'Sub Category Successfully Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return redirect('subcategory')->with('status', 'Sub Category Deleted Successfully');
    }


    public function get_subcategory(Request $request)
    {
        $category_id = $request->id;
        $get_subcategory = SubCategory::getRecordSubCategory($category_id);
        $html = '';
        $html .= '<option value="">Select</option>';
        foreach ($get_subcategory as $value )
        {
            $html .= '<option value="'.$value->id.'">'.$value->name.'</option>';
        }

        $json['html'] = $html;
        echo json_encode($json);
    }
}


