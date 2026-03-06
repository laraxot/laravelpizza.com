<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait EnsuresGeoDatabaseSchema
{
    protected static bool $geoSchemaBootstrapped = false;

    protected function ensureGeoSchema(): void
    {
        if (self::$geoSchemaBootstrapped) {
            return;
        }

        $schema = Schema::connection('geo');

        if (! $schema->hasTable('states')) {
            $schema->create('states', function (Blueprint $table): void {
                $table->id();
                $table->string('state');
                $table->string('state_code', 10);
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('counties')) {
            $schema->create('counties', function (Blueprint $table): void {
                $table->id();
                $table->string('county');
                $table->string('county_code', 10)->nullable();
                $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('localities')) {
            $schema->create('localities', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('slug')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->string('postal_code', 20)->nullable();
                $table->foreignId('county_id')->nullable()->constrained('counties')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('place_types')) {
            $schema->create('place_types', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('places')) {
            $schema->create('places', function (Blueprint $table): void {
                $table->id();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->foreignId('place_type_id')->nullable()->constrained('place_types')->nullOnDelete();
                $table->foreignId('locality_id')->nullable()->constrained('localities')->nullOnDelete();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->string('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('website')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            $schema->table('places', function (Blueprint $table) use ($schema): void {
                if (! $schema->hasColumn('places', 'name')) {
                    $table->string('name')->nullable();
                }
                if (! $schema->hasColumn('places', 'slug')) {
                    $table->string('slug')->nullable();
                }
                if (! $schema->hasColumn('places', 'description')) {
                    $table->text('description')->nullable();
                }
                if (! $schema->hasColumn('places', 'place_type_id')) {
                    $table->foreignId('place_type_id')->nullable()->constrained('place_types')->nullOnDelete();
                }
            });
        }

        if (! $schema->hasTable('addresses')) {
            $schema->create('addresses', function (Blueprint $table): void {
                $table->id();
                $table->morphs('model');
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->string('route')->nullable();
                $table->string('street_number')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('locality')->nullable();
                $table->string('administrative_area_level_1')->nullable();
                $table->string('country', 2)->default('IT');
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->text('formatted_address')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('geonames_caps')) {
            $schema->create('geonames_caps', function (Blueprint $table): void {
                $table->id();
                $table->string('cap');
                $table->string('comune')->nullable();
                $table->string('provincia')->nullable();
                $table->string('regione')->nullable();
                $table->timestamps();
            });
        }

        self::$geoSchemaBootstrapped = true;
    }
}
