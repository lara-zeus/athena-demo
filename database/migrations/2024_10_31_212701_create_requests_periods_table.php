<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('zeus-athena.table-prefix').'requests_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained(config('zeus-athena.table-prefix').'services');
            $table->foreignId('request_id')->constrained(config('zeus-athena.table-prefix').'requests');
            $table->string('appointment');

            if (DB::getDriverName() === 'pgsql') {
                $table->date('appointment_date')->generatedAs('cast(`appointment` as date)');
                $table->time('appointment_time')->generatedAs('cast(`appointment` as time)');
            } else {
                $table->date('appointment_date')->virtualAs('cast(`appointment` as date)');
                $table->time('appointment_time')->virtualAs('cast(`appointment` as time)');
            }

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
        Schema::dropIfExists(config('zeus-athena.table-prefix').'requests_periods');
    }
};
