<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Sigma\Models\Tqu00f;
use Spatie\QueueableAction\QueueableAction;

class MassUpdateCategoriaEcoAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(Connection $conn, string $table, string $where): bool
    {
        app(Tqu00f::class);
        // $tbl->indexIfNotExists(['propro', 'posfun']);
        /*
         * $fieldz=['propro','posfun'];
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $fieldname = 'categoria_eco';
        if (! Schema::connection($conn->getName())->hasColumn($table, $fieldname)) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $blueprint) use (
                $fieldname,
            ): void {
                $blueprint->string($fieldname);
            });
        }

        $sql =
            'update '.$table.' set categoria_eco = (
		select desc1 from generale.tqu00f as B
		where B.propro = '.$table.'.propro
			and B.posfun = '.$table.'.posfun
			limit 1
		   ) where '.$where;

        return $conn->statement($sql);
    }
}
