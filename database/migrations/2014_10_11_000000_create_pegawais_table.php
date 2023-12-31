<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->increments('nip');
            $table->unsignedInteger('kd_jabatan');
            $table->integer('gaji_pokok');
            $table->string('nm_pegawai');
            $table->date('tanggal_masuk');
            $table->date('tanggal_lahir');
            $table->string('no_telepon');
            $table->string('alamat');
            $table->enum('status', ['Aktif', 'Belum Aktif', 'Tidak Aktif'])->default('Belum Aktif');
            $table->timestamps();
        
            $table->foreign('kd_jabatan')->references('kd_jabatan')->on('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
}
