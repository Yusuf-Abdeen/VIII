<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            $q = $request['q'];
            $users = User::where('username', 'LIKE', '%'.$q.'%')->get();
            return response()->json(['data' => ['users' => $users]]);
        } else {
            $users = User::paginate(10);
            return response()->json(['data' => ['users' => $users]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $user)
    {
        $user = User::find($user);
        if ($user) {
            return response()->json(['data' => $user->testStatements]);
        } else {
            return response()->json(['data' => null], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $statment)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $request->user()->token()->revoke();
        $user->delete();
        return response()->json(['success' => 'Account Deleted'], 200);
    }
}
