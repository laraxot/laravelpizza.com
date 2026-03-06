<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Venue;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Venue::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->string('name')->index();
                $table->string('address')->nullable();
                $table->string('city')->nullable()->index();
                $table->string('country')->nullable()->index();
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->integer('capacity')->nullable();
                $table->string('website')->nullable();
                $table->string('phone')->nullable();
                $table->text('description')->nullable();
                $table->json('meta_data')->nullable();
                $this->timestamps($table);
        });

        $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('name')) {
                    $table->string('name')->index()->after('id');
                }
                if (! $this->hasColumn('address')) {
                    $table->string('address')->nullable()->after('name');
                }
                if (! $this->hasColumn('city')) {
                    $table->string('city')->nullable()->index()->after('address');
                }
                if (! $this->hasColumn('country')) {
                    $table->string('country')->nullable()->index()->after('city');
                }
                if (! $this->hasColumn('latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('country');
                }
                if (! $this->hasColumn('longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
                }
                if (! $this->hasColumn('capacity')) {
                    $table->integer('capacity')->nullable()->after('longitude');
                }
                if (! $this->hasColumn('website')) {
                    $table->string('website')->nullable()->after('capacity');
                }
                if (! $this->hasColumn('phone')) {
                    $table->string('phone')->nullable()->after('website');
                }
                if (! $this->hasColumn('description')) {
                    $table->text('description')->nullable()->after('phone');
                }
                if (! $this->hasColumn('meta_data')) {
                    $table->json('meta_data')->nullable()->after('description');
                }
        });
    }
};
