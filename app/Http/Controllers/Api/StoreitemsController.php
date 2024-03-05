<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoreItems;
use Illuminate\Http\Request;

class StoreitemsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ecom_id' => 'required',
            'price' => 'nullable', 
            'productname' => 'nullable',
            'productimage' => 'nullable',
            
           
        ]);

        try {
            StoreItems::create([
                'ecom_data_id' => $request->input('ecom_id'),
                'price' => $request->input('price'),
                'productname' => $request->input('productname'),
                // Fill other fields with empty values if needed
            ]);


            return response()->json('LINK Portfoliodata UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
