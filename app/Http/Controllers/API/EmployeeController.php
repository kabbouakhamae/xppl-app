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

    public function addNew(Request $request){
        try{
            $checkName = DB::table('emp_names')
                        ->where('name', $request->name)
                        ->Where('surname', $request->surname); 
            if ($checkName->count()){
                $success = false;
                $message = "This name already use!";
            } else {

                if($request->file('file')){
                    $upload_path = "assets\img";
                    $generate_new_img = 'emp-'.time().'.'.$request->file->getClientOriginalExtension();
                    $image = $request->file('file');
                    $img = Image::make($image->getRealpath());
                    $img->resize(
                        800, null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    $img->save($upload_path.'/'.$generate_new_img);  // ບັນທຶກຂື້ນ Server

                } else {
                    $generate_new_img = 'No pic';
                }


                $param = [
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
                    $request->employeeid,
                    $request->scanid,
                    $request->foodid,
                    $request->roster,
                    $request->scantimes,
                    $request->hours,
                    $request->site,
                    $request->dept,
                    $request->section,
                    $request->crew,
                    $generate_new_img
                ];
                DB::insert('exec uspAddNewEmp ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $param);

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

    public function edit($id){
        $edit = DB::select('select * from emp_names where user_id = ?', [$id]);
        return $edit;
    }


    public function preview($user_id){
        $empPrev = DB::select('exec uspEmpPreview ?', [$user_id]);
        return $empPrev;
    }

    public function delete($user_id){
        DB::delete('delete from emp_names where user_id = ?', [$user_id]);
    }


}
