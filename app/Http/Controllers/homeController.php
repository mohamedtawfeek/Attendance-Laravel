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
    public function index($msg = 'welcome', $check = "alert-success") {
        if (Auth::check()) {
            $attend = DB::table('attend')
                    ->select()
                    ->where('user_id', Auth::User()->id)
                    ->get();
            
            $message = $msg;
            $Class = $check;
            return view('auth.home', compact('attend', 'message', 'Class'));
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

        function attendCheck($request) {
            $todayDate = date('Y-m-d');
            $day = date('l');
            $shift_id = '1';
            $calc_m = '7';
            $attend_h = date('H:i');
            $calc_h = $attend_h - 18;
            $start = $request->start;
            if ($start === 'start') {
                $attend_db = DB::table('attend')->insert([
                    ['day' => $day, 'user_id' => Auth::User()->id, 'shift_id' => $shift_id, 'attend_date' => $todayDate, 'attend_h' => $attend_h, 'calc_hour'
                        => $calc_h, 'calc_min' => $calc_m, 'leave_h' => '7:00', 'break_h' => '1:00']
                ]);
            }
        }

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
                attendCheck($request);
                return homeController::index($doneMsg, $success);
            }
        } else {
            $success = 'alert-success';

            $doneMsg = 'Saved Successfully';
            attendCheck($request);
            return homeController::index($doneMsg,$success);
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
        $todayDate = date('Y-m-d');
        $leave_h = date('H:i');
        $end = $request->end;
        if ($end === 'end') {
            $update = DB::table('attend')
                    ->where('user_id', Auth::User()->id)
                    ->where('attend_date', $todayDate)
                    ->update(['leave_h' => $leave_h]);
            $doneMsg = 'Done Successfully';
            $success = 'alert-success';
            return homeController::index($doneMsg,$success);
        }
    }

}
