<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Translation::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('lang')->nullable()->index();
            $table->text('value')->nullable();
            $table->string('namespace')->nullable()->index();
            $table->string('group')->nullable()->index();
            $table->string('item')->nullable();
            $table->string('key')->nullable()->index();
            $table->string('locale')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
        });

        // -- UPDATE --
        // Stessa storia della tabella `posts`: `translations` esisteva gia', quindi il
        // blocco di creazione non e' mai stato eseguito e `key`, `locale` e `user_id`
        // non sono mai arrivate sul database, benche' factory e test le scrivano.
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('key')) {
                $table->string('key')->nullable()->index();
            }
            if (! $this->hasColumn('locale')) {
                $table->string('locale')->nullable()->index();
            }
            if (! $this->hasColumn('user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->index();
            }

            $this->updateTimestamps($table, false);
        });
    }
};
