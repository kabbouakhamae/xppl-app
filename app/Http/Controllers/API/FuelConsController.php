<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelConsController extends Controller
{
    public function date(Request $request){
        $mont = $request->mont;
        $year = $request->year;

        $date = DB::select("select * from fuel_date where format(rdate,'MMMM') = ? and year(rdate) = ?", [$mont, $year]);

        return $date;
    }

    public function head(Request $request){
        $head = DB::table('fuel_header')
                    ->where('rdate', $request->date)
                    ->get();

        return $head;
    }
}
