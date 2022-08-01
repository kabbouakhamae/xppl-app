<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpAnnualController extends Controller
{
    public function data($id){
        $data = DB::table('emp_remain_al')
                    ->where('userid', $id)
                    ->get();
        
        return $data;
    }

    public function add(Request $request){
        $check = DB::table('emp_remain_al')
                    ->where('userid', $request->userid)
                    ->where('years', $request->years);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {

            DB::table('emp_remain_al')->insert([
                'userid' => $request->userid,
                'years' => $request->years,
                'remain' => $request->remain,
                'remarks' => $request->remarks
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

    public function edit($id){
        $contract = DB::table('emp_remain_al')->find($id);
        return $contract;
    }

    public function update(Request $request){
        DB::table('emp_remain_al')
            ->where('id', $request->id)
            ->update([
                'years' => $request->years,
                'remain' => $request->remain,
                'remarks' => $request->remarks
            ]);
    }

    public function delete($id){
        DB::delete('delete from emp_remain_al where id = ?', [$id]);
    }

}
