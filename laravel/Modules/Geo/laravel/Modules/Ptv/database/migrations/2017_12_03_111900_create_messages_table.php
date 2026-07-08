<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateMessagesTable extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('user_id')->nullable();
                $table->string('type')->nullable();
                $table->string('title')->nullable();
                $table->string('txt')->nullable();
                $table->integer('anno')->nullable();
                // $table->unsignedInteger('likeable_id');
                // $table->string('likeable_type');
                $table->nullableMorphs('post');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            static function (Blueprint $table): void {
                // if (! $this->hasColumn('post_id')) {
                //    $table->integer('post_id')->nullable();
                // }
            }
        );
    }
}
