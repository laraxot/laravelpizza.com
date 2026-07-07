<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\Contact;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Contact::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->increments('id');
            $table->uuidMorphs('model');
            $table->string('contact_type')->nullable();
            $table->string('value')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('verified_at')->nullable();
        });
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('token')) {
                $table->string('token')->nullable();
            }

            if (! $this->hasColumn('first_name')) {
                $table->string('first_name')->nullable();
            }

            if (! $this->hasColumn('last_name')) {
                $table->string('last_name')->nullable();
            }

            if (! $this->hasColumn('sms_sent_at')) {
                $table->timestamp('sms_sent_at')->nullable();
            }

            if (! $this->hasColumn('sms_count')) {
                $table->integer('sms_count')->nullable();
            }

            if (! $this->hasColumn('mail_sent_at')) {
                $table->timestamp('mail_sent_at')->nullable();
            }

            if (! $this->hasColumn('mail_count')) {
                $table->integer('mail_count')->nullable();
            }

            if (! $this->hasColumn('sms_status_code')) {
                $table->string('sms_status_code')->nullable();
            }

            if (! $this->hasColumn('sms_status_txt')) {
                $table->string('sms_status_txt')->nullable();
            }

            if (! $this->hasColumn('usesleft')) {
                $table->string('usesleft')->nullable();
            }

            if (! $this->hasColumn('order_column')) {
                $table->integer('order_column')->nullable();
            }

            if (! $this->hasColumn('duplicate_count')) {
                $table->integer('duplicate_count')->nullable();
            }

            for ($i = 1; $i <= 14; $i++) {
                $column = 'attribute_'.$i;

                if (! $this->hasColumn($column)) {
                    $table->string($column)->nullable();
                }
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
