<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions;

use Illuminate\Database\Connection;
use Modules\Sigma\Models\Repart;
use Spatie\QueueableAction\QueueableAction;

class MassUpdateStabiTxtReparTxtAction
{
    use QueueableAction;

    /**
     * Execute the action to mass update stabi_txt and repar_txt fields.
     *
     * @param  Connection  $conn  Database connection
     * @param  string  $table  Table name to update
     * @param  string  $where  WHERE clause condition
     */
    public function execute(Connection $conn, string $table, string $where): void
    {
        app(Repart::class);
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $sql = 'update '.$table.' set stabi_txt = (
		select dest1 from generale.repart as B
		where B.ente='.$table.'.ente
		and B.stabi ='.$table.'.stabi
		and B.repar =0
		limit 1
        ) where '.$where;
        $conn->statement($sql);
        $sql =
            'update '
            .$table
            .' set repar_txt = (
            select dest1 from generale.repart as B
            where B.ente='
            .$table
            .'.ente
            and B.stabi ='
            .$table
            .'.stabi
            and B.repar ='
            .$table
            .'.repar
            limit 1
        ) where '
            .$where;

        $conn->statement($sql);
    }
}
