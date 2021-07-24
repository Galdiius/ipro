<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->string('id_mitra',255)->unique();
            $table->string('nama',100);
            $table->string('email',100);
            $table->text('alamat');
            $table->string('no_hp',13);
            $table->string('koordinat',100);
            $table->enum('status',[0,1]);
            $table->string('token',100);
            $table->string('password',100);
            $table->string('id_proyek',100);
            $table->string('tanggal_verifikasi',100);
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
        Schema::dropIfExists('mitra');
    }
}
