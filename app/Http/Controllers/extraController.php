<?php

namespace attend\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use attend\Http\Requests;
use attend\Http\Controllers\Controller;
use DB;

class extraController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index() {
        $success = 'alert-success';
        $doneMsg = 'welcome';
        return homeController::index($doneMsg, $success);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $extra_date = DB::table('extra')
                ->select('extra_date')
                ->where('user_id', Auth::User()->id)
                ->orderBy('extra_date', 'desc')
                ->first();

        function extraCheck($request) {
            $todayDate = date('Y-m-d');
            $day = date('l');
            $status = 'pending';
            $extraH = date('H');
            $extraM = date('i');
            $calc_m = 00;
            $extra_h = $extraH . ':' . $extraM;
            $calc_h = 0;
            $start = $request->extra;
            if ($start === 'extra') {
                $extra_db = DB::table('extra')->insert([
                    ['day' => $day, 'user_id' => Auth::User()->id, 'status' => $status, 'extra_date' => $todayDate, 'extra_h' => $extra_h, 'calc_hour'
                        => $calc_h, 'calc_min' => $calc_m, 'leave_h' => '00:00']
                ]);
            }
        }
        $ShiftHours = DB::table('hours')
                ->select()
                ->where('id', Auth::User()->shift_id)
                ->get();
        $shift_end = $ShiftHours[0]->second_end + 1;
        $extraH = date('H');

        if ($extra_date && $shift_end < $extraH) {
            $sameMsg = 'you cannot start extra more than one time';
            $Alert = 'alert-danger';
            $todayDate = date('Y-m-d');
            $date = $extra_date->extra_date;
            if ($todayDate === $date) {
                return homeController::index($sameMsg, $Alert);
            } else {
                $success = 'alert-success';
                $doneMsg = 'Saved Successfully';
                extraCheck($request);
                return homeController::index($doneMsg, $success);
            }
        } elseif ($shift_end < $extraH) {
            $success = 'alert-success';
            $doneMsg = 'Saved Successfully';
            extraCheck($request);
            return homeController::index($doneMsg, $success);
        } else {
            $success = 'alert-danger';
            $doneMsg = 'you cannot start extra at this time';
            return homeController::index($doneMsg, $success);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $leave = DB::table('extra')
                ->select('leave_h', 'extra_h')
                ->where('user_id', Auth::User()->id)
                ->orderBy('extra_date', 'desc')
                ->first();
        $leave_time = $leave->leave_h;
        $attend = $leave->extra_h;
        $attendSplit = explode(':', $attend);
        $extraH = $attendSplit[0];
        $extraM = $attendSplit[1];

        $todayDate = date('Y-m-d');
        $leave_h = date('H:i');
        $end = $request->extraEnd;
        $calcH = date('H') - $extraH;
        $Mcalc = $extraM;
        if (date('i') > $Mcalc) {
            $calcM = date('i') - $Mcalc;
        } else {
            if ($Mcalc > 60) {
                $calcM = $Mcalc - 60 - date('i');
                $calcH --;
            } else {
                $calcM = $Mcalc - date('i');
            }
        }
        if ($end === 'extraEnd' && $leave_time === '00:00') {
            $update = DB::table('extra')
                    ->where('user_id', Auth::User()->id)
                    ->where('extra_date', $todayDate)
                    ->update(['leave_h' => $leave_h, 'calc_hour' => $calcH, 'calc_min' => $calcM]);
            $doneMsg = 'Ended Extra Time Successfully';
            $success = 'alert-success';
            return homeController::index($doneMsg, $success);
        } else {
            $doneMsg = 'you already done that';
            $success = 'alert-danger';
            return homeController::index($doneMsg, $success);
        }
    }

}
