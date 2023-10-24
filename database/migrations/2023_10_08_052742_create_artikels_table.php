<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('judul');
            $table->integer('idkategori');
            $table->date('tgl');
            $table->string('penulis');
            $table->integer('status');
            $table->text('para1');
            $table->text('para2');
            $table->text('para3');
            $table->text('para4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
