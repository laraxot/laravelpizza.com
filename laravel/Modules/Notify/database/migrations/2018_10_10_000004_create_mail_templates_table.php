<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateMailTemplatesTable.
 */
return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE -- Definizione iniziale della tabella
        // @var mixed tableCreate(function (Blueprint $table
            $table->id();
            $table->string('name');
            $table->string('mailable');
            $table->string('slug')->unique();
            $table->json('subject')->nullable();
            $table->json('html_template')->nullable();
            $table->json('text_template')->nullable();
            $table->string('version')->default('1.0.0');
        });

        // -- UPDATE -- Aggiornamento della tabella esistente
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('name'
                $table->string('name');
            }
            if (! // @var mixed hasColumn('slug'
                $table->string('slug')->unique();
            }
            if (! // @var mixed hasColumn('params'
                $table->text('params')->nullable();
            }

            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
