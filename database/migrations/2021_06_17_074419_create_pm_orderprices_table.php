<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmOrderpricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_orderprices', function (Blueprint $table) {
            $table->id();
            $table->string('order_price');
            $table->boolean('cc')->default(0);
            $table->boolean('in_person')->default(0);
            $table->boolean('bank_transfer')->default(0);
            $table->string('%_upfront');
            $table->string('%_arrival');
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
        Schema::dropIfExists('pm_orderprices');
    }
}
