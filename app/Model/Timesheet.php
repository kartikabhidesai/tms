<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use DB;
use Auth;

class Timesheet extends Model {

    protected $table = 'timesheet';

    /* In table not created 'updated_at' and 'created_at' field then write below code */
    public $timestamps = false;

    public function getTimesheetList($id = NULL) {
        if ($id) {
            $result = timesheet::select('timesheet.*')
                    ->where('timesheet.worker_id', '=', $id)
                    ->get();
        } else {
            $result = timesheet::select('timesheet.*', 'users.staffnumber')
                    ->join('users', 'timesheet.worker_id', '=', 'users.id')
                    ->get();
        }
        return $result;
    }

    public function searchtimesheetInfo($request, $id = NULL) {

        $name = $request->input('name');
        $workplaces = $request->input('workplaces');
        $fromDate = $request->input('start_date');
        $toDate = $request->input('end_date');
        /*
          $result = timesheet::whereRaw("c_date >= ? AND c_date <= ?",
          array($fromDate." 00:00:00", $toDate." 23:59:59")
          )
          ->where('timesheet.worker_id', '=', $name)
          ->where('timesheet.workplaces', '=', $workplaces)
          ->get(); */


        $result = timesheet::select('timesheet.*', 'users.staffnumber', 'users.name');
        if ($name != "") {
            $result->where('worker_id', 'LIKE', '%' . $name . '%');
        }
        if ($workplaces != "") {
            $result->where('timesheet.workplaces', 'LIKE', '%' . $workplaces . '%');
        }
        if ($toDate != "") {
            $result->whereRaw("c_date >= ? AND c_date <= ?", array($fromDate . " 00:00:00", $toDate . " 23:59:59")
            );
        }

        $results = $result->join('users', 'timesheet.worker_id', '=', 'users.id')->get();


        //dd($results);

        return $results;
    }

    public function searchinformationInfo($request, $id = NULL) {

        $name = $request->input('name');
        $workplaces = $request->input('workplaces');
        $fromDate = $request->input('start_date');
        $toDate = $request->input('end_date');
        /*
          $result = timesheet::whereRaw("c_date >= ? AND c_date <= ?",
          array($fromDate." 00:00:00", $toDate." 23:59:59")
          )
          ->where('timesheet.worker_id', '=', $name)
          ->where('timesheet.workplaces', '=', $workplaces)
          ->get(); */


        $result = timesheet::select();
        if ($name != "") {
            $result->where('worker_id', 'LIKE', '%' . $name . '%');
        }
        if ($workplaces != "") {
            $result->where('timesheet.workplaces', 'LIKE', '%' . $workplaces . '%');
        }
        if ($toDate != "") {
            $result->whereRaw("c_date >= ? AND c_date <= ?", array($fromDate . " 00:00:00", $toDate . " 23:59:59")
            );
        }

        $results = $result->get();
        return $results;
    }

    public function getBestStaffData($postData) {

        $month = $postData['months'];
        $year = $postData['year'];
        $sql = timesheet::select('timesheet.*', 'users.name', 'users.staffnumber', DB::raw("SUM(timesheet.total_time) as totalTime"))
                ->join('users', 'timesheet.worker_id', '=', 'users.id')
                ->groupBy('timesheet.worker_id');
        if (!empty($year) && empty($month)) {
            $sql->where(function($sql) use($year) {
                        $sql->orWhere(function($sql) use($year) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-01-01'), date($year . '-12-31')]);
                                });
                    });
        } if (!empty($year) && !empty($month)) {
            $sql->where(function($sql) use($year, $month) {
                        $sql->orWhere(function($sql) use($year, $month) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-' . $month . '-01'), date($year . '-' . $month . '-31')]);
                                });
                    });
        }
        $sql->orderBy(DB::raw("SUM(timesheet.total_time)"), 'desc');
        $result = $sql->first();

        return $result;
    }
    
    public function getRestWorkplace($postData) {

        $month = $postData['months'];
        $year = $postData['year'];
        $sql = timesheet::select('timesheet.*', 'workplaces.adresses', DB::raw("SUM(timesheet.total_time) as totalTime"))
                ->join('workplaces', 'workplaces.company', '=', 'timesheet.workplaces')
                ->groupBy('timesheet.workplaces');
        if (!empty($year) && empty($month)) {
            $sql->where(function($sql) use($year) {
                        $sql->orWhere(function($sql) use($year) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-01-01'), date($year . '-12-31')]);
                                });
                    });
        } if (!empty($year) && !empty($month)) {
            $sql->where(function($sql) use($year, $month) {
                        $sql->orWhere(function($sql) use($year, $month) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-' . $month . '-01'), date($year . '-' . $month . '-31')]);
                                });
                    });
        }
        $sql->orderBy(DB::raw("SUM(timesheet.total_time)"), 'desc');
        $result = $sql->first();
//echo '<pre/>';print_r($result);exit;
        return $result;
    }
    
    public function getWorkplaceListData($postData) {
//        print_r($postData);exit;
        $month = $postData['months'];
        $year = $postData['year'];
        $staffId = $postData['name'];
        $sql = timesheet::select('timesheet.*','users.name', 'workplaces.adresses')
                ->join('users', 'timesheet.worker_id', '=', 'users.id')
                ->join('workplaces', 'workplaces.company', '=', 'timesheet.workplaces');
            $sql->where('timesheet.workplaces', $staffId);
        if (!empty($year) && empty($month)) {
            $sql->where(function($sql) use($year) {
                        $sql->orWhere(function($sql) use($year) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-01-01'), date($year . '-12-31')]);
                                });
                    });
        } 
        if (!empty($year) && !empty($month)) {
            $sql->where(function($sql) use($year, $month) {
                        $sql->orWhere(function($sql) use($year, $month) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-' . $month . '-01'), date($year . '-' . $month . '-31')]);
                                });
                    });
        }
        $result = $sql->get()->toArray();
        return $result;
    }

    public function getStaffListData($postData) {
//        print_r($postData);exit;
        $month = $postData['months'];
        $year = $postData['year'];
        $staffId = $postData['staffId'];
        $sql = timesheet::select('timesheet.*','users.name', 'workplaces.adresses')
                ->join('users', 'timesheet.worker_id', '=', 'users.id')
                ->join('workplaces', 'workplaces.company', '=', 'timesheet.workplaces');
            $sql->where('timesheet.worker_id', $staffId);
        if (!empty($year) && empty($month)) {
            $sql->where(function($sql) use($year) {
                        $sql->orWhere(function($sql) use($year) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-01-01'), date($year . '-12-31')]);
                                });
                    });
        } 
        if (!empty($year) && !empty($month)) {
            $sql->where(function($sql) use($year, $month) {
                        $sql->orWhere(function($sql) use($year, $month) {
                                    $sql->whereBetween('timesheet.c_date', [date($year . '-' . $month . '-01'), date($year . '-' . $month . '-31')]);
                                });
                    });
        }
        $result = $sql->get()->toArray();
        return $result;
    }
}
