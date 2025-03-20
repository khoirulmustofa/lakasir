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
        Schema::disableForeignKeyConstraints();
        Schema::table('abouts', function (Blueprint $table) {
            if (Schema::hasColumn('abouts', 'currency')) {
                $table->dropColumn('currency');
            }
        });
        Schema::enableForeignKeyConstraints();
    }

};
