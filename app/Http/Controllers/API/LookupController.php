<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LookupController extends Controller
{
    public function country(){
        $country = DB::select("select code as value, code as label from lookup_code where category ='country' and used ='y'");
        return $country;
    }

    public function position(){
        $position = DB::select("select code as value, code as label from lookup_code where category ='position' and used ='y'");
        return $position;
    }

    public function status(){
        $status = DB::select("select code as value, code as label from lookup_code where category ='employee status' and used ='y'");
        return $status;
    }

    public function contract(){
        $contract = DB::select("select code as value, code as label from lookup_code where category ='contract' and used ='y'");
        return $contract;
    }

    public function levels(){
        $levels = DB::select("select code as value, code as label from lookup_code where category ='levels' and used ='y'");
        return $levels;
    }

    public function roster(){
        $roster = DB::select("select code as value, code as label from lookup_code where category ='roster' and used ='y'");
        return $roster;
    }

    public function scantimes(){
        $scantimes = DB::select("select code as value, code as label from lookup_code where category ='scan times' and used ='y'");
        return $scantimes;
    }

    public function site(){
        $site = DB::select("select code as value, code as label from lookup_code where category ='site' and used ='y'");
        return $site;
    }

    public function dept(){
        $dept = DB::select("select department as value, department as label from department");
        return $dept;
    }

    public function section(){
        $section = DB::select("select code as value, code as label from lookup_code where category ='section' and used ='y'");
        return $section;
    }
    public function crew(){
        $crew = DB::select("select code as value, code as label from lookup_code where category ='crew' and used ='y'");
        return $crew;
    }

    public function name(){
        $nameList = DB::select('exec uspNamelist');
        return $nameList;
    }



}
