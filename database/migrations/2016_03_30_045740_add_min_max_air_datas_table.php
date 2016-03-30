<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinMaxAirDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('air_datas', function (Blueprint $table) {
            $table->string('max')->after('value')->nullable();
            $table->string('min')->after('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('air_datas', function (Blueprint $table) {
            $table->removeColumn('min');
            $table->removeColumn('max');
        });
    }
}
