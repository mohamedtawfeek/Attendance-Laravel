<?php

namespace attend\Http\Controllers;

use DB;
use Auth;
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
        foreach ($users as $user) {
            $attendance = DB::table('attend')
                    ->select()
                    ->where('user_id', $user->id)
                    ->get();
            $attend[$user->name] = $attendance;
            $extraTime = DB::table('extra')
                    ->select()
                    ->where('user_id', $user->id)
                    ->get();
            $extra[$user->name] = $extraTime;
        }

        return view('auth.admin', compact('attend', 'extra'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
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
            $calcH = $leaveH - $attendH - $breakH;
            $Mcalc = $attendM - $breakM;
            if ($leaveM > $Mcalc) {
                $calcM = $leaveM - $Mcalc;
            } else {
                if ($Mcalc > 60) {
                    $calcM1 = $Mcalc - 60;
                    if ($calcM1 > $leaveM) {
                        $calcM = $calcM1 - $leaveM;
                    } else {
                        $calcM = $leaveM - $calcM1;
                    }
                    $calcH --;
                } else {
                    $calcM = $Mcalc - $leaveM;
                }
            }
            $response = array('id' => $request->id, 'attend' => $attend, 'leave' => $leave_time, 'workTime' => $calcH . ':' . $calcM, 'break' => $breakTime);
            $update = DB::table('attend')
                    ->where('id', $request->id)
                    ->update(['attend_h' => $attend, 'leave_h' => $leave_time, 'calc_hour' => $calcH, 'calc_min' => $calcM, 'break_h' => $breakTime]);
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
                    $calcM = $Mcalc - 60 - $leaveM;
                    $calcH --;
                } else {
                    $calcM = $Mcalc - $leaveM;
                }
            }
            $response = array('id' => $request->id, 'extra' => $extra, 'workTime' => $calcH . ':' . $calcM);
            $update = DB::table('extra')
                    ->where('id', $request->id)
                    ->update(['extra_h' => $extra, 'status' =>$status, 'leave_h' => $leave_time, 'calc_hour' => $calcH, 'calc_min' => $calcM]);
            return response()->json(['extra' => $response]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
