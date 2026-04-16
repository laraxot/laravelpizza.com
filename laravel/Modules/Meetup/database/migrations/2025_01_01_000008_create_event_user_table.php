<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = EventUser::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableAlreadyExisted = $this->tableExists();
        $userClass = XotData::make()->getUserClass();

        $this->tableCreate(function (Blueprint $table) use ($userClass): void {
            $table->id();
            $table->unsignedBigInteger('event_id')->index();
            $table->string('user_id', 36)->index();
            $table->string('status')->default('attending')->index();
            $table->timestamp('registered_at')->nullable();
            $table->unique(['event_id', 'user_id']);
            $table->timestamps();
            $table->foreignIdFor($userClass, 'updated_by')->nullable();
            $table->foreignIdFor($userClass, 'created_by')->nullable();
        });

        if ($tableAlreadyExisted) {
            $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('event_id')) {
                    $table->unsignedBigInteger('event_id')->index()->after('id');
                }
                if (! $this->hasColumn('user_id')) {
                    $table->string('user_id', 36)->index()->after('event_id');
                }
                if (! $this->hasColumn('status')) {
                    $table->string('status')->default('attending')->index()->after('user_id');
                }
                if (! $this->hasColumn('registered_at')) {
                    $table->timestamp('registered_at')->nullable()->after('status');
                }
                $this->updateTimestamps($table);
            });
        }
    }
};
