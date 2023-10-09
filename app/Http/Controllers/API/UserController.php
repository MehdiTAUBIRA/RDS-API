<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUsers;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use App\Models\User_address;
use App\Models\Shop;
use App\Models\Shop_address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::with('user_address', 'shop')->paginate(10);

        return response()->json([
                  'status_code'=>200,
                  'status_message'=> 'Les users ont été récupérés avec succes.',
                  'user' => $user,
                ]);
        /*try{
            $query = User::join('user_address', 'user_address.user_id', '=', 'users.id')->get();//query();
            $perPage = 15;
            $page = $request->input('page' , 1);
            $search = $request->input('search');
            
            if ($search){
                $query->whereRaw("users LIKE '%" . $search . "%'");
            }
            $total = $query->count();

            $result = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'Les users ont été récupérés avec succes.',
                'current_page'=>$page,
                'last_page'=> ceil($total / $perPage),
                'items'=> $result,
            ]);

        }catch(Exception $e){
            return response()->json($e);
        }*/
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterUsers $request)
    {
        try{

            $user = new User();
    
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->first_name = $request->first_name;
            $user->birthdate = $request->birthdate;
            $user->gender = $request->gender;
            $user->email = $request->email;
            $user->telecopy = $request->telecopy;
            $user->phone = $request->phone;
            $user->siren = $request->siren;
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]);
            $user->statut = $request->statut;
            $user->state = '';
    
            $user->save();

            $user_address = new User_address();

            $user_address->user_id = $user->id;
            $user_address->label = 'Principale';
            $user_address->address = $request->address;
            $user_address->city = $request->city;
            $user_address->postalcode = $request->postalcode;
            $user_address->country = $request->country;
            $user_address->gps_x = $request->gps_x;
            $user_address->gps_y = $request->gps_y;
            

            $user_address->save();

///// send email part here.

            return response()->json([
                'status_code' => 200,
                'status_message' => 'User créé avec succes.',
                'users' => $user,
                'user_address'=> $user_address,
                
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    public function login(LogUserRequest $request)
    {
        
        if(auth()->attempt($request->only(['email', 'password']))){

            $user = auth()->user()->load(['user_address', 'shop', 'shop_address']);
            $token = $user->createToken('SECRET_KEY')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur connecté',
                'user' => $user,
                'token' => $token
            ]);

        }else{

            return response()->json([
                'status_code' => 403,
                'status_message' => 'informations non valide.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json(['data'=>$user->load(['user_address'])], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try{

            $rules = [
                'name' => 'Regex:/^[\D]+$/i|max:100|unique:users,name' . $user->id,
                'last_name' =>'Regex:/^[\D]+$/i|max:100',
                'first_name' => 'Regex:/^[\D]+$/i|max:100',
                'birthdate',
                'gender',
                'email' => 'email:rfc|max:255|unique:users,email' . $user->id,
                'telecopy',
                'phone' => 'phone|unique:users,phone' . $user->id,
                'password',
                'statut',
    
            ];

		if($request->has('name')){$user->name = $request->name;}
		if($request->has('last_name')){$user->last_name = $request->last_name;}
		if($request->has('first_name')){$user->flirst_name = $request->first_name;}
		if($request->has('birthdate')){$user->birthdate = $request->birthdate;}
		if($request->has('gender')){$user->gender = $request->gender;}
		if($request->has('email')){$user->email = $request->email;}
		if($request->has('password')){$user->password = bcrypt($request->name);}
		if($request->has('telecopy')){$user->telecopy = $request->telecopy;}
		if($request->has('siren')){$user->siren = $request->siren;}
		if($request->has('statut')){$user->statut = $request->statut;}
    
            if($user->id = auth()->user()->id){

		$user->update($request->all());

            }else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'seul l\'utilisateur peut modifier les données',
                ]);
            }

            return response()->json([
                'status_code'=>200,
                'status_message'=> 'les données ont été modifié avec succes',
                'user'=> $user,

            ]);
        } catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        $user->delete();

        return response()->json();
    }

}
