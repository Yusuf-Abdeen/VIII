<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Quetion;
use App\Matrial;
use App\Chapter;

class QuetionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($matrial_id, $chapter_id)
    {
        $matrial = Matrial::find($matrial_id);
        if ($matrial) {
            $chapter = Chapter::find($chapter_id);
            if ($chapter) {
                $quetions = Quetion::where('matrial_id', $matrial_id)->where('chapter_id', $chapter_id);
                if ($quetions) {
                    return response()->json(['data' => $quetions]);
                } else {
                    return response()->json(['data' => null]);
                }
            } else {
                return response()->json(['data' => null]);
            }
        } else {
            return response()->json(['data' => null]);
        }
    }
}
