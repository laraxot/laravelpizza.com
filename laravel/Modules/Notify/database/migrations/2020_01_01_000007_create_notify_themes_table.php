<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateThemesTable.
 */
return new class extends XotBaseMigration
{
    // use XotBaseMigrationTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        // @var mixed tableCreate(function (Blueprint $table
            $table->increments('id');
            $table->string('lang')->nullable();
            $table->string('type')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
        });

        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('from'
                $table->string('from')->nullable();
            }

            if (! // @var mixed hasColumn('post_type'
                $table->nullableMorphs('post');
            }

            if (! // @var mixed hasColumn('body_html'
                $table->text('body_html')->nullable();
            }

            if (! // @var mixed hasColumn('theme'
                $table->string('theme')->nullable();
            }

            if (! // @var mixed hasColumn('from_email'
                $table->string('from_email')->nullable();
            }

            if (! // @var mixed hasColumn('logo_src'
                $table->string('logo_src')->nullable();
            }

            if (! // @var mixed hasColumn('logo_width'
                $table->integer('logo_width')->nullable();
            }

            if (! // @var mixed hasColumn('logo_height'
                $table->integer('logo_height')->nullable();
            }

            if (! // @var mixed hasColumn('view_params'
                $table->json('view_params')->nullable();
            }
            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        }); // end update
    }

    // end function up
};
