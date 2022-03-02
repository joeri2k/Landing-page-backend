<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use App\Http\Middleware\corsMiddleware;

class EditInfo extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,100',
            'email' => 'string|email|max:100|unique:users',
            
        ]);
        if(! auth()->user()){
            return response()->json(['error' => 'Unauthorized'], 401);
        } else if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);

        } else{
            $user =auth()->user();
            if($request['name']){
            $user->name = $request['name'];
            }
            if($request['email']){
            $user->email = $request['email'];
            }

            $user->save();
            
            return response()->json([
                'message' => 'User successfully updated',
                'user' => $user,
            ], 201);
        }

        }
           /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPass(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ]);
        if(! auth()->user()){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // if ($request['password'] == $request['new_password']) {
        //     return response()->json(['error' => 'Same as the old one', 422]);
        // }
        $user =auth()->user();
        $user->password = bcrypt($request['new_password']);
        $user->save();

        return response()->json([
            'message' => 'User successfully updated Password',
            'user' => $user,
        ], 201);

    }


}
