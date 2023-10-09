<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EditCommentRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Comment::query();
            $perPage = 15;
            $page = $request->input('page' , 1);
            $search = $request->input('search');
            
            if ($search){
                $query->whereRaw("comments LIKE '%" . $search . "%'");
            }
            $total = $query->count();

            $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les commentaires ont été récupérés avec succes.',
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
    public function store(CreateCommentRequest $request)
    {
        try{
            
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->author = auth()->user()->name;
            $comment->post_id = $request->post_id;

            $comment->save();

            return response()->json([
                'status_code'=>201,
                'status_message'=> 'le commentaire a été ajouté avec succes',
                'data'=> $comment
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCommentRequest $request, Comment $comment)
    {
        
        try{

                $comment->comment = $request->comment;

            if($comment->user_id == auth()->user()->id){
                $comment->save();
            }else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du commentaire peut le modifier',
                ]);
            }

        return response()->json([
            'status_code'=>200,
            'status_message'=> 'le commentaire a été modifié avec succes',
            'data'=> $comment
        ]);

        } catch(Exception $e){
            return response()->json($e);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Comment $comment)
    {
        try{
            if($comment->user_id == auth()->user()->id){
                $comment->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le commentaire a bien été supprimé',
                    'data' => $comment
                ]);
            }else{
                $comment->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du commentaire peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
