<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop_address;
use App\Models\Shop;
use Illuminate\Http\Request;
use Exception;

class Shop_addressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
          
            $shop_address = new Shop_address();

            $shop_address->shop_id = $shop->id;
            $shop_address->label = $request->label;
            $shop_address->address = $request->address;
            $shop_address->city = $request->city;
            $shop_address->postalcode = $request->postalcode;
            $shop_address->country = $request->country;
            $shop_address->gps_x = $request->gps_x;
            $shop_address->gps_y = $request->gps_y;

            $shop_address->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'les nouvelles coordonnées ont été ajouté avec succes',
                 'data'=> $shop_address
             ]);
         }catch(Exception $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop_address $shop_address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop_address $shop_address)
    {
        try{
            if($shop_address->shop_id == auth()->shop()->id){

                $shop_address->label = $request->label;
                $shop_address->address = $request->address;
                $shop_address->city = $request->city;
                $shop_address->postalcode = $request->postalcode;
                $shop_address->country = $request->country;
                $shop_address->gps_x = $request->gps_x;
                $shop_address->gps_y = $request->gps_y;
    
                $shop_address->save();
        }else{
            return response()->json([
                'status_code' => 422,
                'status_message' => 'seul l\'utilisateur peut modifier les données',
            ]);
        }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'les données ont été modifié avec succes',
            'data'=> $shop_address
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop_address $shop_address)
    {
        //
    }
}
