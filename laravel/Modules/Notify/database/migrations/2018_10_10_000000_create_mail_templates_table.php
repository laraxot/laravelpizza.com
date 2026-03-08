<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMailTemplatesTable.
 *
 * Consolidated migration for mail_templates table following "1 Table = 1 Migration File" rule.
 */
return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        // @var mixed tableCreate(function (Blueprint $table
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('mailable')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->json('subject')->nullable();
            $table->json('html_template')->nullable();
            $table->json('text_template')->nullable();
            $table->string('version')->default('1.0.0');
        });

        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('name'
                $table->string('name')->nullable();
            }
            if (! // @var mixed hasColumn('slug'
                $table->string('slug')->unique()->nullable();
            }
            if (! // @var mixed hasColumn('params'
                $table->text('params')->nullable();
            }
            if (! // @var mixed hasColumn('sms_template'
                $table->json('sms_template')->nullable();
            }
            if (! // @var mixed hasColumn('counter'
                $table->integer('counter')->default(0);
            }
            if (! // @var mixed hasColumn('html_layout_path'
                $table->string('html_layout_path')->nullable();
            }
            if (! // @var mixed hasColumn('version'
                $table->string('version')->default('1.0.0');
            }

            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
