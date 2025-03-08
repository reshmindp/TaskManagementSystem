<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
                        ['name' => 'required|string|max:255',
                         'email' => 'required|string|email|unique:users',
                         'password' => 'required|string|min:6'
                        ]);

        if($validateUser->fails())
        {
            return response()->json(['status' => false, 'message' => 'Validation Error', 'errors' => $validateUser->errors()]);
        }

        $user = User::create(['name' => $request->name,
                              'email' => $request->email,
                              'password' => Hash::make($request->password),
        ]);

        return response()->json(['status'=>true, 'token' => $user->createToken('api-token')->plainTextToken]);

    }

    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        
        if($validateUser->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()]);
        }

        $userAuthentication = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if($userAuthentication)
        {
            $user = User::where('email', $request->email)->first();

            return response()->json(['status'=>true, 'token' => $user->createToken('api-token')->plainTextToken]);
        }
        else
        {
            return response()->json(['message' => 'Invalid login credentials']);
        }

    }
    
}
