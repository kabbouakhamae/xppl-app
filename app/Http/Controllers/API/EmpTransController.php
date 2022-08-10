<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpTransController extends Controller
{
    public function out(Request $request){
        $userid = auth()->user()->userid;
        $date = $request->date;

        $out = DB::select('exec uspEmpTranOutbound ?, ?', [$userid, $date]);
        return $out;
    }

    public function in(Request $request){
        $userid = auth()->user()->userid;
        $date = $request->date;

        $in = DB::select('exec uspEmpTranInbound ?, ?', [$userid, $date]);
        return $in;
    }

    public function pickup(Request $request){
        DB::table('emp_details')
            ->where('id', $request->id)
            ->update([
                'pickup' => $request->pickup
            ]);
    }

    public function dropoff(Request $request){
        DB::table('emp_details')
            ->where('id', $request->id)
            ->update([
                'dropoff' => $request->dropoff
            ]);
    }
}
