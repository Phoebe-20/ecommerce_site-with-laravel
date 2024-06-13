<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['getRecord'] = Color::getRecord();
        $data['header_title'] = 'Color';
        return view('color.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header_title'] = 'Add New Color';
        return view('color.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->status = $request->status;
        $color->create_by = Auth::user()->id;
        $color->save();

        return redirect('color')->with('status', 'Color Successfully Created');
        
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
        $data['getRecord'] = Color::getSingle($id);
        $data['header_title'] = 'Edit Color';
        return view('color.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->status = $request->status;
        $color->save();

        return redirect('color')->with('status', 'Color Successfully Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $color = Color::find($id);
        $color->delete();
        return redirect('color')->with('status', 'Color Deleted Successfully');
    }
}
