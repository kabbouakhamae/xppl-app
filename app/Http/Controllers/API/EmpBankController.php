<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpBankController extends Controller
{
    public function data($id){
        $data = DB::table('emp_bank_account')
                    ->where('userid', $id)
                    ->get();
        
        return $data;
    }

    public function add(Request $request){
        $check = DB::table('emp_bank_account')
                    ->where('userid', $request->userid)
                    ->where('account_no', $request->accno);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {

            DB::table('emp_bank_account')->insert([
                'userid' => $request->userid,
                'bank_name' => $request->bankname,
                'branch' => $request->branch,
                'account_name' => $request->accname,
                'account_no' => $request->accno,
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
        $contract = DB::table('emp_bank_account')->find($id);
        return $contract;
    }

    public function update(Request $request){
        DB::table('emp_bank_account')
            ->where('id', $request->id)
            ->update([
                'bank_name' => $request->bankname,
                'branch' => $request->branch,
                'account_name' => $request->accname,
                'account_no' => $request->accno,
                'remarks' => $request->remarks
                
            ]);
    }

    public function delete($id){
        DB::delete('delete from emp_bank_account where id = ?', [$id]);
    }

}
