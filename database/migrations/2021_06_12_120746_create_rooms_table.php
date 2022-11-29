<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->references('id')->on('room_types')
            ->onDelete('cascade');
            $table->string('room_no');
            $table->string('description');
            $table->integer('no_of_beds');
            $table->string('capacity');
            $table->string('status');
            $table->string('fullprice')->default(null);
            $table->string('advance_price')->default(null);
            $table->string('onarrival')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
