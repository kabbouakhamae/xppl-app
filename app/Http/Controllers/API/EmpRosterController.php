<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpRosterController extends Controller
{
    public function rosCode(){
        $rosCode = DB::select('select * from lookup_roster where used = 1 order by ref_code, rcode');
        return $rosCode;
    }

    public function rosCodeEdit($id){
        $result = DB::table('lookup_roster')->find($id);
        return $result;
    }
}
