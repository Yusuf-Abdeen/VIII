<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Team;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use App\User;

use Illuminate\Http\Request;

class TeamController extends Controller
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
            $teams = Team::where('name', 'LIKE', '%'.$q.'%')->get();
            return response()->json(['data' => ['users' => $teams]]);
        } else {
            $teams = Team::paginate(10);
            return response()->json(['data' => ['users' => $teams]]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('data');
        $data = Arr::add($data, 'creator_id', Auth::id());

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:25'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $team = Team::create($data);
            return response()->json(['data' => $team]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::find($id);
        return response()->json(['data' => $team]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input('data');

        $validator = Validator::make($data, [
            'name' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $team = Team::find($id);
            $team->name = $data['name'];
            $team->save();
            return response()->json(['data' => 'updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::find($id)->delete();

        return response()->json(['data' => 'deleted']);
    }
}
