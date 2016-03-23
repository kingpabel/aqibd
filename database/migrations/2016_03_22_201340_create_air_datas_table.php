<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('air_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_time');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('air_type_id')->unsigned();
            $table->foreign('air_type_id')->references('id')->on('air_types')->onDelete('cascade');
            $table->integer('value');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('air_datas');
    }
}
