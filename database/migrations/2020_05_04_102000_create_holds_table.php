<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('slot'));
            $table->foreignIdFor(app('user'), 'creator_id')->nullable(); // Null if made through book online. Otherwise, the staff member that is processing the booking.
            $table->softDeletes();
            $table->timestamps(); // Don't need an expiration time, just use 10 minutes after created_at
        });
    }
}
