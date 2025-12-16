<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('meetup_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('location');
            $table->string('status')->default('draft'); // draft, published, cancelled
            $table->integer('attendees_count')->default(0);
            $table->integer('max_attendees')->default(100);
            $table->string('cover_image')->nullable();
            $table->json('meta_data')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // creator
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['status', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetup_events');
    }
};