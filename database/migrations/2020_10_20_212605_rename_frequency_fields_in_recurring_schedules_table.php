<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFrequencyFieldsInRecurringSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recurring_schedules', function (Blueprint $table) {
            $table->renameColumn('frequency', 'day');
        });

        Schema::table('recurring_schedules', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('recurring_schedules', function (Blueprint $table) {
            $table->renameColumn('time_table', 'time');
        });

        Schema::table('recurring_schedules', function (Blueprint $table) {
            $table->string('day', 3)->change();
            $table->foreignId('rate_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recurring_schedules', function (Blueprint $table) {
            $table->renameColumn('day', 'frequency');
            $table->renameColumn('time', 'time_table');
            $table->softDeletes();
        });
    }
}
