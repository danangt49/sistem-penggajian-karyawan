<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->increments('no_slip_gaji');
            $table->unsignedInteger('nip');
            $table->date('tanggal_gaji');
            $table->integer('total_gaji_pokok');
            $table->integer('total_tunjangan_skill');
            $table->integer('total_biaya_lembur');
            $table->integer('total_kasbon');
            $table->integer('gaji_kotor');
            $table->integer('gaji_bersih');
            $table->string('keterangan');
            $table->enum('status_pengajuan', ['Sudah','Belum']);
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('karyawans')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gajis');
    }
}
