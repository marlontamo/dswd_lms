<?php

namespace App\Http\Controllers\Frontend\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use App\Models\Auth\User;
use App\Exports\ActivityReport;
class ActivityReportController extends Controller
{
    
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {     
      return \Excel::download( new ActivityReport, Carbon::now().'-IDCBAR.xlsx');
   //return Excel::store(new ActivityReport ,Carbon::now().'-IDCBAR.xlsx', 'public');
    }
}
