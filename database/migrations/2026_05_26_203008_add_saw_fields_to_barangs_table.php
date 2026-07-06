<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->integer('urgensi')
                ->default(1);

            $table->integer('lama_penyimpanan')
                ->default(1);

            $table->integer('tingkat_keterlambatan')
                ->default(1);

        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->dropColumn([
                'urgensi',
                'lama_penyimpanan',
                'tingkat_keterlambatan'
            ]);

        });
    }
};