<?php

namespace App\Http\Controllers\API\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->input('data'), [
            'username' => ['required', 'unique:users', 'max:100', 'min:4'],
            'phone' => ['required', 'unique:users', 'min:9', 'max:9'],
            'password' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'boolean']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $data = $request->all();
            $user = User::create([
                'username' => $data['data']['username'],
                'phone' => $data['data']['phone'],
                'password' => Hash::make($data['data']['password']),
                'birthdate' => $data['data']['birthdate'],
                'gender' => $data['data']['gender'],
                'is_active' => True
            ]);

            $token = $user->createToken('Token')->accessToken;

            return response()->json(['data' => ['user' => $user,'token' => $token]]);
        }
    }
}
