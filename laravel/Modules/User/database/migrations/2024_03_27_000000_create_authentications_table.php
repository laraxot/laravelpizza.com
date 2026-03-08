<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
return new class extends XotBaseMigration {
    protected ?string $model_class = Authentication::class;

    /**
     * Esegue la migrazione.
     */
||||||| 6161e129d
return new class extends XotBaseMigration
{
    protected ?string $model_class = Authentication::class;

    /**
     * Esegue la migrazione.
     */
=======
return new class extends Migration {
>>>>>>> feature/ralph-loop-implementation
    public function up(): void
    {
        Schema::create('authentications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authentications');
    }
};
