<?php

namespace attend;

use Illuminate\Database\Eloquent\Model;

class extra extends Model {
    /*
     * The table associated with the model.
     * 
     * @var string
     * 
     */

    protected $table = 'extra';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /*
     * Extra Time
     * 
     * @param type $day
     * @param type $user_id
     * @param type $shift_id
     * @param type $extra_h
     * @param type $extra_m
     * @param type $calc_hour
     * @param type $calc_min
     * @param type $leave_h
     * @param type $leave_m

     * 
     * 
     */

    protected static function extra($day, $user_id, $shift_id, $extra_h, $extra_m, $calc_hour, $calc_min, $leave_h, $leave_m) {

        $extra = new static(compact('day', 'user_id', 'shift_id', 'extra_h', 'extra_m', 'calc_hour', 'calc_min', 'leave_h', 'leave_m'));

        //do something

        return $extra;
    }

}
