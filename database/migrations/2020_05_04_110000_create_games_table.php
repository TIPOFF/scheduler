<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('game_number')->index()->unique(); // Generated by system. This is identifier used to communicate with customers about their game.
            $table->foreignIdFor(app('escaperoom_slot'))->unique(); // All games belong to a slot. They are created on the game day from just those slots that have bookings.
            $table->foreignIdFor(app('room')); // Pulled from the slot
            $table->date('date')->index(); // Pulled from the slot
            $table->dateTime('initiated_at'); // Defaults to slot start time, but can be changed depending on when game actually started
            $table->unsignedTinyInteger('participants'); // Pulled from the slot, but can be updated later if needed.
            $table->boolean('finished')->default(false); // When staff updates the stats about the game (time, clues, reached_final_stage) the game will be marked as finished.
            $table->boolean('escaped')->default(false); // If group escaped in time, then true. Automated by checking time (seconds) against room->theme->duration (minutes)
            $table->unsignedMediumInteger('time')->nullable(); // Escape time of team playing the game in seconds. Will need to be converted
            $table->unsignedTinyInteger('clues')->nullable(); // Number of clues given by the monitor
            $table->boolean('reached_final_stage')->default(false); // If group made it to the final stage of the game, the last 3 steps of room, then true
            $table->foreignIdFor(app('supervision'));
            $table->foreignIdFor(app('user'), 'monitor_id')->nullable();
            $table->foreignIdFor(app('user'), 'receptionist_id')->nullable();
            $table->foreignIdFor(app('user'), 'manager_id')->nullable(); // Only if manager is present at location during the game
            $table->foreignIdFor(app('user'), 'updater_id')->nullable();
            $table->timestamps();
        });
    }
}
