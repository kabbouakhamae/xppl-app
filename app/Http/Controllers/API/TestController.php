<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use DB;

use Illuminate\Support\Facades\Storage;
use File;
use Response;
// use App\Images;


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


}
