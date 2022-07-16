<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeController extends Controller{

    public function paginateArray($data, $perPage = 8){
        $page = Paginator::resolveCurrentPage();
        $total = count($data);
        $results = array_slice($data, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }
    
    public function index(Request $request){
        // $param1 = auth()->user()->department;
        $param2 = $request->search.'%';
        // $param3 = $request->search.'%';
        // $param3 = '%'.$request->search.'%';

        $emp = $this->paginateArray(
            DB::select('exec uspEmployeeList ?', [$param2])
        );
        return $emp;
    }

    public function newUserid(){
        $userid = DB::select("exec uspEmpNewUserid");
        return $userid;
    }

    public function empInsert(Request $request){
        try{
            $checkName = DB::table('emp_names')
                        ->where('name', $request->name)
                        ->Where('surname', $request->surname); 
            if ($checkName->count()){
                $success = false;
                $message = "This name already in database!";
            } else {

                if($request->hasFile('file')){
                    $filename = $request->userid.'-'.time().'.'.$request->file->getClientOriginalExtension();
                    $request->file->move('assets/img/profile/', $filename);
                } else {
                    $filename = null;
                }

                $param = [
                    $request->userid,
                    $request->gender,
                    $request->name,
                    $request->surname,
                    $request->phone,
                    $request->namelao,
                    $request->surnamelao,
                    $request->birthday,
                    $request->email,
                    $request->country,
                    $request->province,
                    $request->district,
                    $request->village,
                    $request->startdate,
                    $request->enddate,
                    $request->position,
                    $request->status,
                    $request->contract,
                    $request->levels,
                    $request->empid,
                    $request->scanid,
                    $request->foodid,
                    $request->roster,
                    $request->scantimes,
                    $request->hours,
                    $request->site,
                    $request->dept,
                    $request->section,
                    $request->crew,
                    $filename
                ];
                DB::insert('exec uspEmpInsert ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $param);

                $success = true;
                $message = "Insert completed!";
            }
        } catch (\Illnminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function empUpdate(Request $request){
        if($request->hasFile('file')){
            if($request->imageName != "" && $request->imageName){
                if(file_exists('assets/img/profile/'.$request->imageName)){
                    unlink('assets/img/profile/'.$request->imageName);
                }
            }

            $filename = $request->userid.'-'.time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move('assets/img/profile/', $filename);
        } else {
            $filename = 'no pic';
        }

        $param = [
            $request->userid,
            $request->gender,
            $request->name,
            $request->surname,
            $request->phone,
            $request->namelao,
            $request->surnamelao,
            $request->birthday,
            $request->email,
            $request->country,
            $request->province,
            $request->district,
            $request->village,
            $filename
        ];
        DB::update("exec uspEmpUpdate ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $param);
    }

    public function edit($userid){
        $edit = DB::select('select * from emp_names where userid = ?', [$userid]);
        return $edit;
    }

    public function preview($userid){
        $empPrev = DB::select('exec uspEmpPreview ?', [$userid]);
        return $empPrev;
    }

    public function delete($userid){
            $images = DB::table('emp_names')
                    ->where('userid',$userid)
                    ->first();
        
        // return $images->images;
        
        if($images->images != "" && $images->images){
            if(file_exists('assets/img/profile/'.$images->images)){
                unlink('assets/img/profile/'.$images->images);
            }
        }
        // DB::delete('delete from emp_names where userid = ?', [$userid]);
        DB::table('emp_names')->where('userid', $userid)->delete();

    }

    public function detail($userid){
        // $details = DB::select('select * from emp_details');
        $details = DB::select('select * from emp_details where userid = ?', [$userid]);
        return $details;
    }

    public function editDetail($id){
        $details = DB::select('select * from emp_details where id = ?', [$id]);
        return $details;
    }


}
