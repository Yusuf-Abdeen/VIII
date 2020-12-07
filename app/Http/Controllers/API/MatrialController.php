<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Matrial;
use Illuminate\Http\Request;

class MatrialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matrilas = Matrial::where('deleted_at', null)->get();
        if ($matrilas) {
            return response()->json(['data' => $matrilas]);
        } else {
            return response()->json(['data' => null]);
        }
    }
}
