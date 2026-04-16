<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\NotificationLog;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = NotificationLog::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableAlreadyExisted = $this->tableExists();

        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->nullableMorphs('notifiable');
            $table->string('template_id')->nullable()->index();
            $table->string('channel')->index();
            $table->string('status')->default(NotificationLog::STATUS_PENDING)->index();
            $table->text('status_message')->nullable();
            $table->json('data')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('sent_at')->nullable()->index();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->string('tenant_id')->nullable()->index();
            $this->timestamps($table);
        });

        if ($tableAlreadyExisted) {
            $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('notifiable_type')) {
                    $table->string('notifiable_type')->nullable()->after('id');
                }
                if (! $this->hasColumn('notifiable_id')) {
                    $table->unsignedBigInteger('notifiable_id')->nullable()->after('notifiable_type');
                }
                if (! $this->hasColumn('template_id')) {
                    $table->string('template_id')->nullable()->index()->after('notifiable_id');
                }
                if (! $this->hasColumn('channel')) {
                    $table->string('channel')->index()->after('template_id');
                }
                if (! $this->hasColumn('status')) {
                    $table->string('status')->default(NotificationLog::STATUS_PENDING)->index()->after('channel');
                }
                if (! $this->hasColumn('status_message')) {
                    $table->text('status_message')->nullable()->after('status');
                }
                if (! $this->hasColumn('data')) {
                    $table->json('data')->nullable()->after('status_message');
                }
                if (! $this->hasColumn('metadata')) {
                    $table->json('metadata')->nullable()->after('data');
                }
                if (! $this->hasColumn('sent_at')) {
                    $table->timestamp('sent_at')->nullable()->index()->after('metadata');
                }
                if (! $this->hasColumn('delivered_at')) {
                    $table->timestamp('delivered_at')->nullable()->after('sent_at');
                }
                if (! $this->hasColumn('failed_at')) {
                    $table->timestamp('failed_at')->nullable()->after('delivered_at');
                }
                if (! $this->hasColumn('opened_at')) {
                    $table->timestamp('opened_at')->nullable()->after('failed_at');
                }
                if (! $this->hasColumn('clicked_at')) {
                    $table->timestamp('clicked_at')->nullable()->after('opened_at');
                }
                if (! $this->hasColumn('tenant_id')) {
                    $table->string('tenant_id')->nullable()->index()->after('clicked_at');
                }
                $this->updateTimestamps($table);
            });
        }
    }
};
