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

    public function rosCodeAdd(Request $request){
        $check = DB::table('lookup_roster')
                    ->where('rcode', $request->rcode);

        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {
            DB::table('lookup_roster')
                ->insert([
                    'rcode' => $request->rcode,
                    'ref_code' => $request->ref_code,
                    'descr_eng' => $request->descr_eng,
                    'descr_lao' => $request->descr_lao,
                    'working_time' => $request->working_time,
                ]);

            $success = true;
            $message = "Insert completed!";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function rosCodeEdit($id){
        $result = DB::table('lookup_roster')->find($id);
        return $result;
    }

    public function rosCodeUpd(Request $request){
        DB::table('lookup_roster')
            ->where('id', $request->id)
            ->update([
                'rcode' => $request->rcode,
                'ref_code' => $request->ref_code,
                'descr_eng' => $request->descr_eng,
                'descr_lao' => $request->descr_lao,
                'working_time' => $request->working_time,
                'used' => $request->used
            ]);
    }

    public function rosCodeDel($id){
        DB::delete('delete from lookup_roster where id = ?', [$id]);
    }

    
}
