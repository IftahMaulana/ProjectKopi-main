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
        Schema::table('tbl_carts', function (Blueprint $table) {
            $table->unsignedBigInteger('code_transaksi')->nullable()->after('id');
            
            // Add the foreign key constraint
            $table->foreign('code_transaksi')
                  ->references('code_transaksi')
                  ->on('detail_transaksis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_carts', function (Blueprint $table) {
            //
        });
    }
};
