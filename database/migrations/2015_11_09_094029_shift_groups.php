<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShiftGroups extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('shift_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('days');
            $table->string('shift_name');
            $table->string('start_h');
            $table->string('end_h');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('shift_groups');
    }

}
