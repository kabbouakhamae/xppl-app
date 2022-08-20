<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelConsController extends Controller
{
    public function date(Request $request){
        $mont = $request->mont;
        $year = $request->year;
        $cdate = date('Y-m-d');

        $date = DB::select("select * from calendar where format(calendar,'MMMM') = ? and year(calendar) = ? and calendar <= ?", [$mont, $year, $cdate]);
        return $date;
    }

    public function header(Request $request){
        $userid = auth()->user()->userid;

        if ($request->permiss == 1){
            $header = DB::table('fuel_headers')
                        ->where('date', $request->date)
                        ->orderBy('id')
                        ->get();
        } else {
            $header = DB::table('fuel_headers')
                        ->where('date', $request->date)
                        ->where('dept', $request->dept)
                        ->orderBy('id')
                        ->get();
        }

        return $header;
    }

    public function detail(Request $request){
        $det = DB::table('fuel_details as a')
                    ->join('fuel_lookup as b', 'a.material', 'b.code')
                    ->where('a.headid', $request->headid)
                    ->where('b.category', 'material code')
                    ->select(DB::raw("a.id, a.equip_no, a.equip_descr, a.refuel_date, a.shift, a.refuel_by, a.remarks, format(a.smu, '0') as smu, a.driver, format(a.liter, '0.00') as liter, b.descr as material_descr, format(a.reserve_no, '0') as reserve_no, format(work_order,'0') as work_order"))
                    ->orderBy('id')
                    ->get();

        return $det;
    }

    public function headadd(Request $request){
        $check = DB::table('fuel_headers')
                    ->where('date', $request->date)
                    ->where('dept', $request->dept)
                    ->where('dept_use', $request->deptuse)
                    ->where('cost_type', $request->costtype)
                    ->where('cost_no', $request->costno);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {

            DB::table('fuel_headers')->insert([
                'date' => $request->date,
                'dept' => $request->dept,
                'dept_use' => $request->deptuse,
                'cost_type' => $request->costtype,
                'cost_no' => $request->costno,
                'location' => $request->location,
                'approve' => $request->approve
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

    public function headedit($id){
        $fheader = DB::table('fuel_headers')->find($id);
        return $fheader;
    }

    public function headupd(Request $request){
        DB::table('fuel_headers')
            ->where('id', $request->id)
            ->update([
                'dept_use' => $request->deptuse,
                'cost_type' => $request->costtype,
                'cost_no' => $request->costno,
                'location' => $request->location,
                'approve' => $request->approve
            ]);
    }

    public function headdel($id){
        DB::delete('delete from fuel_headers where id = ?', [$id]);
    }

    public function detailadd(Request $request){
        $check = DB::table('fuel_details')
                    ->where('headid', $request->headid)
                    ->where('refuel_date', $request->refueldate)
                    ->where('shift', $request->shift)
                    ->where('equip_no', $request->equipno);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {

            DB::table('fuel_details')->insert([
                'headid' => $request->headid,
                'refuel_date' => $request->refueldate,
                'shift' => $request->shift,
                'equip_no' => $request->equipno,
                'equip_descr' => $request->equipdescr,
                'work_order' => $request->workorder,
                'reserve_no' => $request->reserveno,
                'material' => $request->material,
                'smu' => $request->smu,
                'driver' => $request->driver,
                'liter' => $request->liter,
                'refuel_by' => $request->refuelby,
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

    public function detailedit($id){
        $detedit = DB::table('fuel_details')->find($id);
        return $detedit;
    }

    public function detailupd(Request $request){
        DB::table('fuel_details')
            ->where('id', $request->id)
            ->update([
                'refuel_date' => $request->refueldate,
                'shift' => $request->shift,
                'equip_no' => $request->equipno,
                'equip_descr' => $request->equipdescr,
                'work_order' => $request->workorder,
                'reserve_no' => $request->reserveno,
                'material' => $request->material,
                'smu' => $request->smu,
                'driver' => $request->driver,
                'liter' => $request->liter,
                'refuel_by' => $request->refuelby,
                'remarks' => $request->remarks
            ]);
    }

    public function detaildel($id){
        DB::delete('delete from fuel_details where id = ?', [$id]);
    }

}
