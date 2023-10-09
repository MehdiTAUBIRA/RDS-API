<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProduct_categoryRequest;
use App\Http\Requests\EditProduct_categoryRequest;
use App\Models\Product_category;
use Exception;
use Illuminate\Http\Request;

class Product_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Product_category::query();
            $perPage = 15;
            $page = $request->input('page' , 1);
            $search = $request->input('search');
            
            if ($search){
                $query->whereRaw("product_category LIKE '%" . $search . "%'");
            }
            $total = $query->count();

            $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les categories de produits ont été récupérés avec succes.',
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
    public function store(CreateProduct_categoryRequest $request)
    {
        try{
          
            $product_category = new Product_category();
            $product_category->lib_cat = $request->lib_cat;
 
            $product_category->save();
 
             return response()->json([
                 'status_code'=>200,
                 'status_message'=> 'la categorie de produit a été ajouté avec succes',
                 'data'=> $product_category
             ]);
         }catch(Exception $e){
             return response()->json($e);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product_category $product_category)
    {
        return response()->json($product_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProduct_categoryRequest $request, Product_category $product_category)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $product_category->lib_cat = $request->libcat;

                $product_category->save();
        }else{
            return response()->json([
                'status_code' => 422,
                'status_message' => 'seul le propriétaire du shop peut le modifier',
            ]);
        }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'la categorie a été modifié avec succes',
            'data'=> $product_category
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Product_category $product_category)
    {
        try{
            if($shop->user_id == auth()->user()->id){
                $product_category->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'La categorie a bien été supprimé',
                    'data' => $product_category
                ]);
            }else{
                $product_category->delete();
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
