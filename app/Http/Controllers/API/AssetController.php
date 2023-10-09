<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAssetRequest;
use App\Http\Requests\EditAssetRequest;
use App\Models\Asset;
use Exception;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $query = Asset::query();
            $perPage = 15;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search){
                $query->whereRaw("asset LIKE '%" . $search . "%'");
            }
                $total = $query->count();

                $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();
            
            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les assets ont été récupérés avec succes.',
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
    public function store(CreateAssetRequest $request)
    {
        try{

            
            $asset = new Asset();
            $asset->asset_url = $request->asset_url->store('asset_url');
            $asset->asset_type = $request->asset_type;
            $asset->asset_source = $request->asset_source;
            
            $asset->save();

                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul le propriétaire du shop peux ajouter un asset',
                ]);

            return response()->json([
                'status_code'=>201,
                'status_message'=> ' asset ajouté avec succes',
                'data'=> $asset
            ]);
        }catch(Exeption $e){
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return response()->json($asset);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditAssetRequest $request, Asset $asset)
    {
       
        try{
            if($asset->user_id == auth()->user()->id){
                $asset->asset_url = $request->asset_url;
                $asset->asset_type = $request->asset_url;
                $asset->description = $request->asset_url;
                $asset->post_id = $post->id;
                $asset->shop_id = $shop->id;
                $asset->product_id = $product->id;

                $asset->save();

            }else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul le propriétaire de l\'asset peut le modifier',
                ]);
            }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'l\'asset a été modifié avec succes',
            'data'=> $asset
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Asset $asset)
    {
        try{
            if($asset->user_id == auth()->user()->id){
                $asset->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'L\'asset a bien été supprimé',
                    'data' => $asset
                ]);
            }else{
                $asset->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul le propriétaire de l\'asset peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
