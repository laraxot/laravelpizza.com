<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Feedback;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Feedback::class;

    public function up(): void
    {
        if (! $this->tableExists()) {
            $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->uuid('uuid')->nullable()->unique();
                $table->string('user_id', 36)->nullable()->index(); // User ID is UUID
                $table->unsignedBigInteger('event_id')->nullable()->index(); // Event ID is BigInt
                $table->integer('rating')->default(0);
                $table->text('comment')->nullable();
                $this->timestamps($table, hasSoftDeletes: true);
            });
        }
    }
};
