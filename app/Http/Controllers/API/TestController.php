<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class TestController extends Controller
{
   // public function dept(Request $request){
    //     $param = $request->name;
    //     $dept =DB::select('exec uspDept ?', [$param]);
    //     return $dept;
    // }

    // public function addfile(Request $request){

    //     if($request->file('file')){
    //         $upload_path = "assets/img";
    //         $generate_new_img = 'store-'.time().'.'.$request->file->getClientOriginalExtension();
    //         $image = $request->file('file');
    //         $img = Image::make($image->getRealpath());
    //         $img->resize(
    //             800, null, function($constraint){
    //                 $constraint->aspectRatio();
    //             });
    //         $img->save($upload_path.'/'.$generate_new_img);  // ບັນທຶກຂື້ນ Server

    //     } else {
    //         $generate_new_img = 'no pic';
    //     }

    //     DB::insert('exec userAddFile ?', [$generate_new_img]);
    // }

    public function addfile(Request $request){

        // if($request->file('file')){
        //     $upload_path = "assets/img/emp";
        //     $generate_new_img = $request->userid.'_'.time().'.'.$request->file->getClientOriginalExtension();
        //     $image = $request->file('file');
        //     $img = Image::make($image->getRealpath());
        //     $img->resize(
        //         800, null, function($constraint){
        //             $constraint->aspectRatio();
        //         });
        //     $img->save($upload_path.'/'.$generate_new_img);  // ບັນທຶກຂື້ນ Server

        // } else {
        //     $generate_new_img = 'no pic';
        // }
        
        if($request->hasFile('file')){
            $filename = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move('assets/files/', $filename);
        } else {
            $filename = 'no file';
        }


        
        
        $param = [
            $filename
        ];
        DB::insert('exec userAddFile ?', $param);
    }

    public function images(Request $request){
        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file){

                $filename = $file->getClientOriginalName();
                $file->move(public_path('assets/files/'), $filename);

                DB::insert('exec userAddFile ?', [$filename]);
            }
        }
    }


    public function file(){
        $file = DB::select("select * from files where files is not null");
        return $file;
    }

    public function download($file){

        return response()->download(public_path('assets/files/'.$file));

    }

    public function deleteFile($file){
        DB::delete('delete from files where files = ?', [$file]);

        if(file_exists(public_path('assets/files/'.$file))){
            unlink(public_path('assets/files/'.$file));
        }
    }

    public function getVal()
    {
        $value = DB::table('test')->get();
        return $value;
    }

    public function tests()
    {
        $data = DB::select('select * from emp_names');

        return $data;
    }

    public function multi(Request $request){


        $data = DB::table('emp_names')
                    ->whereIn('name', $request)
                    ->get();

        
        return $data;

        // $parm = ".$request.";
        // $parm = "'chamlong','Phoukhiaw','Thipphanom'";

        // $object = (object) $request;
        // $data =DB::select("select * from emp_names where name in($object)");
        // return $data;
    }
}
