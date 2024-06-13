<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class ShippingChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['getRecord'] = ShippingCharge::getRecord();
        $data['header_title'] = 'Shipping Charges';
        return view('shipping_charges.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header_title'] = 'Add New Shipping Charges';
        return view('shipping_charges.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shippingcharges = new ShippingCharge();
        $shippingcharges->name = $request->name;
        $shippingcharges->price = $request->price;
        $shippingcharges->status = $request->status;
        $shippingcharges->save();

        return redirect('shipping_charges')->with('status', 'Shipping Charges Successfully Created');
        
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
        $data['getRecord'] = ShippingCharge::getSingle($id);
        $data['header_title'] = 'Edit Shipping Charges';
        return view('shipping_charges.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $shippingcharges = ShippingCharge::getSingle($id);
        $shippingcharges->name = $request->name;
        $shippingcharges->price = $request->price;
        $shippingcharges->status = $request->status;
        $shippingcharges->save();

        return redirect('shipping_charges')->with('status', 'Shipping Charges Successfully Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shippingcharges = ShippingCharge::getSingle($id);
        $shippingcharges->is_delete = 1;
        $shippingcharges->save();
        return redirect('shipping_charges')->with('status', 'Shipping Charges Deleted Successfully');
    }
}
