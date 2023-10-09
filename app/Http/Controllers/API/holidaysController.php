<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHolidaysRequest;
use App\Http\Requests\EditHolidaysRequest;
use App\Models\holidays;
use Exception;
use Illuminate\Http\Request;

class holidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $query = holidays::query();
            $perPage = 15;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search){
                $query->whereRaw("holidays LIKE '%" . $search . "%'");
            }
                $total = $query->count();

                $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();
            
            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les vacances ont été récupérés avec succes.',
                'current_page'=>$page,
                'last_page'=> ceil($total / $perPage),
                'items'=> $result,
            ]);

        }catch(Exception $e){
            return response ()->json($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateHolidaysRequest $request)
    {
        try{
          
            $holidays = new holidays();
            $holidays->start_date = $request->start_date;
            $holidays->end_date = $request->end_date;
            $holidays->shop_id = $request->shop_id;
            
 
            $holidays->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'les vacances ont été ajoutés avec succes',
                 'data'=> $holidays
             ]);
         }catch(Exeption $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(holidays $holidays)
    {
        return response()->json($holidays);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditHolidaysRequest $request, holidays $holidays)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $holidays->start_date = $request->start_date;
                $holidays->end_date = $request->end_date;
                $holidays->shop_id = $request->shop_id;

                $holidays->save();
        }else{
            return response()->json([
                'status_code' => 422,
                'status_message' => 'seul le propriétaire du shop peut le modifier',
            ]);
        }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'les vacances ont été modifié avec succes',
            'data'=> $holidays
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(holidays $holidays)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $holidays->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Les vacances ont bien été supprimés',
                    'data' => $holidays
                ]);
            }else{
                $holidays->delete();
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
