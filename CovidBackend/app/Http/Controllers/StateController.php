<?php

namespace App\Http\Controllers;

use App\State;
use App\Cases;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = State::select("id" , "name as text")->get();
        return response()->json($data);
    }

}
