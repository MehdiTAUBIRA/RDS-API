<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use App\Models\Shop;
use Illuminate\Http\Request;
use Exception;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        

        $post = Post::with('shop')->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
                  'status_code'=>200,
                  'status_message'=> 'Les posts ont été récupérés avec succes.',
                  'post' => $post,
                ]);

        /*try{

            $query = Post::query();
            $perPage = 15;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search){
                $query->whereRaw("posts LIKE '%" . $search . "%'");
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
        }*/
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        try{
          
           $post = new Post();

           $post->shop_id = $request->shop_id;
           $post->title = $request->title;
           $post->category = $request->category;
           $post->content = $request->content;

           $post->save();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'le post a été ajouté avec succes',
                'data'=> $post->load(['shop'])
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditPostRequest $request, Post $post)
    {
        try{
                $post->title = $request->title;
                $post->category = $request->category;
                $post->content = $request->content;

                if($post->shop_id == shop()->id){
                    $post->save();
                }else{
                    return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du post peut le modifier',
                    ]);
                }

                return response()->json([
                'status_code'=>200,
                'status_message'=> 'le post a été modifié avec succes',
                'data'=> $post->shop()->shop_name
                ]);

        } catch(Exception $e){
            return response()->json($e);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Post $post)
    {
        try{
            if($post->user_id == auth()->user()->id){
                $post->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le post a bien été supprimé',
                    'data' => $post
                ]);
            }else{
                $post->delete();
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'auteur du post peut le supprimer, suppression non autorisé.',
                ]);
            }
        }catch(Exception $e){
            return response()->json($e);
        }
        
    }
}
