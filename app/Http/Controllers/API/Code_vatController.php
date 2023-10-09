<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Code_vat;
use Illuminate\Http\Request;

class Code_vatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Code_vat::query();
            $perPage = 15;
            $page = $request->input('page' , 1);
            $search = $request->input('search');
            
            if ($search){
                $query->whereRaw("code_vat LIKE '%" . $search . "%'");
            }
            $total = $query->count();

            $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les code Tva ont été récupérés avec succes.',
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
    public function store(CreatCode_vatRequest $request)
    {
        try{
          
            $code_vat = new Code_vat();
            $code_vat->vat = $request->vat;
            $code_vat->start_date = $request->start_date;
            $code_vat->end_date = $request->end_date;
 
            $post->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'le post a été ajouté avec succes',
                 'data'=> $post
             ]);
         }catch(Exeption $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Code_vat $code_vat)
    {
        return response()->json($code_vat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Code_vat $code_vat)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $code_vat->vat = $request->vat;
                $code_vat->start_date = $request->start_date;
                $code_vat->end_date = $request->end_date;

                $code_vat->save();
            }else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du code TVA peut le modifier',
                ]);
            }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'le code Tva a été modifié avec succes',
            'data'=> $code_vat
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Code_vat $code_vat)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $code_vat->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le code tva a bien été supprimé',
                    'data' => $code_vat
                ]);
            }else{
                $code_vat->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du code tva peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
