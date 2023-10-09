<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDocumentRequest;
use App\Models\Document;
use Exception;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Document::query();
            $perPage = 15;
            $page = $request->input('page' , 1);
            $search = $request->input('search');
            
            if ($search){
                $query->whereRaw("document LIKE '%" . $search . "%'");
            }
            $total = $query->count();

            $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les documents ont été récupérés avec succes.',
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
    public function store(CreateDocumentRequest $request)
    {
        try{

            $document = new Document();
    
            $document->cart_id = $request->cart_id;
            $document->user_id == auth()->user()->id;
            $document->shop_id = $request->shop_id;
            $document->product_id = $request->product_id;
            $document->quantity = $request->quantity;
            $document->date_com = $request->date_com;
            $document->product_name = $request->product_name;
            $document->id_price = $request->id_price;
            $document->price = $request->price;
            $document->vat_id = $request->vat_id;
            $document->vat = $request->vat;
            $document->discount = $request->disccount;
            $document->price_ttc = $request->price_ttc;
            $document->name = $request->name;
            $user->statut = $request->statut;
            $document->validation_date = $request->validation_date;
    
            $document->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Document créé avec succes.',
                'document' => $document,
                'state' => '1'
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
