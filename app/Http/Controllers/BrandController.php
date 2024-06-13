<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['getRecord'] = Brand::getRecord();
        $data['header_title'] = 'Brand';
        return view('brand.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header_title'] = 'Add New Brand';
        return view('brand.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:brand'
            
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->description = $request->description;
        $brand->status = $request->status;
        $brand->create_by = Auth::user()->id;
        $brand->save();

        return redirect('brand')->with('status', 'Brand Successfully Created');
        
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
        $data['getRecord'] = Brand::getSingle($id);
        $data['header_title'] = 'Edit Brand';
        return view('brand.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slug' => 'required|unique:brand,slug'
            
        ]);

        $brand = Brand::getSingle($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->description = $request->description;
        $brand->status = $request->status;
        $brand->save();

        return redirect('brand')->with('status', 'Brand Successfully Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect('brand')->with('status', 'Brand Deleted Successfully');
    }
}
