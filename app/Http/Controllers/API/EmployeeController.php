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
        $name = $request->search.'%';
        $namelao = $request->search.'%';

        $userid = auth()->user()->userid;
        $data = DB::table('permission')->where('userid', $userid)->first();

        if ($data->emp_list == 1){
            $dept = '%';
        } else {
            
            $deptData = DB::table('emp_details as a')
                            ->select('a.department')
                            ->join(DB::raw('(select max(id) as mxid, userid from emp_details group by userid) as b'),
                                function($join){
                                    $join->on('a.id', 'b.mxid');
                                })
                            ->where('a.userid', $userid)
                            ->first();

            $dept = $deptData->department;
        }

        $empList = $this->paginateArray(
            DB::select('exec uspEmpList ?, ?, ?', [$name, $namelao, $dept])
        );
        return $empList;
    }

    public function add(Request $request){
        try{
            $checkName = DB::table('emp_names')
                        ->where('name', $request->name)
                        ->Where('surname', $request->surname); 
            if ($checkName->count()){
                $success = false;
                $message = "This name already in database!";
            } else {

                $maxUserid = DB::table('emp_names')->max('id');
                $newUserid = $maxUserid + 1;

                if($request->hasFile('photo')){
                    $filename = $newUserid.'-'.time().'.'.$request->photo->getClientOriginalExtension();
                    $request->photo->move('assets/img/profile/', $filename);
                } else {
                    $filename = null;
                }

                // Insert to employee names
                DB::table('emp_names')->insert([
                    'id' => $newUserid,
                    'gender' => $request->gender,
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'namelao' => $request->namelao,
                    'surnamelao' => $request->surnamelao,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'birthday' => $request->birthday,
                    'country' => $request->country,
                    'province' => $request->province,
                    'district' => $request->district,
                    'village' => $request->village,
                    'photo' => $filename
                ]);
                
                // Insert to employee details
                DB::table('emp_details')->insert([
                    'userid' => $newUserid,
                    'startdate' => $request->startdate,
                    'enddate' => $request->enddate,
                    'position' => $request->position,
                    'status' => $request->status,
                    'site' => $request->site,
                    'department' => $request->dept,
                    'section' => $request->section,
                    'crew' => $request->crew,
                    'empid' => $request->empid,
                    'scanid' => $request->scanid,
                    'foodid' => $request->foodid,
                    'roster' => $request->roster,
                    'scantimes' => $request->scantimes,
                    'working_hrs' => $request->hours,
                    'levels' => $request->levels,
                    'contract' => $request->contract
                ]);

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

    public function update(Request $request){
        if($request->hasFile('photo')){
            $data = DB::table('emp_names')->find($request->id);

            if($data->photo != '' && $data->photo != null){
                if(file_exists('assets/img/profile/'.$data->photo)){
                    unlink('assets/img/profile/'.$data->photo);
                }
            }

            $filename = $request->id.'-'.time().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move('assets/img/profile/', $filename);
        } else {
            $filename = 'no pic';
        }

        $param = [
            $request->id,
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

    public function edit($id){
        $edit = DB::table('emp_names')->find($id);
        return $edit;            
    }

    public function preview($userid){
        $empPrev = DB::select('exec uspEmpPreview ?', [$userid]);
        return $empPrev;
    }

    public function delete($id){
        $data = DB::table('emp_names')->find($id);

        if($data->photo != '' && $data->photo != null){
            if(file_exists('assets/img/profile/'.$data->photo)){
                unlink('assets/img/profile/'.$data->photo);
            }
        }
        DB::delete('delete from emp_names where id = ?', [$id]);
    }

    public function detail($id){
        $detail = DB::select('select * from emp_details where userid = ?', [$id]);
        return $detail;
    }

    public function detailAdd(Request $request){
        $check = DB::table('emp_details')
                        ->where('userid', $request->userid)
                        ->where('startdate', $request->startdate);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {

            DB::table('emp_details')->insert([
                'userid' => $request->userid,
                'startdate' => $request->startdate,
                'enddate' => $request->enddate,
                'position' => $request->position,
                'status' => $request->status,
                'site' => $request->site,
                'department' => $request->dept,
                'section' => $request->section,
                'crew' => $request->crew,
                'empid' => $request->empid,
                'scanid' => $request->scanid,
                'foodid' => $request->foodid,
                'roster' => $request->roster,
                'scantimes' => $request->scantimes,
                'working_hrs' => $request->hours,
                'levels' => $request->levels,
                'contract' => $request->contract,
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

    public function detailEdit($id){
        $detail = DB::table('emp_details')->find($id);
        return $detail;
    }

    public function detailUpdate(Request $request){
        
        $param = [
            $request->id,
            $request->startdate,
            $request->enddate,
            $request->position,
            $request->status,
            $request->site,
            $request->dept,
            $request->section,
            $request->crew,
            $request->empid,
            $request->scanid,
            $request->foodid,
            $request->roster,
            $request->scantimes,
            $request->hours,
            $request->levels,
            $request->contract,
            $request->remarks
        ];

        DB::update("exec uspEmpDetailUpdate ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", $param);

    }

    public function detailDel($id){
        DB::delete('delete from emp_details where id = ?', [$id]);
    }


}
