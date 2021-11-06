<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGambar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
        Schema::create('gambar', function (Blueprint $table) {
            $table->id();
            $table->string('id_barang');
            $table->string('gambar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_gambar');
    }
}
