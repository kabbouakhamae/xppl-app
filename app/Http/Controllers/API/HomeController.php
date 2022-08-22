<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function countcountry()
    {
        $countCountry = DB::select("select isnull(a.country, 'Undefine') as country, count(distinct a.id) as cnt from emp_names as a, emp_details as b where a.id = b.userid and b.status = 'current' group by a.country");
        return $countCountry;
    }

    public function allemp()
    {
        $allemp = DB::select("select count(distinct a.id) as cnt from emp_names as a, emp_details as b where a.id = b.userid and b.status = 'current'");
        return $allemp;
    }

    public function countdept()
    {
        $countdept = DB::select("select department, count(distinct userid) as cnt from emp_details where status = 'current' group by department   ");
        return $countdept;
    }
}
