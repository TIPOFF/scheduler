<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecurringSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('recurring_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('room'))->index();
            $table->foreignIdFor(app('rate'))->index();
            $table->string('frequency')->nullable(); // ex.: mon,tue,fri or mon-sun
            $table->string('time_table')->nullable(); // Location's timezone, not UTC. 34 hour military time. ex.: 18:00:00
            $table->date('valid_from'); // Will default to today's date if not set.
            $table->date('expires_at')->nullable();
            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
