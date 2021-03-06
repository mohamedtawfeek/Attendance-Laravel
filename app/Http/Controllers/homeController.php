<?php

namespace attend\Http\Controllers;

use DateTime;
use Auth;
use Hash;
use Validator;
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
            $month = date('Y-m');
            $month2 = date('m-Y');
            $attend = DB::table('attend')
                    ->select()
                    ->where('user_id', Auth::User()->id)
                    ->where('attend_date', 'like', $month . '%')
                    ->orderBy('attend_date', 'desc')
                    ->get();
            if ($attend) {



                function minsCalc($hours, $mins) {
                    $aminCalc = $mins / 60;
                    $minSplit = explode(".", $aminCalc);
                    $HourPlus = $hours + $minSplit[0];
                    $originalNum = '.' . $minSplit[1];
                    $calCunum = $originalNum * 60;
                    $roundNum = round($calCunum);
                    return array($HourPlus, $roundNum);
                }

                $breakSplit = explode(":", $attend[0]->break_h);
                $breakHour = $breakSplit[0];
                $breakMin = $breakSplit[1];
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
                    $minsss = minsCalc($workHours, $minsCalc);
                    $HourPlus = $minsss[0];
                    $roundNum = $minsss[1];
                } else {
                    $HourPlus = $workHours;
                    $roundNum = $minsCalc;
                }
                $alateMins = $lateMins / 60;
                if ($alateMins > 0) {
                    $LatMinsss = minsCalc($lateHour, $lateMins);
                    $lateHourCalc = $LatMinsss[0];
                    $lateMinsCalc = $LatMinsss[1];
                } else {
                    $lateHourCalc = $lateHour;
                    $lateMinsCalc = $lateMins;
                }
            }
            $extra = DB::table('extra')
                    ->select()
                    ->where('user_id', Auth::User()->id)
                    ->where('extra_date', 'like', '%' . $month2)
                    ->orderBy('extra_date', 'desc')
                    ->get();
            $extraHours = 0;
            $extraMins = 0;
            $minsExtra = 0;

            foreach ($extra as $extraTime) {
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
                $ExtMins = minsCalc($workHours, $minsCalc);
                $ExHourPlus = $ExtMins[0];
                $roundRest = $ExtMins[1];
            } else {
                $roundRest = $minsExtra;
                $ExHourPlus = $extraHours;
            }
            $message = $msg;
            $Class = $check;
            return view('auth.home', compact('attend', 'message', 'Class', 'extra', 'HourPlus', 'roundNum', 'lateHourCalc', 'lateMinsCalc', 'ExHourPlus', 'roundRest', 'breakHour', 'breakMin'));
        } else {
            return view('auth.login');
        }
    }

    public static function Archive(Request $request) {
        if ($request->month < 10) {
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

        if ($request->check === "attend") {
            $attend = DB::table('attend')
                    ->select()
                    ->where('user_id', Auth::User()->id)
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
            return view('auth.archive', compact('attend', 'single', 'calcHourArc', 'calcMinArc', 'calcLateH', 'calcLateM'));
        } else {
            $extras = DB::table('extra')
                    ->select()
                    ->where('user_id', Auth::User()->id)
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

            return view('auth.archive', compact('extras', 'single', 'calcExH', 'calcExM'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function ChangePass(Request $request) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                        'password' => 'required|confirmed|min:6',
            ]);
            if ($validator->fails()) {
                return redirect('control')
                                ->withErrors($validator)
                                ->withInput();
            }
            if (Hash::needsRehash($request->password)) {
                $password = Hash::make($request->password);
            }
            $update = DB::table('users')
                    ->where('id', Auth::User()->id)
                    ->update(['password' => $password]);
            $msg = "changed password Successfuly";
            $alert = "alert-success";
            return homeController::index($msg, $alert);
        }
        if ($request->isMethod('get')) {
            return view('auth.change');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $day = date('l');
        $attend_date = DB::table('attend')
                ->select('attend_date')
                ->where('user_id', Auth::User()->id)
                ->orderBy('attend_date', 'desc')
                ->first();
        $ShiftHours = DB::table('hours')
                ->select()
                ->where('id', Auth::User()->shift_id)
                ->get();
        $ShiftEnd = $ShiftHours[0];
        $attendH = date('H');

        function attendCheck($request, $ShiftHours) {
            $todayDate = date('Y-m-d');
            $day = date('l');
            $shift_id = Auth::User()->shift_id;
            $attendH = date('H');
            if (date('i') >= 5) {
                $attendM = date('i') - 5;
            } else {
                $attendM = 60 - ( 5 - date('i'));
                $attendH--;
            }






            if ($attendH < 10) {
                $attendH = '0' . $attendH;
            } else {
                $attendH = $attendH;
            }
            if ($attendM < 10) {
                $attendM = '0' . $attendM;
            } else {
                $attendM = $attendM;
            }
            if ($attendH <= $ShiftHours->first_start - 1) {
                $lateH = '00';
            } else {
                $lateH = $attendH - $ShiftHours->first_start;
            }
            if ($attendH >= $ShiftHours->first_start - 1 && date('i') >= 5) {
                $lateM = 60 - $attendM;
            } else {
                $lateM = '00';
            }

            $attend_h = $attendH . ':' . $attendM;
            $calc_h = ($ShiftHours->second_end - $ShiftHours->first_start) + ($ShiftHours->second_start - $ShiftHours->first_end) - 1 - $lateH;
            $calcM = 60 - $attendM;
            if ($calcM < 0) {
                $calc_h--;
                $minOutput = 60 . $calcM;
            } elseif ($calcM < 10) {
                $minOutput = '0' . $calcM;
            } else {
                $minOutput = $calcM;
            }

            $calc_m = $minOutput;

            if ($calc_h < 10) {
                $calc_h = '0' . $calc_h;
            } else {
                $calc_h = $calc_h;
            }

            $start = $request->start;
            $leave_h = $ShiftHours->second_end + 1;

            if ($start === 'start') {
                $attend_db = DB::table('attend')->insert([
                    ['day' => $day, 'user_id' => Auth::User()->id, 'shift_id' => $shift_id, 'attend_date' => $todayDate, 'attend_h' => $attend_h, 'calc_hour'
                        => $calc_h, 'calc_min' => $calc_m, 'leave_h' => $leave_h . ':00', 'break_h' => '1:00', 'late_h' => $lateH . ':' . $lateM]
                ]);
            }
        }

        if ($day !== "Friday" && $day !== "Saturday") {
            if ($attend_date || $ShiftEnd->first_start - 1 > $attendH) {
                $sameMsg = 'you cannot start shift more than one time';
                $Alert = 'alert-danger';
                $todayDate = date('Y-m-d');
                $Lastdate = $attend_date->attend_date;

                if ($todayDate === $Lastdate || $ShiftEnd->first_start > $attendH || $ShiftEnd->second_end <= $attendH) {
                    return homeController::index($sameMsg, $Alert);
                } else {
                    $success = 'alert-success';
                    $doneMsg = 'Saved Successfuly ';
                    attendCheck($request, $ShiftEnd);
                    return homeController::index($doneMsg, $success);
                }
            } elseif ($ShiftEnd->first_start - 1 > $attendH) {
                $sameMsg = 'you cannot start shift at this time';
                $Alert = 'alert-danger';
                return homeController::index($sameMsg, $Alert);
            } else {
                $success = 'alert-success';
                $doneMsg = 'Saved Successfully';
                attendCheck($request, $ShiftEnd);
                return homeController::index($doneMsg, $success);
            }
        } else {
            $sameMsg = 'today\'s day off start extra';
            $Alert = 'alert-danger';
            return homeController::index($sameMsg, $Alert);
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
        if ($calcH < 10) {
            $calcH = '0' . $calcH;
        } else {
            $calcH = $calcH;
        }
        if ($calcM < 10) {
            $calcM = '0' . $calcM;
        } else {
            $calcM = $calcM;
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
                ->select('break_h', 'calc_hour', 'calc_min', 'leave_h')
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
            $LeaveHour = $break->leave_h;
            $calcH = $calcHour - $breakH;
            if ($calcMin >= $breakM) {
                $calcM = $calcMin - $breakM;
            } else {
                $calcM = 60 - $breakM + $calcMin;
                $calcH--;
            }

            if ($calcH < 10) {
                $calcH = '0' . $calcH;
            } else {
                $calcH = $calcH;
            }
            if ($calcM < 10) {
                $calcM = '0' . $calcM;
            } else {
                $calcM = $calcM;
            }


            if ($breakH === '0') {
                $breakH = '01';
                $BreakLeave = $LeaveHour;
            } elseif ($breakH === '1') {
                $breakH = '02';
                $breakLeave = $LeaveHour + 1;
                $calcH++;
            }
            if ($breakHour === '1:00') {
                $update = DB::table('attend')
                        ->where('user_id', Auth::User()->id)
                        ->where('attend_date', $todayDate)
                        ->update(['break_h' => $breakH . ':' . $breakM, 'calc_hour' => $calcH, 'calc_min' => $calcM, 'leave_h' => $breakLeave]);
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
