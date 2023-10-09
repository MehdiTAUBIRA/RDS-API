<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorking_daysRequest;
use App\Http\Requests\EditWorking_daysRequest;
use App\Models\Working_days;
use Exception;
use Illuminate\Http\Request;

class Working_daysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $query = Working_days::query();
            $perPage = 15;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search){
                $query->whereRaw("working_days LIKE '%" . $search . "%'");
            }
                $total = $query->count();

                $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();
            
            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les posts ont été récupérés avec succes.',
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
    public function store(CreateWorking_daysRequest $request)
    {
        try{
          
            $working_days = new Working_days();
            $working_days->days = $request->days;
            $working_days->open_hours = $request->open_hours;
            $working_days->closing_hours = $request->closing_hours;
            $working_days->break_start = $request->break_start;
            $working_days->break_end = $request->break_end;
            $working_days->shop_id = $request->shop_id;
            //$working_days->user_id = auth()->user()->id;
 
            $working_days->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'l\'horaire a été ajouté avec succes',
                 'data'=> $working_days
             ]);
         }catch(Exeption $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Working_days $working_days)
    {
        return response()->json($working_days);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditWorking_daysRequest $request, Working_days $working_days)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $working_days->days = $request->days;
                $working_days->open_hours = $request->open_hours;
                $working_days->closing_hours = $request->closing_hours;
                $working_days->break_start = $request->break_start;
                $working_days->break_end = $request->break_end;
                $working_days->shop_id = $request->shop_id;

                $working_days->save();
        }else{
            return response()->json([
                'status_code' => 422,
                'status_message' => 'seul l\'auteur de l\'horaire peut le modifier',
            ]);
        }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'l\'horaire a été modifié avec succes',
            'data'=> $working_days
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Working_days $working_days)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $working_days->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le post a bien été supprimé',
                    'data' => $working_days
                ]);
            }else{
                $working_days->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur de l\'horaire peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
