<?php

namespace App\Http\Controllers\API;

use App\Test;
use App\Matrial;
use App\Chapter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class TestController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testStatements = Auth::user()->testStatements;
        if ($testStatements === null) {
            return response()->json(['data' => $testStatements]);
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
        $data = Arr::add($data, 'user_id', Auth::id());

        $validator = Validator::make($data, [
            'stars' => ['required', 'integer', 'in:1,2,3'],
            'matrial_id' => ['required', 'integer'],
            'chapter_id' => ['required', 'integer']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $matrial = Matrial::find($data['matrial_id']);
            if ($matrial) {
                $chapter = Chapter::find($data['chapter_id']);
                if ($chapter) {
                    $testStatement = Test::create($data);
                    return response()->json(['data' => $testStatement]);
                } else {
                    return response()->json(['data' => null]);
                }
            } else {
                return response()->json(['data' => null]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $testStatement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $statement = Test::find($id);
        return response()->json(['data' => $statement]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $testStatement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input('data');

        $validator = Validator::make($data, [
            'stars' => ['required', 'integer'],
            'correct_answers' => ['required', 'integer'],
            'wrong_answers' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => ['errors' => $validator->errors()]]);
        } else {
            $statement = Test::find($id);
            if ($statement) {
                $statement->stars = $data['stars'];
                $statement->correct_answers = $data['correct_answers'];
                $statement->correct_answers = $data['wrong_answers'];
                $statement->save();
                return response()->json(['data' => 'updated']);
            } else {
                return response()->json(['data' => null]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $testStatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->input('data');
        foreach ($data['statements'] as $statement) {
            $statement = Test::find($statement);
            if ($statement) {
                $statement->delete;
            }
        }

        return response()->json(['cleared']);
    }
}
