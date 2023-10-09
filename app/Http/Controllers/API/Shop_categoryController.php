<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop_category;
use Illuminate\Http\Request;

class Shop_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shop_category = Shop_category::paginate(10);

        return response()->json([
                  'status_code'=>200,
                  'status_message'=> 'Les shop categories ont été récupérés avec succes.',
                  'shop_category' => $shop_category,
                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop_category $shop_category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop_category $shop_category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop_category $shop_category)
    {
        //
    }
}
