<?php

namespace attend\Http\Controllers;

use Illuminate\Http\Request;
use attend\Http\Requests;
use attend\Http\Controllers\Controller;
use DB;

class SingleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($single = "what") {

        $users = DB::table('users')
                ->select('id', 'name')
                ->get();
        $name = "";
        $year = date('Y');
        $month = date('m');
        $attends = "";
        return view('auth.single', compact('users', 'single', 'name', 'year', 'month', 'attends'));
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        $users = DB::table('users')
                ->select('id', 'name')
                ->get();
        $attends = $request->check;
        $idSplit = explode(':', $request->id);
        $id = $idSplit[0];
        $name = $idSplit[1];
        if ($request->month > 10) {
            $month = "0" . $request->month;
        } else {
            $month = $request->month;
        }

        function minsCalc($hours, $mins) {
            $aminCalc = $mins / 60;
            $minSplit = explode(".", $aminCalc);
            $HourPlus = $hours + $minSplit[0];
            $originalNum = '.' . $minSplit[1];
            $calCunum = $originalNum * 60;
            $roundNum = round($calCunum);
            return array($HourPlus, $roundNum);
        }

        $year = $request->year;
        if ($request->check === "attend") {
            $attend = DB::table('attend')
                    ->select()
                    ->where('user_id', $id)
                    ->where('attend_date', 'like', $request->year . '-' . $month . '%')
                    ->orderBy('attend_date', 'desc')
                    ->get();

            if ($attend) {
                $single = "attend";
            } else {
                $single = "what";
            }
            $workHours = 0;
            $workMins = 0;
            $minsCalc = 0;
            $lateHour = 0;
            $lateMin = 0;
            $lateMins = 0;
            foreach ($attend as $workTime) {
                $workHours += $workTime->calc_hour;
                $workMins += $workTime->calc_min;
                $lateSplit = explode(':', $workTime->late_h);
                $lateH = $lateSplit[0];
                $lateM = $lateSplit[1];
                $lateHour += $lateH;
                $lateMin += $lateM;
                if ($lateMin > 60) {
                    $lateMins = $lateMin - 60;
                    $lateHour++;
                } else {
                    $lateMins = $lateMin;
                }
                if ($workMins > 60) {
                    $minsCalc = $workMins - 60;
                    $workHours++;
                } else {
                    $minsCalc = $workMins;
                }
            }

            $aminsCalc = $minsCalc / 60;
            if ($aminsCalc > 0) {
                $mins = minsCalc($workHours, $minsCalc);
                $calcHourArc = $mins[0];
                $calcMinArc = $mins[1];
            } else {
                $calcHourArc = $workHours;
                $calcMinArc = $minsCalc;
            }

            $alateMins = $lateMins / 60;
            if ($alateMins > 0) {
                $calcLateArc = minsCalc($lateHour, $lateMins);
                $calcLateH = $calcLateArc[0];
                $calcLateM = $calcLateArc[1];
            } else {
                $calcLateH = $lateHour;
                $calcLateM = $lateMins;
            }
            return view('auth.single', compact('users', 'attend', 'single', 'year', 'month', 'attends', 'name', 'calcHourArc', 'calcMinArc', 'calcLateH', 'calcLateM'));
        } else {
            $extras = DB::table('extra')
                    ->select()
                    ->where('user_id', $id)
                    ->where('extra_date', 'like', '%' . $month . '-' . $request->year)
                    ->orderBy('extra_date', 'desc')
                    ->get();
            $extraHours = 0;
            $extraMins = 0;
            $minsExtra = 0;

            foreach ($extras as $extraTime) {
                if ($extraTime->status === 'accepted') {
                    $extraHours += $extraTime->calc_hour;
                    $extraMins += $extraTime->calc_min;
                    if ($extraMins > 60) {
                        $minsExtra = $extraMins - 60;
                        $extraHours++;
                    } else {
                        $minsExtra = $extraMins;
                    }
                }
            }
            $aminsExtra = $minsExtra / 60;
            if ($aminsExtra > 0) {
                $calcExArc = minsCalc($extraHours, $minsExtra);
                $calcExH = $calcExArc[0];
                $calcExM = $calcExArc[1];
            } else {
                $calcExH = $extraHours;
                $calcExM = $minsExtra;
            }

            if ($extras) {
                $single = "extra";
            } else {
                $single = "what";
            }

            return view('auth.single', compact('users', 'extras', 'single', 'year', 'month', 'name', 'calcExH', 'calcExM', 'attends'));
        }
    }

}
