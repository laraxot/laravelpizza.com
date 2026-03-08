<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_organizers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('organization')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->timestamps();
            
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_organizers');
    }
};