<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FingerscanController extends Controller
{
    public function summary(Request $request){

        $param = [
            $request->dept,
            $request->date,
            $request->search.'%'
        ];
        
        $summary = DB::select('exec uspEmpScanSummary ?, ?, ?', $param);
        return $summary;
    }

    public function detail(Request $request){
        $param = [
            $request->dept,
            $request->date,
            $request->userid
        ];

        $detail = DB::select('exec uspEmpScanDetail ?, ?, ?', $param);
        return $detail;
    }

    public function acLog(Request $request){
        $param = [
            $request->date,
            $request->userid
        ];

        $aclog = DB::select('exec uspEmpScanAcLog ?, ?', $param);
        return $aclog;
    }

    public function header(Request $request){
        $param = [
            $request->datefr,
            $request->dateto
        ];
        
        $dead = DB::select('exec uspEmpScanSummaryHead ?, ?', $param);
        return $dead;
    }

    public function summary2(Request $request){
        $param = [
            $request->dept,
            $request->datefr,
            $request->dateto,
            $request->search.'%'
        ];
        
        $summary = DB::select('exec uspEmpScanSummary2 ?, ?, ?, ?', $param);
        return $summary;
    }
}
