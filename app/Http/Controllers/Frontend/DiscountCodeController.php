<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;


class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['getRecord'] = DiscountCode::getRecord();
        $data['header_title'] = 'Discount Code';
        return view('discount_code.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header_title'] = 'Add New Discount Code';
        return view('discount_code.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $DiscountCode = new DiscountCode();
        $DiscountCode->name = $request->name;
        $DiscountCode->type = $request->type;
        $DiscountCode->percent_amount = $request->percent_amount;
        $DiscountCode->expire_date = $request->expire_date;
        $DiscountCode->status = $request->status;
        $DiscountCode->save();

        return redirect('discount_code')->with('status', 'Discount Code Successfully Created');
        
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
        $data['getRecord'] = DiscountCode::getSingle($id);
        $data['header_title'] = 'Edit Discount Code';
        return view('discount_code.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $DiscountCode = DiscountCode::getSingle($id);
        $DiscountCode->name = $request->name;
        $DiscountCode->type = $request->type;
        $DiscountCode->percent_amount = $request->percent_amount;
        $DiscountCode->expire_date = $request->expire_date;
        $DiscountCode->status = $request->status;
        $DiscountCode->save();

        return redirect('discount_code')->with('status', 'Discount Code Successfully Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $DiscountCode = DiscountCode::getSingle($id);
        $DiscountCode->is_delete = 1;
        $DiscountCode->save();
        return redirect('discount_code')->with('status', 'Discount Code Deleted Successfully');
    }
}
