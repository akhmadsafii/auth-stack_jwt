<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.v_login');
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $credentials = $request->only('email', 'password');
        if (request()->is('api/*')) {
            $token = Auth::guard($request->role)->attempt($credentials);

            if (!$token) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            return response()->json(['token' => $token]);
        } else {
            $role = $request->role;
            if (Auth::guard('web-' . $role)->attempt($credentials)) {
                return redirect()->route('product.list');
            } else {
                return back()->withErrors(['email' => 'Invalid credentials']);
            }
        }
    }
}
