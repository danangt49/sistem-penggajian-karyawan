<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_gajis', function (Blueprint $table) {
            $table->increments('id_detail_gaji');
            $table->unsignedInteger('no_slip_gaji');
            $table->unsignedInteger('kd_tunjangan_skill');
            $table->unsignedInteger('kd_kasbon');
            $table->unsignedInteger('kd_lembur');
            $table->unsignedInteger('kd_kehadiran');
            $table->integer('sub_total_tunjangan_skill');
            $table->integer('sub_total_lembur');
            $table->integer('sub_total_kasbon');
            $table->integer('sub_total_kehadiran');
            $table->integer('sub_jumlah_tunjangan');
            $table->integer('sub_jumlah_lembur');
            $table->integer('sub_jumlah_kasbon');
            $table->integer('sub_jumlah_kehadiran');
            $table->timestamps();

            $table->foreign('no_slip_gaji')->references('no_slip_gaji')->on('gajis')->onDelete('cascade');  
            $table->foreign('kd_tunjangan_skill')->references('kd_tunjangan_skill')->on('tunjangan_skills')->onDelete('cascade');  
            $table->foreign('kd_lembur')->references('kd_lembur')->on('lemburs')->onDelete('cascade');  
            $table->foreign('kd_kasbon')->references('kd_kasbon')->on('kasbons')->onDelete('cascade');  
            $table->foreign('kd_kehadiran')->references('kd_kehadiran')->on('kehadirans')->onDelete('cascade');  

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_gajis');
    }
}
