<?php

namespace attend;

use Illuminate\Database\Eloquent\Model;

class attend extends Model {
    /*
     * The table associated with the model.
     * 
     * @var string
     * 
     */

    protected $table = 'attend';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /*
     * Attendance Time
     * 
     * @param type $day
     * @param type $user_id
     * @param type $shift_id
     * @param type $calc_hour
     * @param type $calc_min
     * @param type $leave_h
     * @param type $break_h
     * 
     * 
     */

    protected static function attend($day, $user_id, $shift_id, $calc_hour, $calc_min, $leave_h, $break_h) {

        $attend = new static(compact('day', 'user_id', 'shift_id', 'calc_hour', 'calc_min', 'leave_h', 'break_h'));

        //do something

        return $attend;
    }

    protected $dateFormat = 'U';

}
