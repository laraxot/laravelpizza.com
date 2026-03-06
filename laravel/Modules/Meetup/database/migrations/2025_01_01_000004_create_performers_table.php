<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Performer;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Performer::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->string('name')->index();
                $table->string('type')->nullable()->index();
                $table->text('bio')->nullable();
                $table->string('photo')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable()->index();
                $table->string('company')->nullable();
                $table->string('twitter')->nullable();
                $table->string('linkedin')->nullable();
                $table->string('github')->nullable();
                $table->json('meta_data')->nullable();
                $this->timestamps($table);
        });

        $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('name')) {
                    $table->string('name')->index()->after('id');
                }
                if (! $this->hasColumn('type')) {
                    $table->string('type')->nullable()->index()->after('name');
                }
                if (! $this->hasColumn('bio')) {
                    $table->text('bio')->nullable()->after('type');
                }
                if (! $this->hasColumn('photo')) {
                    $table->string('photo')->nullable()->after('bio');
                }
                if (! $this->hasColumn('website')) {
                    $table->string('website')->nullable()->after('photo');
                }
                if (! $this->hasColumn('email')) {
                    $table->string('email')->nullable()->index()->after('website');
                }
                if (! $this->hasColumn('company')) {
                    $table->string('company')->nullable()->after('email');
                }
                if (! $this->hasColumn('twitter')) {
                    $table->string('twitter')->nullable()->after('company');
                }
                if (! $this->hasColumn('linkedin')) {
                    $table->string('linkedin')->nullable()->after('twitter');
                }
                if (! $this->hasColumn('github')) {
                    $table->string('github')->nullable()->after('linkedin');
                }
                if (! $this->hasColumn('meta_data')) {
                    $table->json('meta_data')->nullable()->after('github');
                }
        });
    }
};
