<?php

namespace App\Http\Controllers;

use App\Team;
use App\TeamMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamMembersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('data');

        $validator = Validator::make($data, [
            'team_id' => ['required', 'integer'],
            'member_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $member = TeamMembers::create($data);
            return response()->json(['data' => $member]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamMembers  $teamMembers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TeamMembers::find($id)->delete();
        return response()->json(['data' => 'deleted']);
    }
}
