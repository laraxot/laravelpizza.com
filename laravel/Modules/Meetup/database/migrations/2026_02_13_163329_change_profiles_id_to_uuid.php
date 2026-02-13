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
        Schema::connection('meetup')->table('profiles', function (Blueprint $table) {
            // Change id from bigint to varchar(36) for UUID support
            $table->string('id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('meetup')->table('profiles', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
        });
    }
};
