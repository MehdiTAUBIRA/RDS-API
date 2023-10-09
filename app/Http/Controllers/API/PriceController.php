<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePriceRequest;
use App\Http\Requests\EditPriceRequest;
use App\Models\Price;
use Exception;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Price::query();
            $perPage = 15;
            $page = $request->input('page' , 1);
            $search = $request->input('search');
            
            if ($search){
                $query->whereRaw("price LIKE '%" . $search . "%'");
            }
            $total = $query->count();

            $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les shops ont été récupérés avec succes.',
                'current_page'=>$page,
                'last_page'=> ceil($total / $perPage),
                'items'=> $result,
            ]);

        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePriceRequest $request)
    {
        try{
          
            $price = new Price();
            $price->price = $request->price;
            $price->start_date = $request->start_date;
            $price->end_date = $request->end_date;
            $price->user_id = auth()->user()->id;
 
            $price->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'le prix a été ajouté avec succes',
                 'data'=> $price
             ]);
         }catch(Exeption $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        return response()->json($price);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditPriceRequest $request, Price $price)
    {
        try{
            if($price->user_id == auth()->user()->id){
                $price->price = $request->price;
                $price->start_date = $request->start_date;
                $price->end_date = $request->end_date;

                $price->save();
        }else{
            return response()->json([
                'status_code' => 422,
                'status_message' => 'seul l\'auteur du prix peut le modifier',
            ]);
        }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'le prix a été modifié avec succes',
            'data'=> $price
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Price $price)
    {
        try{
            if($price->user_id == auth()->user()->id){
                $price->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le prix a bien été supprimé',
                    'data' => $price
                ]);
            }else{
                $price->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du prix peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
