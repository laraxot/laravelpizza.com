<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Feedback;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Feedback::class;

    public function up(): void
    {
        $tableAlreadyExisted = $this->tableExists();
        $userClass = XotData::make()->getUserClass();

        $this->tableCreate(function (Blueprint $table) use ($userClass): void {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('user_id', 36)->nullable()->index(); // User ID is UUID
            $table->unsignedBigInteger('event_id')->nullable()->index(); // Event ID is BigInt
            $table->integer('rating')->default(0);
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->foreignIdFor($userClass, 'updated_by')->nullable();
            $table->foreignIdFor($userClass, 'created_by')->nullable();
            $table->softDeletes();
            $table->foreignIdFor($userClass, 'deleted_by')->nullable();
        });

        if ($tableAlreadyExisted) {
            $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('uuid')) {
                    $table->uuid('uuid')->nullable()->unique()->after('id');
                }
                if (! $this->hasColumn('user_id')) {
                    $table->string('user_id', 36)->nullable()->index()->after('uuid');
                }
                if (! $this->hasColumn('event_id')) {
                    $table->unsignedBigInteger('event_id')->nullable()->index()->after('user_id');
                }
                if (! $this->hasColumn('rating')) {
                    $table->integer('rating')->default(0)->after('event_id');
                }
                if (! $this->hasColumn('comment')) {
                    $table->text('comment')->nullable()->after('rating');
                }
                $this->updateTimestamps($table, hasSoftDeletes: true);
            });
        }
    }
};
