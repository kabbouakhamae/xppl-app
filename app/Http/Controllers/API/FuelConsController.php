<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FuelConsController extends Controller
{
    public function header(Request $request){
        $userid = auth()->user()->userid;

        if ($request->permiss == 1){
            $header = DB::table('fuel_headers')
                        ->where('refuel_date', $request->date)
                        ->orderBy('id')
                        ->get();
        } else {
            $header = DB::table('fuel_headers')
                        ->where('refuel_date', $request->date)
                        ->where('created_dept', $request->dept)
                        ->orderBy('id')
                        ->get();
        }

        return $header;
    }

    public function detail(Request $request){
        $det = DB::table('fuel_details as a')
                    ->join('fuel_lookup as b', 'a.material', 'b.code')
                    ->where('a.head_id', $request->head_id)
                    ->where('b.category', 'material code')
                    ->select(DB::raw("a.id, a.equip_no, a.equip_descr, a.work_shift, a.refuel_by, format(a.smu, '0') as smu, a.driver, format(a.liter, '0.00') as liter, 
                        b.descr as material_descr, format(a.reserve_no, '0') as reserve_no, format(work_order,'0') as work_order, a.created_at, a.created_by, a.updated_at, a.updated_by"))
                    ->orderBy('id')
                    ->get();

        return $det;
    }

    public function headerAdd(Request $request){
        $check = DB::table('fuel_headers')
                    ->where('refuel_date', $request->refuel_date)
                    ->where('created_dept', $request->created_dept)
                    ->where('cost_dept', $request->cost_dept)
                    ->where('cost_type', $request->cost_type)
                    ->where('cost_no', $request->cost_no);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {
            $createdBy = Str::lower(auth()->user()->username);
            DB::table('fuel_headers')
                ->insert([
                    'plant' => $request->plant,
                    'refuel_date' => $request->refuel_date,
                    'created_dept' => $request->created_dept,
                    'cost_dept' => $request->cost_dept,
                    'cost_type' => $request->cost_type,
                    'cost_no' => $request->cost_no,
                    'location' => $request->location,
                    'approved_by' => $request->approved_by,
                    'created_by' => $createdBy
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

    public function headerEdit($id){
        $fheader = DB::table('fuel_headers')->find($id);
        return $fheader;
    }

    public function headerUpd(Request $request){
        $updatedBy = Str::lower(auth()->user()->username);
        DB::table('fuel_headers')
            ->where('id', $request->id)
            ->update([
                'plant' => $request->plant,
                'cost_dept' => $request->cost_dept,
                'cost_type' => $request->cost_type,
                'cost_no' => $request->cost_no,
                'location' => $request->location,
                'approved_by' => $request->approved_by,
                'updated_by' => $updatedBy
            ]);
    }

    public function headerDel($id){
        DB::delete('delete from fuel_headers where id = ?', [$id]);
    }

    public function detailAdd(Request $request){
        $check = DB::table('fuel_details')
                    ->where('head_id', $request->head_id)
                    ->where('work_shift', $request->work_shift)
                    ->where('equip_no', $request->equip_no);
        
        if ($check->count()){
            $success = false;
            $message = 'Duplicate record!';
        } else {
            $createdBy = Str::lower(auth()->user()->username);
            DB::table('fuel_details')->insert([
                'head_id' => $request->head_id,
                'work_shift' => $request->work_shift,
                'equip_no' => $request->equip_no,
                'equip_descr' => $request->equip_descr,
                'work_order' => $request->work_order,
                'reserve_no' => $request->reserve_no,
                'material' => $request->material,
                'smu' => $request->smu,
                'driver' => $request->driver,
                'liter' => $request->liter,
                'refuel_by' => $request->refuel_by,
                'created_by' => $createdBy
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
        $detedit = DB::table('fuel_details')->find($id);
        return $detedit;
    }

    public function detailUpd(Request $request){
        $updatedBy = Str::lower(auth()->user()->username);
        DB::table('fuel_details')
            ->where('id', $request->id)
            ->update([
                'work_shift' => $request->work_shift,
                'equip_no' => $request->equip_no,
                'equip_descr' => $request->equip_descr,
                'work_order' => $request->work_order,
                'reserve_no' => $request->reserve_no,
                'material' => $request->material,
                'smu' => $request->smu,
                'driver' => $request->driver,
                'liter' => $request->liter,
                'refuel_by' => $request->refuel_by,
                'updated_by' => $updatedBy
            ]);
    }

    public function detailDel($id){
        DB::delete('delete from fuel_details where id = ?', [$id]);
    }

    public function addNewReserveNo(Request $request){
        DB::table('fuel_workorders')
            ->where('work_order', $request->workOrder)
            ->update([
                'reserve_no' => $request->reserveNo
            ]);
    }

}
