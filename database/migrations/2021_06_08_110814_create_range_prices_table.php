<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRangePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('range_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->references('id')->on('rooms')
            ->onDelete('cascade');
            $table->foreignId('package_id')->references('id')->on('packages')
            ->onDelete('cascade');
            $table->date('datefrom')->default(null);
            $table->date('dateto')->default(null);
            $table->string('price1')->default(null);
            $table->string('price2')->default(null);
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
        Schema::dropIfExists('range_prices');
    }
}
