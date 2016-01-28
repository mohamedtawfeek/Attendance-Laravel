<?php

namespace attend\Http\Controllers;

use DB;
use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use attend\Http\Requests;
use attend\Http\Controllers\Controller;

class adminController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = DB::table('users')
                ->select('id', 'name')
                ->get();
        $month = date('Y-m');
        $month2 = date('m-Y');
        foreach ($users as $user) {
            $attendance = DB::table('attend')
                    ->select()
                    ->where('user_id', $user->id)
                    ->where('attend_date', 'like', $month . '%')
                    ->get();
            $workHours = 0;
            $workMins = 0;
            $minsCalc = 0;
            $lateHour = 0;
            $lateMin = 0;
            $lateMins = 0;
            foreach ($attendance as $workTime) {
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
            $attend[$user->name . '  work: ' . $workHours . ':' . $minsCalc . ' - Late: ' . $lateHour . ':' . $lateMins] = $attendance;

            $extraTime = DB::table('extra')
                    ->select()
                    ->where('user_id', $user->id)
                    ->where('extra_date', 'like', '%' . $month2)
                    ->get();
            $extraHours = 0;
            $extraMins = 0;
            $minsExtra = 0;
            foreach ($extraTime as $extraCalc) {
                if ($extraCalc->status === 'accepted') {
                    $extraHours += $extraCalc->calc_hour;
                    $extraMins += $extraCalc->calc_min;
                    if ($extraMins > 60) {
                        $minsExtra = $workMins - 60;
                        $extraHours++;
                    } else {
                        $minsExtra = $workMins;
                    }
                }
            }

            $extra[$user->name . ' - Time: ' . $extraHours . ':' . $minsExtra] = $extraTime;
        }

        return view('auth.admin', compact('attend', 'extra', 'users'));
    }

    /**
     * Show the form for controlling users.
     *
     * @return \Illuminate\Http\Response
     */
    public function usersShow($msg = "welcome", $alert = "alert-success") {
        $users = DB::table('users')
                ->select()
                ->get();
        $shifts = DB::table('hours')
                ->select()
                ->get();

        return view('auth.control', compact('users', 'shifts', 'msg', 'alert'));
    }

    /**
     * Show the form for controlling users.
     *
     * @return \Illuminate\Http\Response
     */
    public function userChange(Request $request) {
        if ($request->isMethod('post')) { {

                $validator = Validator::make($request->all(), [
                            'name' => 'required|max:255',
                            'email' => 'required|email|max:255',
                            'password' => 'min:6',
                            'shift' => 'required',
                ]);
            }
            if ($validator->fails()) {
                return redirect('control')
                                ->withErrors($validator)
                                ->withInput();
            }
            $updateUser = array('name' => $request->name, 'shift_id' => $request->shift, 'role' => $request->role, 'email' => $request->email);

            if (!empty($request->password)) {
                if (Hash::needsRehash($request->password)) {
                    $password = Hash::make($request->password);
                    $updateUser['password'] = $password;
                }
            }
            $update = DB::table('users')
                    ->where('id', $request->id)
                    ->update($updateUser);
        }
    }

    public function hoursChange(Request $request) {
        if ($request->isMethod('post')) { {
                $validator = Validator::make($request->all(), [
                            'first' => 'required|max:2',
                            'firstEnd' => 'required|max:2',
                            'second' => 'required|max:2',
                            'secondEnd' => 'required|max:2',
                ]);
            }
            if ($validator->fails()) {
                return redirect('control')
                                ->withErrors($validator)
                                ->withInput();
            }
            $update = DB::table('hours')
                    ->where('id', $request->id)
                    ->update(['first_start' => $request->first, 'first_end' => $request->firstEnd, 'second_start' => $request->second, 'second_end' => $request->secondEnd]);
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
        if ($request->isMethod('post')) {
            $ShiftHours = DB::table('hours')
                    ->select()
                    ->where('id', Auth::User()->shift_id)
                    ->get();
            $ShiftEnd = $ShiftHours[0];
            $leave_time = $request->leave;
            $leaveSplit = explode(':', $leave_time);
            $leaveH = $leaveSplit[0];
            $leaveM = $leaveSplit[1];
            $attend = $request->attend;
            $attendSplit = explode(':', $attend);
            $attendH = $attendSplit[0];
            $attendM = $attendSplit[1];
            $breakTime = $request->break;
            $breakSplit = explode(':', $breakTime);
            $breakH = $breakSplit[0];
            $breakM = $breakSplit[1];

            $calcH = $leaveH - $attendH - ($ShiftEnd->second_start - $ShiftEnd->first_end) - $breakH - 1;
            $Mcalc = $attendM + $breakM;
            if ($Mcalc > 60) {
                $newCalc = $Mcalc - 60;
                $calcH--;
                if ($newCalc > $leaveM) {
                    $calcM = 60 - $newCalc - $leaveM;
                } else {
                    $calcM = 60 - $leaveM - $newCalc;
                }
            } elseif ($Mcalc > $leaveM) {
                $calcM = 60 - $Mcalc - $leaveM;
            } elseif ($Mcalc <= 0) {
                $calcM = 60 - $leaveM - $Mcalc;
            } else {
                $calcM = 60 - $leaveM - $Mcalc;
            }
            if ($calcM >= 60) {
                $calcH++;
                $calcMin = $calcM - 60;
            } else {
                $calcMin = $calcM;
            }
            $lateHour = $attendH - $ShiftEnd->first_start;
            $lateMin = $attendM;
            
            $response = array('id' => $request->id, 'attend' => $attend, 'leave' => $leave_time, 'workTime' => $calcH . ':' . $calcMin, 'break' => $breakTime,'late' => $lateHour.':'.$lateMin);
            $update = DB::table('attend')
                    ->where('id', $request->id)
                    ->update(['attend_h' => $attend, 'leave_h' => $leave_time, 'calc_hour' => $calcH, 'calc_min' => $calcMin, 'break_h' => $breakTime,'late_h' => $lateHour.':'.$lateMin]);
            return response()->json(['response' => $response]);
        }
    }

    /**
     * 
     * Update Extra Time 
     * @param $request
     * 
     */
    public function ExtraUpdate(Request $request) {
        if ($request->isMethod('post')) {
            $status = $request->status;
            $extra = $request->extra;
            $leave_time = $request->leave;
            $ExtraSplit = explode(':', $extra);
            $extraH = $ExtraSplit[0];
            $extraM = $ExtraSplit[1];
            $leaveSplit = explode(':', $leave_time);
            $leaveH = $leaveSplit[0];
            $leaveM = $leaveSplit[1];
            $calcH = $leaveH - $extraH;
            $Mcalc = $extraM;
            if ($leaveM > $Mcalc) {
                $calcM = $leaveM - $Mcalc;
            } else {
                if ($Mcalc > 60) {
                    $calcM = $Mcalc - 60;
                    $calcH --;
                    if ($leaveM > $Mcalc) {
                        $calcM = 60 - $leaveM - $Mcalc;
                    } else {
                        $calcM = 60 - $Mcalc - $leaveM;
                    }
                } else {
                    $calcM = 60 - $Mcalc - $leaveM;
                }
            }
            $response = array('id' => $request->id, 'extra' => $extra, 'workTime' => $calcH . ':' . $calcM);
            $update = DB::table('extra')
                    ->where('id', $request->id)
                    ->update(['extra_h' => $extra, 'status' => $status, 'leave_h' => $leave_time, 'calc_hour' => $calcH, 'calc_min' => $calcM]);
            return response()->json(['extra' => $response]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        if ($request->isMethod('post')) {
            $id = $request->id;
            $attendance = DB::table('attend')
                    ->select()
                    ->where('id', $id)
                    ->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyExtra(Request $request) {
        $id = $request->id;
        $extra = DB::table('extra')
                ->select()
                ->where('id', $id)
                ->delete();
    }

    protected function addUser(Request $request) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users',
                        'password' => 'required|confirmed|min:6',
                        'shift' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('control')
                                ->withErrors($validator)
                                ->withInput();
            }
            $TimeStamps = date('Y-m-d H:i:s');

            $addUser = array('name' => $request->name, 'shift_id' => $request->shift, 'role' => "user", 'email' => $request->email, 'password' => $request->password,'created_at' => $TimeStamps);
            $User = DB::table('users')->insert($addUser);
            if ($User) {
                $msg = "Successfully added user";
                $alert = "alert-success";
            } else {
                $msg = "There's some error";
                $alert = "alert-danger";
            }
            return adminController::usersShow($msg, $alert);
        }
    }

    protected function addShift(Request $request) {
        if ($request->isMethod('post')) { {
                $validator = Validator::make($request->all(), [
                            'firstStart' => 'required|max:2',
                            'firstEnd' => 'required|max:2',
                            'secondStart' => 'required|max:2',
                            'secondEnd' => 'required|max:2',
                ]);
            }
            if ($validator->fails()) {
                return redirect('control')
                                ->withErrors($validator)
                                ->withInput();
            }
            $addShift = DB::table('hours')
                    ->insert(['first_start' => $request->firstStart, 'first_end' => $request->firstEnd, 'second_start' => $request->secondStart, 'second_end' => $request->secondEnd]);
            if ($addShift) {
                $msg = "Successfully added Shift";
                $alert = "alert-success";
            } else {
                $msg = "There's some error";
                $alert = "alert-danger";
            }
            return adminController::usersShow($msg, $alert);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyUser(Request $request) {
        $id = $request->id;
        $users = DB::table('users')
                ->select()
                ->where('id', $id)
                ->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyHours(Request $request) {
        $id = $request->id;
        $users = DB::table('hours')
                ->select()
                ->where('id', $id)
                ->delete();
    }

}
