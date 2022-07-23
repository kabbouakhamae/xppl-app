<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;    // ໂຕກວດຊອບ ການເຂົ້າລະບົບ
use Illuminate\Support\Facades\Hash;    // ໂຕຊ່ວຍ ເຂົ້າລະຫັດ ລະຫັດຜ່ານ
use App\Models\User;                    // import Model User ເຂົ້າມາໃຊ້
use Session;                            // import Session ເພື່ອທຳການ ອອກຈາກລະບົບ

class UserController extends Controller
{
    //
    public function signUp(Request $request){
        try{
            $userCheck = User::where('userid', $request->userid);
            if($userCheck->count()){  /// ກວດຊອບອີເມວໃນຖານຂໍ້ມູນ
                $success = false;
                $message = "This employee already sign up!";
            } else {  // ບໍ່ມີອີເມວ
                $user = new User();
                $user->userid = $request->userid;
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->save();

                $success = true;
                $message = "Sign up completed!";
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


    public function signIn(Request $request){
        $check_name_pass_login = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if(Auth::attempt($check_name_pass_login)){
                $success = true;
                $message = "Sign in completed!";
        } else {
                $success = false;
                $message = "Incorrect name or password!";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function signOut(){
        Session::flush();  // ທຳລາຍ Session ເພື່ອອອກຈາກລະບົບ
        $success = true;
        $message = "Sign out completed!";

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function profile(){
        $id = auth()->user()->userid;
        $profile = DB::select('exec uspProfile ?', [$id]);

        // $profile = DB::table('emp_details as a')
        //             ->select('a.*')
        //             ->join(DB::raw('(select userid, max(id) as mxid From emp_details Group by userid) as b'),
        //                 function($join){
        //                     $join->on('a.id', 'b.mxid');
        //                 })
        //             ->where('a.userid', $id)
        //             ->first();
        
        
        
        return $profile;
    }

    // public function profile(){
    //     $id = auth()->user()->userid;
    //     $data = DB::table('emp_names as a')
    //                 ->join('users as b', 'a.id','b.userid')
    //                 ->select('a.gender', 'a.name', 'a.surname', 'a.photo', 'b.username', 'b.usertype', 'b.department')
    //                 ->where('a.id', $id)
    //                 ->first();
        
    //     if ($data->surname != null && $data->surname != ""){
    //         $fullname = $data->name." ".$data->surname;
    //     } else {
    //         $fullname = $data->name;
    //     }

    //     $result =[
    //         'fullname' => $fullname,
    //         'gender' => $data->gender,
    //         'name' => $data->name,
    //         'photo' => $data->photo,
    //         'username' => $data->username,
    //         'usertype' => $data->usertype,
    //         'dept' => $data->department,
    //     ];
    //     return $result;
    // }


}
