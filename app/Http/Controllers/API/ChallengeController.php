<?php

namespace App\Http\Controllers\API;

use App\Challenge;
use App\ChallengesChapters;
use App\ChallengeStatistics;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class ChallengeController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendedChallenges(Request $request)
    {
        $user_id = Auth::id();
        $challenges = Challenge::where('sender_id', $user_id)->where('reciver_status', 1)->get();
        if ($challenges) {
            return response()->json(['data' => $challenges]);
        } else {
            return response()->json(['data' => null]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recivedChallenges(Request $request)
    {
        $user_id = Auth::id();
        $challenges = Challenge::where('reciver_id', $user_id)->where('reciver_status', 1)->get();
        if ($challenges) {
            return response()->json(['data' => $challenges]);
        } else {
            return response()->json(['data' => null]);
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
        $data = Arr::add($data, 'sender_id', Auth::id());
        $data = Arr::add($data, 'reciver_status', 1);

        $validator = Validator::make($data, [
            'difficulty' => ['required', 'integer', 'in:1,2'],
            'reciver_id' => ['required', 'integer'],
            'matrial_id' => ['required', 'integer'],
            'chapters_ids' => ['required', 'array'],
            'sender_id' => ['required', 'integer'],
            'challenge_type' => ['required', 'integer', 'in:1,2']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $challenge = Challenge::create($data);
            ChallengeStatistics::create([
                'challenge_id' => $challenge->id
            ]);

            $chapters = $data['chapters_ids'];
            foreach ($chapters as $chapter_id) {
                ChallengesChapters::create([
                    'challenge_id' => $challenge->id,
                    'chapter_id' => $chapter_id
                ]);
            }

            switch ($challenge->challenge_type) {
                case 1:
                    print('1');
                    // event to the reciver
                    break;
                case 2:
                    print('2');
                    // evet to the reciver team creator and team members
                    break;
            }
            return response()->json([
                'data' => [
                    'challenge' => $challenge,
                    'chapters' => $challenge->chapters,
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_id = Auth::id();
        $challenge = Challenge::find($id);
        if ($user_id == $challenge->user_id or $user_id == $challenge->reciver_id) {
            $chapters = $challenge->chapters;
            foreach ($chapters as $chapter) {
                $chapter->chapter;
            }
            return response()->json(['data' => $challenge]);
        } else {
            return response()->json(['data' => ['errors' => 'anonymous']]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input('data');
        $user_id = Auth::id();

        $validator = Validator::make($data, [
            'reciver_status' => ['required', 'integer', 'in:1,2,3,4'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $challenge = Challenge::find($id);
            if ($user_id == $challenge->reciver_id) {
                $status = $data['reciver_status'];
                switch ($status) {
                    case 2:
                        $challenge->reciver_status = $status;
                        $challenge->save();
                        // event
                        // $challenge->chapters()->detach();
                        ChallengesChapters::where('challenge_id', $challenge->id)->delete();
                        // $challenge->statistics()->detach();
                        ChallengeStatistics::where('challenge_id', $challenge->id)->delete();
                        $challenge->delete();
                        return response()->json(['data' => 'challenge rejected']);
                        break;
                    case 3:
                        $challenge->status = $status;
                        $challenge->save();
                        $statistics = $data['challenge_statistics'];
                        $challenge_statistics = $challenge->statistics;
                        $challenge_statistics->reciver_correct_answers = $statistics['correct_answers'];
                        $challenge_statistics->reciver_wrong_answers = $statistics['wrong_answers'];
                        $challenge_statistics->save();
                        if (
                            $challenge_statistics->reciver_correct_answers
                            >
                            $challenge_statistics->sender_correct_answers
                        ) {
                            $challenge_statistics->winner_id == $user_id;
                            $challenge_statistics->save();
                            // event to sender [loser]
                            return response()->json(['data' => ['statistics' => $challenge_statistics, 'winner' => true]]);
                        } elseif (
                            $challenge_statistics->reciver_correct_answers
                            <
                            $challenge_statistics->sender_correct_answers
                        ) {
                            $challenge_statistics->winner_id == $challenge->sender_id;
                            $challenge_statistics->save();
                            // event to sender [winner]
                            return response()->json(['data' => ['statistics' => $challenge_statistics, 'winner' => false]]);
                        } else {
                            $challenge_statistics->winner_id == 0;
                            $challenge_statistics->save();
                            // event to sender [drow]
                            return response()->json(['data' => ['statistics' => $challenge_statistics, 'winner' => null]]);
                        }
                        break;
                }
            }
            if ($user_id == $challenge->sender_id) {
                $statistics = $data['challenge_statistics'];
                $challenge_statistics = $challenge->statistics;
                $challenge_statistics->reciver_correct_answers = $statistics['correct_answers'];
                $challenge_statistics->reciver_wrong_answers = $statistics['wrong_answers'];
                $challenge_statistics->save();
                return response()->json(['data' => ['statistics' => $challenge_statistics]]);
            }
        }
    }
}
