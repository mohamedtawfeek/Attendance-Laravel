<?php

namespace attend\Http\Controllers;

use DateTime;
use Auth;
use Illuminate\Http\Request;
use attend\Http\Requests;
use attend\Http\Controllers\Controller;
use DB;

class homeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($msg = 'welcome', $check = "alert-success") {
        if (Auth::check()) {
            $attend = DB::table('attend')
                    ->select()
                    ->where('user_id', Auth::User()->id)
                    ->orderBy('attend_date', 'desc')
                    ->get();
            $extra = DB::table('extra')
                    ->select()
                    ->where('user_id', Auth::User()->id)
                    ->orderBy('extra_date', 'desc')
                    ->get();

            $message = $msg;
            $Class = $check;
            return view('auth.home', compact('attend', 'message', 'Class', 'extra'));
        } else {
            return view('auth.login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $attend_date = DB::table('attend')
                ->select('attend_date')
                ->where('user_id', Auth::User()->id)
                ->orderBy('attend_date', 'desc')
                ->first();
        $ShiftHours = DB::table('hours')
                ->select()
                ->where('id', Auth::User()->shift_id)
                ->get();

        function attendCheck($request, $ShiftHours) {
            $todayDate = date('Y-m-d');
            $day = date('l');
            $shift_id = Auth::User()->shift_id;
            $attendH = date('H');
            $attendM = date('i') - 5;

            $attend_h = $attendH . ':' . $attendM;
            $calc_h = ($ShiftHours->second_end - $ShiftHours->first_start) - ($ShiftHours->second_start - $ShiftHours->first_end) - ($attendH - 12)  - 1;
            $calcM = 60 - $attendM;
            if ($calcM < 0) {
                $calc_h --;
                $minOutput = 60 . $calcM;
            } elseif ($calcM < 10) {
                $minOutput = '0' . $calcM;
            } else {
                $minOutput = $calcM;
            }

            $calc_m = $minOutput;
            $start = $request->start;
            $leave_h = $ShiftHours->second_end + 1;
            if ($start === 'start') {
                $attend_db = DB::table('attend')->insert([
                    ['day' => $day, 'user_id' => Auth::User()->id, 'shift_id' => $shift_id, 'attend_date' => $todayDate, 'attend_h' => $attend_h, 'calc_hour'
                        => $calc_h, 'calc_min' => $calc_m, 'leave_h' => $leave_h, 'break_h' => '1:00']
                ]);
            }
        }

        $ShiftEnd = $ShiftHours[0];
        if ($attend_date) {
            $sameMsg = 'you cannot start shift more than one time';
            $Alert = 'alert-danger';
            $todayDate = date('Y-m-d');
            $date = $attend_date->attend_date;
            if ($todayDate === $date) {
                return homeController::index($sameMsg, $Alert);
            } else {
                $success = 'alert-success';
                $doneMsg = 'Saved Successfully';
                attendCheck($request, $ShiftEnd);
                return homeController::index($doneMsg, $success);
            }
        } else {
            $success = 'alert-success';

            $doneMsg = 'Saved Successfully';
            attendCheck($request, $ShiftEnd);
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
        $ShiftHours = DB::table('hours')
                ->select()
                ->where('id', Auth::User()->shift_id)
                ->get();
        $leave = DB::table('attend')
                ->select('leave_h', 'attend_h', 'break_h')
                ->where('user_id', Auth::User()->id)
                ->orderBy('attend_date', 'desc')
                ->first();
        $ShiftEnd = $ShiftHours[0]->second_end + 1;
        
        $leave_time = $leave->leave_h;
        $attend = $leave->attend_h;
        $attendSplit = explode(':', $attend);
        $attendH = $attendSplit[0];
        $attendM = $attendSplit[1];
        $breakTime = $leave->break_h;
        $breakSplit = explode(':', $breakTime);
        $breakH = $breakSplit[0];
        $breakM = $breakSplit[1];
        $todayDate = date('Y-m-d');
        $leave_h = date('H:i');
        $end = $request->end;
        $calcH = date('H') - $attendH - $breakH;
        $Mcalc = $attendM + $breakM;
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
        if ($end === 'end' && $leave_time == $ShiftEnd && $leave_h < $ShiftEnd) {
            $update = DB::table('attend')
                    ->where('user_id', Auth::User()->id)
                    ->where('attend_date', $todayDate)
                    ->update(['leave_h' => $leave_h, 'calc_hour' => $calcH, 'calc_min' => $calcM]);
            $doneMsg = 'Done Successfully';
            $success = 'alert-success';
            return homeController::index($doneMsg, $success);
        } else {
            $doneMsg = 'you already done that';
            $success = 'alert-danger';
            return homeController::index($doneMsg, $success);
        }
    }

    public function BreakTime(Request $request) {
        $break = DB::table('attend')
                ->select('break_h', 'calc_hour', 'calc_min')
                ->where('user_id', Auth::User()->id)
                ->orderBy('attend_date', 'desc')
                ->first();
        if ($break) {
            $breakH = $request->breakH;
            $breakM = $request->breakM;
            $calcHour = $break->calc_hour;
            $calcMin = $break->calc_min;
            $breakHour = $break->break_h;
            $todayDate = date('Y-m-d');

            $calcH = $calcHour - $breakH;
            if ($calcMin > $breakM) {
                $calcM = $calcMin - $breakM;
            } else {
                $calcM = $breakM - $calcMin;
            }
            if ($breakH === '0') {
                $breakH = 1;
            } elseif ($breakH === '1') {
                $breakH = 2;
            } else {
                $breakH = 3;
            }
            if ($breakHour === '1:00') {
                $update = DB::table('attend')
                        ->where('user_id', Auth::User()->id)
                        ->where('attend_date', $todayDate)
                        ->update(['break_h' => $breakH . ':' . $breakM, 'calc_hour' => $calcH, 'calc_min' => $calcM]);
                $doneMsg = 'Done Successfully';
                $success = 'alert-success';
                return homeController::index($doneMsg, $success);
            } else {
                $doneMsg = 'you already done that';
                $success = 'alert-danger';
                return homeController::index($doneMsg, $success);
            }
        } else {
            $doneMsg = 'No data avalible';
            $success = 'alert-danger';
            return homeController::index($doneMsg, $success);
        }
    }

}
