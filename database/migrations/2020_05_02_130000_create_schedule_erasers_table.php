<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleErasersTable extends Migration
{
    public function up()
    {
        Schema::create('schedule_erasers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignIdFor(app('room'));
            $table->foreignIdFor(app('user'), 'creator_id');
            $table->timestamps();
        });
    }
}
