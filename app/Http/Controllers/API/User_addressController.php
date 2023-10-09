<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser_addressRequest;
use App\Http\Requests\EditUser_addressRequest;
use App\Models\User_address;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class User_addressController extends Controller
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
    public function store(CreateUser_addressRequest $request)
    {
        try{
          
            $user_address = new User_address();

	    $user_address->user_id = auth()->user()->id;
            $user_address->label = $request->label;
            $user_address->address = $request->address;
            $user_address->city = $request->city;
            $user_address->postalcode = $request->postalcode;
            $user_address->country = $request->country;
            $user_address->gps_x = $request->gps_x;
            $user_address->gps_y = $request->gps_y;

            $user_address->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'les nouvelles coordonnées ont été ajouté avec succes',
                 'data'=> $user_address
             ]);
         }catch(Exception $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(User_address $user_address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUser_addressRequest $request, User_address $user_address)
    {
        try{

                $user_address->label = $request->label;
                $user_address->address = $request->address;
                $user_address->city = $request->city;
                $user_address->postalcode = $request->postalcode;
                $user_address->country = $request->country;
                $user_address->gps_x = $request->gps_x;
                $user_address->gps_y = $request->gps_y;

            	if($user_address->user_id = auth()->user()->id){
                	$user_address->save();
            	}else{
                	return response()->json([
                    	'status_code' => 422,
                    	'status_message' => 'seul l\'utilisateur peut modifier les données',
                	]);
            	}

            	return response()->json([
                	'status_code'=>200,
                	'status_message'=> 'les données ont été modifié avec succes',
                	'data'=> $user_address
            	]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User_address $user_address)
    {
                try{
            if($User_address->user_id == auth()->user()->id){
                $User_address->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'L\'adresse a bien été supprimé',
                    'data' => $User_address
                ]);
            }else{
                $User_address->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul le propriétaire de l\'adresse peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
