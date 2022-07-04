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
            $userCheck = User::where('username',$request->username);
            if($userCheck->count()){  /// ກວດຊອບອີເມວໃນຖານຂໍ້ມູນ
                $success = false;
                $message = "This username already used!";
            } else {  // ບໍ່ມີອີເມວ
                $user = new User();
                $user->user_id = $request->fullname;
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->save();

                $success = true;
                $message = "Sign up completed!";
            }
        } catch (\Illnminate\Database\QueryException $ex) {
            //throw $th;
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


}
