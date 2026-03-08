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
        // @var mixed tableCreate(function (Blueprint $table
            $table->increments('id');
            $table->uuidMorphs('model');
            $table->string('contact_type')->nullable();
            $table->string('value')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('verified_at')->nullable();
        });
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('token'
                $table->string('token')->nullable();
            }
            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
