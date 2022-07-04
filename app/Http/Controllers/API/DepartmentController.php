<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Modeles\User;


class DepartmentController extends Controller
{
    public function paginateArray($data, $perPage = 9)
    {
        $page = Paginator::resolveCurrentPage();
        $total = count($data);
        $results = array_slice($data, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }

    public function department(){
        $dept = DB::select('select department as value, department as label from department');
        return $dept;
    }

    // public function employee(Request $request){
    //     $param =[$request->department];
    //     $emp = DB::select('exec uspEmp ?', $param)
    //         ->paginate(10)
    //         ->toArray();
    //     return array_reverse($emp);
    // }

    public function employee(Request $request)
    {
        // $Search = \Request::get('search'); // ຄົ້ນຫາ

        $param1 = auth()->user()->department;
        $param2 = $request->search.'%';
        $param3 = $request->search.'%';
        // $param3 = '%'.$request->search.'%';

        $store = $this->paginateArray(
            DB::select("select * from emp_names where dept =? and (name like ? or namelao like ?)", [$param1, $param2, $param3])
        );
        return $store;
    }

    public function test1(Request $request){
        $param = $request->id;
        $list1 = DB::select("select * from emp where id=?",[$param]);
        return $list1;
    }

    public function test2(Request $request){
        $param = $request->id;
        $list2 = DB::select('select * from test where id=?',[$param]);
        return $list2;
    }

    public function insertName(Request $request){
        try {
            $checkName = DB::table('names')
                        ->where('name', $request->name)
                        ->Where('surname', $request->surname); 

            if ($checkName->count()){

                $success = false;
                $message = "This name already use!";

            } else {

                $param = [
                    $request->name,
                    $request->surname,
                    $request->nameLao,
                    $request->surnameLao,
                ];
                DB::insert('exec uspInsertName ?, ?, ?, ?', $param);

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
   
}
