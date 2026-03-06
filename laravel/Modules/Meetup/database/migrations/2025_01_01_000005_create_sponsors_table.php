<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Sponsor;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Sponsor::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! $this->tableExists()) {
            $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->string('name')->index();
                $table->string('level')->nullable()->index();
                $table->string('logo')->nullable();
                $table->string('website')->nullable();
                $table->text('description')->nullable();
                $table->string('contact_email')->nullable()->index();
                $table->string('contact_name')->nullable();
                $table->integer('order')->nullable();
                $table->json('meta_data')->nullable();
                $this->timestamps($table);
            });
        } else {
            $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('name')) {
                    $table->string('name')->index()->after('id');
                }
                if (! $this->hasColumn('level')) {
                    $table->string('level')->nullable()->index()->after('name');
                }
                if (! $this->hasColumn('logo')) {
                    $table->string('logo')->nullable()->after('level');
                }
                if (! $this->hasColumn('website')) {
                    $table->string('website')->nullable()->after('logo');
                }
                if (! $this->hasColumn('description')) {
                    $table->text('description')->nullable()->after('website');
                }
                if (! $this->hasColumn('contact_email')) {
                    $table->string('contact_email')->nullable()->index()->after('description');
                }
                if (! $this->hasColumn('contact_name')) {
                    $table->string('contact_name')->nullable()->after('contact_email');
                }
                if (! $this->hasColumn('order')) {
                    $table->integer('order')->nullable()->after('contact_name');
                }
                if (! $this->hasColumn('meta_data')) {
                    $table->json('meta_data')->nullable()->after('order');
                }
            });
        }
    }
};
