<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DebugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$line = DB::table('line')->get(['name', DB::raw("ST_AsText(`line`) as loc")]);
        $crossings = DB::table('crossings')->get(['id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lng")]);
        $station = DB::table('station')->get(['crs as id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lng")]);

        return json_encode([$station, $crossings]);
    }

}
