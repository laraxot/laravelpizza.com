<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait EnsuresUiDatabaseSchema
{
    protected static bool $uiSchemaBootstrapped = false;

    protected function ensureUiSchema(): void
    {
        if (self::$uiSchemaBootstrapped) {
            return;
        }

        $schema = Schema::connection('xot');

        if (! $schema->hasTable('themes')) {
            $schema->create('themes', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->json('config')->nullable();
                $table->foreignId('parent_id')->nullable();
                $table->string('source_path')->nullable();
                $table->string('compiled_path')->nullable();
                $table->boolean('needs_compilation')->default(false);
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('components')) {
            $schema->create('components', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('theme_id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->text('config')->nullable();
                $table->boolean('is_active')->default(true);
                $table->string('version')->default('1.0.0');
                $table->json('dependencies')->nullable();
                $table->text('template')->nullable();
                $table->boolean('is_cacheable')->default(false);
                $table->integer('cache_ttl')->default(3600);
                $table->json('validation_rules')->nullable();
                $table->string('view_path')->nullable();
                $table->json('data_schema')->nullable();
                $table->json('responsive_breakpoints')->nullable();
                $table->boolean('supports_lazy_loading')->default(false);
                $table->float('lazy_loading_threshold')->nullable();
                $table->string('cache_strategy')->nullable();
                $table->integer('cache_duration')->nullable();
                $table->timestamps();
            });
        }

        if ($schema->hasTable('components')) {
            $schema->table('components', function (Blueprint $table) use ($schema): void {
                if (! $schema->hasColumn('components', 'supports_lazy_loading')) {
                    $table->boolean('supports_lazy_loading')->default(false);
                }
                if (! $schema->hasColumn('components', 'lazy_loading_threshold')) {
                    $table->float('lazy_loading_threshold')->nullable();
                }
                if (! $schema->hasColumn('components', 'cache_strategy')) {
                    $table->string('cache_strategy')->nullable();
                }
                if (! $schema->hasColumn('components', 'cache_duration')) {
                    $table->integer('cache_duration')->nullable();
                }
            });
        }

        if (! $schema->hasTable('assets')) {
            $schema->create('assets', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('theme_id');
                $table->string('name');
                $table->string('path');
                $table->string('type')->nullable();
                $table->string('disk')->default('public');
                $table->string('extension')->nullable();
                $table->unsignedBigInteger('size')->nullable();
                $table->boolean('is_minified')->default(false);
                $table->boolean('is_compressed')->default(false);
                $table->integer('order')->default(0);
                $table->boolean('should_bundle')->default(false);
                $table->timestamps();
            });
        }

        if ($schema->hasTable('assets')) {
            $schema->table('assets', function (Blueprint $table) use ($schema): void {
                if (! $schema->hasColumn('assets', 'is_minified')) {
                    $table->boolean('is_minified')->default(false);
                }
                if (! $schema->hasColumn('assets', 'is_compressed')) {
                    $table->boolean('is_compressed')->default(false);
                }
                if (! $schema->hasColumn('assets', 'order')) {
                    $table->integer('order')->default(0);
                }
                if (! $schema->hasColumn('assets', 'should_bundle')) {
                    $table->boolean('should_bundle')->default(false);
                }
            });
        }

        if (! $schema->hasTable('collections')) {
            $schema->create('collections', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('theme_id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->text('description')->nullable();
                $table->json('items')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        self::$uiSchemaBootstrapped = true;
    }
}
