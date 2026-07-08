<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\StabiDirigente as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreatePerformanceStabiDirigenteTable extends XotBaseMigration
{
    protected ?string $model_class = MyModel::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                // Schema::connection('performance')->create('stabi_dirigente', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('stabi')->nullable();
                $table->integer('repar')->nullable();
                $table->string('nome_stabi', 200)->nullable();
                $table->integer('ente')->unsigned()->nullable();
                $table->integer('matr')->unsigned()->nullable();
                $table->string('nome_diri', 250)->nullable();
                $table->integer('anno')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }

                if (! $this->hasColumn('n_diritto_excellence')) {
                    $table->integer('n_diritto_excellence');
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::connection('performance')->drop('stabi_dirigente');
    }
}
