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
        $name = DB::select('exec uspEmpName');
        return $name;
    }

    public function relate(){
        $relate = DB::select("select code as value, code as label from lookup_code where category = 'Relationship' and used = 'y'");
        return $relate;
    }

    public function bank(){
        $bank = DB::select("select code as value, code as label from lookup_code where category = 'Bank Name' and used = 'y'");
        return $bank;
    }

    public function card(){
        $card = DB::select("select code as value, code as label from lookup_code where category = 'Card Type' and used = 'y'");
        return $card;
    }

    public function year(){
        $year = DB::select("select code as value, code as label from lookup_code where category = 'year' and used = 'y'");
        return $year;
    }

    public function month(){
        $month = DB::select("select code as value, code as label from lookup_code where category = 'month' and used = 'y' order by id");
        return $month;
    }

    public function fueldept(){
        $fdept = DB::select("select code as value, code as label from fuel_lookup where category in('cost center', 'io') and used = 1 order by code");
        return $fdept;
    }

    public function costtype(){
        $ftype = DB::select("select code as value, code as label from fuel_lookup where category = 'cost type' and used = 1 order by code");
        return $ftype;
    }

    public function costno(Request $request){
        $costno = DB::table('fuel_lookup')
                        ->select(DB::raw('cast(descr as float) as value, category'))
                        ->where('code', $request->dept)
                        ->where('used', '1')
                        ->first();
        return $costno;
    }

    public function wbs(Request $request){
        $wbs = DB::select("select code as value, code as label from fuel_lookup where category ='wbs' and used = 1 and dept = ?", [$request->dept]);
        return $wbs;
    }

    public function approve(Request $request){
        $approve = DB::select("select code as value, code as label from fuel_lookup where category ='approve by' and used = 1 and dept = ?", [$request->dept]);
        return $approve;
    }

    public function equipno(){
        $equip = DB::select('select equip_no as value, equip_no as label from fuel_equipments order by equip_no');
        return $equip;
    }

    public function material(){
        $material = DB::select("select code as value, descr as label from fuel_lookup where category = 'material code'");
        return $material;
    }

    public function equipdescr(Request $request){
        $equip_descr = DB::table("fuel_equipments")
                    ->where('equip_no', $request->equipno)
                    ->first();
        
        return $equip_descr;
    }

    public function workorder(Request $request){
        $workorder = DB::table('fuel_workorders')
                        ->where('equip_no', $request->equipno)
                        ->where('year_mont', $request->yearmont)
                        ->first();

        return $workorder;
    }

}
