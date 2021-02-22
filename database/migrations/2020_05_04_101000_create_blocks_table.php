<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('slot'))->index();
            $table->unsignedTinyInteger('participants'); // Number of participants to be blocked in the availability slot
            $table->string('type')->nullable(); // Blocks are automatically applied for Private Games
            $table->foreignIdFor(app('user'), 'creator_id'); // Will be the customer's user ID if it is a private game
            $table->timestamps();
        });
    }
}
