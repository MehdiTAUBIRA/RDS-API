<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShopRequest;
use App\Http\Requests\EditShopRequest;
use App\Models\Shop;
use App\Models\Shop_address;
use Exception;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

		$shop = Shop::all()->load('shop_address');

        	return response()->json([
                  	'status_code'=>200,
                  	'status_message'=> 'Les shops ont été récupérés avec succes.',
                  	'shop' => $shop,
                	]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateShopRequest $request)
    {
        try{

            $shop = new Shop();

            $shop -> siret = $request->siret;
            $shop -> shop_name = $request->shop_name;
            $shop -> contactname = auth()->user()->name;
            $shop -> phone = $request->phone;
            $shop -> telecopy = $request->telecopy;
            $shop -> email = $request->email;
            $shop -> user_id = auth()->user()->id;
            $shop -> category = $request->category;

            $shop->save();

            $shop_address = new shop_address();

                $shop_address->shop_id = $shop->id;
                $shop_address->label = 'Principale';
                $shop_address->address = $request->address;
                $shop_address->city = $request->city;
                $shop_address->postalcode = $request->postalcode;
                $shop_address->country = $request->country;
                $shop_address->gps_x = $request->gps_x;
                $shop_address->gps_y = $request->gps_y;

                $shop_address->save();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'le shop a été ajouté avec succes',
                'data'=> $shop->load(['shop_address'])
            ]);
        }catch(Exeption $e){
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shop = Shop::findOrFail($id);
        
        return response()->json(['data'=>$shop->load(['shop_address'])], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditShopRequest $request, Shop $shop)
    {
        try{

                if($request->has('siret')){$shop->siret = $request->siret;}
                if($request->has('shop_name')){$shop->shop_name = $request->shop_name;}
                if($request->has('contactname')){$shop->contactname = $request->contactname;}
                if($request->has('phone')){$shop->phone = $request->phone;}
                if($request->has('telecopy')){$shop->telecopy = $request->telecopy;}
                if($request->has('email')){$shop->email = $request->email;}
		        if($request->has('category')){$shop->category = $request->category;}
		        if($request->has('banner')){$shop->banner = $request->banner;}
		        if($request->has('profil_pic')){$shop->profil_pic = $request->profil_pic;}

            if($shop->user_id == auth()->user()->id){
               
                $shop->update($request->all());

            }else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul le propriétaire du shop peut le modifier',
                ]);
            }

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'le shop a été modifié avec succes',
                'data'=> $shop->load(['shop_address'])
            ]);

        }catch(Exception $e){
            return response()->json($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $shop->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le shop a bien été supprimé',
                    'data' => $shop
                ]);
            }else{
                $shop->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul le propriétaire du shop peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
