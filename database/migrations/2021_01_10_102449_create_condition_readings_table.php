<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConditionReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'condition_readings',
            function (Blueprint $table) {
                $table->id();
                $table->timestampsTz();

                $table->decimal('temperature');
                $table->decimal('humidity')->nullable();

                $table->unsignedBigInteger('sensor_id');
                $table->foreign('sensor_id')->references('id')->on('sensors');

                $table->unsignedBigInteger('room_id')->nullable();
                $table->foreign('room_id')->references('id')->on('rooms');
            }
        );

        DB::raw(
            "
        SELECT create_hypertable('condition_readings', 'created_at');
        "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condition_readings');
    }
}
