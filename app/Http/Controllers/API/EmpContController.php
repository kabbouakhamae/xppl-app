<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpContController extends Controller
{
    public function data($id){
        $data = DB::table('emp_contact_person')
                    ->where('userid', $id)
                    ->get();
        
        return $data;
    }

    public function add(Request $request){
        $check = DB::table('emp_contact_person')
                    ->where('userid', $request->userid)
                    ->where('person', $request->person);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {

            DB::table('emp_contact_person')->insert([
                'userid' => $request->userid,
                'person' => $request->person,
                'relationship' => $request->relate,
                'phone' => $request->phone,
                'address' => $request->address
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
        $contract = DB::table('emp_contact_person')->find($id);
        return $contract;
    }

    public function update(Request $request){
        DB::table('emp_contact_person')
            ->where('id', $request->id)
            ->update([
                'person' => $request->person,
                'relationship' => $request->relate,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
    }

    public function delete($id){
        DB::delete('delete from emp_contact_person where id = ?', [$id]);
    }
}
