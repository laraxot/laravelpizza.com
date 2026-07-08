<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Extras;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\IndennitaResponsabilita\Models\LettI;
use Modules\Performance\Models\BaseIndividualeModel;
use Modules\Performance\Models\Individuale;
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Models\SchedaCriteri;
use Modules\Ptv\Models\BaseScheda;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Codici;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Repart;
use Modules\Sigma\Models\Tqu00f;

// ------- services -------

trait MassExtra
{
    /**
     * Resolve a concrete model instance for table/connection access.
     */
    private static function getConcreteInstance(): EloquentModel
    {
        $class = static::class;
        $reflection = new \ReflectionClass($class);

        if (! $reflection->isAbstract()) {
            return new $class;
        }

        $fallbackMap = [
            BaseIndividualeModel::class => [
                Individuale::class,
                IndennitaResponsabilita::class,
                LettF::class,
                LettI::class,
            ],
            BaseScheda::class => [
                Scheda::class,
                SchedaCriteri::class,
            ],
        ];

        $candidates = [];
        if (array_key_exists($class, $fallbackMap)) {
            $candidates = $fallbackMap[$class];
        }

        if (! empty($candidates)) {
            foreach ($candidates as $concreteClass) {
                if (! class_exists($concreteClass)) {
                    continue;
                }

                return new $concreteClass;
            }
        }

        $model = static::query()->getModel();

        return $model;
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateCognomeNome(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $model = $params['model'] ?? null;
        if ($model instanceof Model) {
            $table = $model->getTable();
            $conn = $model->getConnection();
        }

        $tbl = new Ana10f;

        /*
         * $fieldz=['ente','matr'];
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        if (! is_string($table) || $table === '') {
            throw new \Exception('table is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }
        if ($conn === null || ! ($conn instanceof Connection)) {
            throw new \Exception('conn is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }
        /** @var Connection $connTyped */
        $connTyped = $conn;
        // $table and $where are already validated as non-empty-string above
        $tableTyped = $table;
        $whereTyped = $where;

        $sql = 'update '.$tableTyped.' set cognome = (select conome from generale.ana10f
		where ana10f.ente='.$tableTyped.'.ente and
			  ana10f.matr='.$tableTyped.'.matr limit 1)
		where '.$whereTyped;
        $connTyped->statement($sql);
        $sql = 'update '.$tableTyped.' set nome = (select nome from generale.ana10f
		where ana10f.ente='.$tableTyped.'.ente and
			  ana10f.matr='.$tableTyped.'.matr
			  limit 1)
		where '.$whereTyped;
        $connTyped->statement($sql);
    }

    // end massUpdateCognomeNome

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateCategoriaEco(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $tbl = new Tqu00f;

        /*
         * $fieldz=['propro','posfun'];
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $fieldname = 'categoria_eco';
        /** @var Connection $connTyped */
        $connTyped = $conn;
        // $table is already validated as non-empty-string above (getTable() returns string)
        $tableTyped = $table;
        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        if (! Schema::connection($connTyped->getName())->hasColumn($tableTyped, $fieldname)) {
            Schema::connection($connTyped->getName())->table($tableTyped, static function (Blueprint $table) use ($fieldname): void {
                $table->string($fieldname);
            });
        }

        $sql =
            'update '.$tableTyped.' set categoria_eco = (
		select desc1 from generale.tqu00f as B
		where B.propro = '.$tableTyped.'.propro
			and B.posfun = '.$tableTyped.'.posfun
			limit 1
		   ) where '.$whereTyped;
        $connTyped->statement($sql);
    }

    // end function

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdatePosizTxt(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $tbl = new Codici;
        // $tbl->indexIfNotExists(['tipo', 'codice']);

        $fieldname = 'posiz_txt';
        /** @var Connection $connTyped */
        $connTyped = $conn;
        // $table is already validated as non-empty-string above (getTable() returns string)
        $tableTyped = $table;
        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        if (! Schema::connection($connTyped->getName())->hasColumn($tableTyped, $fieldname)) {
            Schema::connection($connTyped->getName())->table($tableTyped, static function (Blueprint $table) use ($fieldname): void {
                $table->integer($fieldname);
            });
        }

        $sql = 'update '.$tableTyped.' set posiz_txt = (
		select desc1 from generale.codici as B
		where B.tipo = 19
			and B.codice = '.$tableTyped.'.posiz
			limit 1
		) where '.$whereTyped;
        $connTyped->statement($sql);
    }

    // end function

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateStabiTxtReparTxt(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $tbl = new Repart;
        $fieldz = ['ente', 'stabi', 'repar'];
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

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGInSede(array $params): void
    {
        self::massUpdateGGInSedeQua00f($params);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGInSedeQua00f(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();
        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $tbl = new Qua00f;
        $fieldz = ['ente', 'matr', 'propro', 'posfun', 'quaann', 'qua2kd', 'qua2ka'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $conn1 = $tbl->getConnection();
        $tblName = $tbl->getTable();
        /** @var Connection $conn1Typed */
        $conn1Typed = $conn1;
        /** @var string $tblNameTyped */
        $tblNameTyped = $tblName;
        if (! Schema::connection($conn1Typed->getName())->hasColumn($tblNameTyped, 'gg_in_sede')) {
            Schema::connection($conn1Typed->getName())->table($tblNameTyped, static function (Blueprint $table): void {
                $table->integer('gg_in_sede');
            });
        }

        $diff_sql = self::date_diff_sql('qua2kd', 'qua2ka', $params);
        /* categoria_ecoval o categoria_eco e basta ? */
        $fino_al = $params['fino_al'] ?? null;
        if (! is_string($fino_al) || $fino_al === '') {
            throw new \Exception('fino_al is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }
        $fino_dal = $params['fino_dal'] ?? null;

        // $table is already validated as non-empty-string above (getTable() returns string)
        $tableTyped = $table;
        /** @var Connection $connTyped */
        $connTyped = $conn;
        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        /** @var non-empty-string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        $fino_alParam = $fino_al;
        /** @var non-empty-string $fino_alTyped */
        $fino_alTyped = $fino_alParam;

        $sql =
            'update '
            .$tableTyped
            .' set gg_in_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua00f as B
		where B.ente='
            .$tableTyped
            .'.ente
		and   B.matr='
            .$tableTyped
            .'.matr
		and quaann=""
		and '
            .$fino_alTyped
            .'>= qua2kd
		';
        if (isset($fino_dal) && is_string($fino_dal) && $fino_dal !== '') {
            /** @var non-empty-string $fino_dalTyped */
            $fino_dalTyped = $fino_dal;
            $sql .= \chr(13).'and ('.$fino_dalTyped.'<=qua2ka or qua2ka=0) '.\chr(13);
        }

        $sql .= ' ) where '.$whereTyped;
        $connTyped->statement($sql);
    }

    // ---------------------------------------------------------------------------
    public static function date_limit_sql_to(string $field, string $date): string
    {
        // retrocomp
        if ($date === '') {
            return $field;
        }

        return 'if('.$field.'=0 or '.$field.'>'.$date.' ,'.$date.','.$field.')';
    }

    public static function date_limit_sql_from(string $field, string $date): string
    {
        if ($date === '') {
            return $field;
        } // lo zero lo tengo per leggibilita' azione in teoria impossibile, ma cosi' prevengo errori

        return 'if('.$field.'=0 or '.$field.'<'.$date.' ,'.$date.','.$field.')';
    }

    // -----------------------------------------------------------------------------

    // -----------------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function date_diff_sql(string $field_dal, string $field_al, array $params): string
    {
        $dal = $field_dal;
        $al = $field_al;
        if (isset($params['fino_dal']) && is_string($params['fino_dal'])) {
            $dal = self::date_limit_sql_from($field_dal, $params['fino_dal']);
        }

        if (isset($params['fino_al']) && is_string($params['fino_al'])) {
            $al = self::date_limit_sql_to($field_al, $params['fino_al']);
        }

        // $sql='if(COALESCE(sum(datediff('.$al.','.$dal.')+1),0)<0, 0 ,COALESCE(sum(datediff('.$al.','.$dal.')+1),0))';
        // $sql='GREATEST(COALESCE(sum(datediff('.$al.','.$dal.')+1),0),0)';
        $sql = 'COALESCE(sum(greatest(datediff('.$al.','.$dal.')+1,0)),0)';

        return $sql;
    }

    // -----------------------------------------------------------------------------

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGPosizInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $posiz = $params['posiz'] ?? null;
        if (! isset($posiz)) {
            throw new \Exception('posiz is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $tbl = new Qua00f;
        $fieldz = ['ente', 'matr', 'propro', 'posfun', 'quaann', 'qua2kd', 'qua2ka'];
        // $tbl->indexIfNotExists($fieldz);

        $conn1 = $tbl->getConnection();
        $tbl = $tbl->getTable();
        if (! Schema::connection($conn1->getName())->hasColumn($tbl, 'gg_in_sede')) {
            Schema::connection($conn1->getName())->table($tbl, static function (Blueprint $table): void {
                $table->integer('gg_in_sede');
            });
        }

        $diff_sql = self::date_diff_sql('qua2kd', 'qua2ka', $params);
        /* categoria_ecoval o categoria_eco e basta ? */
        /** @var non-empty-string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        // $table is already validated as non-empty-string above
        $tableTyped = $table;
        /** @var string|int $posizTyped */
        $posizTyped = $posiz;
        $finoAlParam = $params['fino_al'] ?? null;
        /** @var non-empty-string $fino_alTyped */
        $fino_alTyped = is_string($finoAlParam) && $finoAlParam !== '' ? $finoAlParam : throw new \Exception('fino_al must be non-empty string');
        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        $sql =
            'update '
            .$tableTyped
            .' set gg_posiz_'
            .(string) $posizTyped
            .'_in_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua00f as B
		where B.ente='
            .$tableTyped
            .'.ente
		and   B.matr='
            .$tableTyped
            .'.matr
		and quaann=""
		and posiz='
            .(string) $posizTyped
            .'
		and '
            .$fino_alTyped
            .'>= qua2kd
		';
        $fino_dal = $params['fino_dal'] ?? null;
        if (is_string($fino_dal) && $fino_dal !== '') {
            $sql .= \chr(13).'and ('.$fino_dal.'<=qua2ka or qua2ka=0) '.\chr(13);
        }

        $sql .= ' ) where '.$whereTyped;
        echo '<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    // end function

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAnnoInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();
        $field = 'gg_presenze_in_anno';
        $anno = $params['anno'] ?? null;
        $where = $params['where'] ?? null;
        if (! is_numeric($anno)) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $tbl = new Qua00f;
        $fieldz = ['ente', 'matr', 'quaann', 'qua2kd', 'qua2ka'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field_i) {
         * FilterTrait::indexIfNotExists($field_i, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        if (! Schema::connection($conn->getName())->hasColumn($table, $field)) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table) use ($field): void {
                $table->integer($field);
            });
        }

        $sql =
            'update '
            .$table
            .' set '
            .$field
            .' = (
			select sum(datediff(if(qua2ka=0,'
            .$anno
            .'1231,qua2ka),if(qua2kd<'
            .$anno
            .'0101,'
            .$anno
            .'0101,qua2kd))+1) as gg
			from generale.'
            .$tbl->getTable()
            .' as B
			where B.ente='
            .$table
            .'.ente
			and   B.matr='
            .$table
            .'.matr

			and quaann=""
			and (
				( '
            .$anno
            .' between year(qua2kd) and year(qua2ka) )
				or
				('
            .$anno
            .' >= year(qua2kd) and qua2ka=0 )
			)
		)  where '
            .$where;
        echo '<hr/>['.__LINE__.']['.__FILE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAssenzeAnnoInSede(array $params): void
    {
        $params['umi'] = 'G';
        if (! isset($params['field'])) {
            $params['field'] = 'gg_assenze_in_anno';
        }

        self::massUpdateUMIAssenzeAnnoInSede($params);
    }

    // --------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateHHAssenzeAnnoInSede(array $params): void
    {
        $params['umi'] = 'O';
        if (! isset($params['field'])) {
            $params['field'] = 'ore_assenze_in_anno';
        }

        self::massUpdateUMIAssenzeAnnoInSede($params);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateUMIAssenzeAnnoInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        // $field='gg_assenze_in_anno';
        $anno = $params['anno'] ?? null;
        $where = $params['where'] ?? null;
        $umi = $params['umi'] ?? null;
        $field = $params['field'] ?? null;
        // $tbl= new Asz00f();
        $tbl = new Asz00k1;
        $fieldz = ['ente', 'matr', 'aszumi', 'aszann', 'asz2kd', 'asz2ka'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field_i) {
         * FilterTrait::indexIfNotExists($field_i, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        /*
         * if (! Schema::connection($conn->getName())->hasColumn($table, $field)) {
         * Schema::connection($conn->getName())->table($table, function ($table) use ($field): void {
         * $table->integer($field);
         * });
         * }
         */
        if (! is_numeric($anno)) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! isset($umi)) {
            throw new \Exception('umi is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! isset($field)) {
            throw new \Exception('field is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        /** @var non-empty-string $tableTyped */
        $tableTyped = $table;
        /** @var non-empty-string $fieldTyped */
        $fieldTyped = is_string($field) && $field !== '' ? $field : throw new \Exception('field must be non-empty string');
        $tblTableName = $tbl->getTable();
        /** @var non-empty-string $tblTableName */
        $tblTableTyped = is_string($tblTableName) && $tblTableName !== '' ? $tblTableName : throw new \Exception('tbl table name must be non-empty string');
        /** @var string $umiTyped */
        $umiTyped = is_string($umi) ? $umi : (string) $umi;
        $sql =
            'update '
            .$tableTyped
            .' set '
            .$fieldTyped
            .' = (
			select sum(datediff(asz2ka,asz2kd)+1) as gg
			from generale.'
            .$tblTableTyped
            .' as B
			where B.ente='
            .$tableTyped
            .'.ente
			and   B.matr='
            .$tableTyped
            .'.matr
			and aszumi="'
            .$umiTyped
            .'"
			and aszann=""
			and (
				( '
            .$anno
            .' between year(asz2kd) and year(asz2ka) )
				or
				('
            .$anno
            .' >= year(asz2kd) and asz2ka=0 )
			)
		)  where '
            .$where;
        echo '<hr/>['.__LINE__.']['.__FILE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    // -------------------------------------------------------------------
    // ------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();
        $where = $params['where'] ?? null;
        if (! isset($where)) {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        // $diff_sql=self::date_diff_sql('qua2kd','qua2ka',$params); //bug ?
        $diff_sql = self::date_diff_sql('q32kd', 'q32ka', $params);
        $tbl = new Qua03f;
        $fieldz = ['ente', 'matr', 'q3desc', 'q32ka', 'q32kd', 'q3ann'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */

        // where q3desc not like "%ricon%"  and q3desc not like "%riscatto%"
        /** @var non-empty-string $tableTyped */
        $tableTyped = $table;
        /** @var string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        /** @var string $whereTyped */
        $whereTyped = $where;
        $finoAlParam = $params['fino_al'] ?? null;
        /** @var string $fino_alTyped */
        $fino_alTyped = $finoAlParam ?? '';
        $sql =
            'update '
            .$tableTyped
            .' set gg_fuori_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua03f as B
		where find_in_set(q3tipo,"101,102,103,104,105,121")
		and q3ann=""
		and q32ka!=0
		and  B.ente = '
            .$tableTyped
            .'.ente
		and  B.matr= '
            .$tableTyped
            .'.matr
		and '
            .$fino_alTyped
            .'>= q32kd
	) where '
            .$whereTyped;
        $conn->statement($sql);
        // ------- numero periodi
        $sql =
            'update '
            .$tableTyped
            .' set n_gg_fuori_sede = (
		select count(*) as q
		from generale.qua03f as B
		where find_in_set(q3tipo,"101,102,103,104,105,121")
		and q3ann=""
		and q32ka!=0
		and  B.ente = '
            .$tableTyped
            .'.ente
		and  B.matr= '
            .$tableTyped
            .'.matr
		and '
            .(is_string($params['fino_al'] ?? null) ? $params['fino_al'] : '')
            .'>= q32kd
	) where '
            .$whereTyped;
        $conn->statement($sql);

        // ------- numero periodi
    }

    // ------------------------------------------------------------------
    // ------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGCatEcoInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $anno = $params['anno'] ?? null;

        $tbl = new Qua00f;
        $fieldz = ['ente', 'matr', 'propro', 'posfun', 'quaann', 'qua2kd', 'qua2ka'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $conn1 = $tbl->getConnection();
        $tbl = $tbl->getTable();
        if (! Schema::connection($conn1->getName())->hasColumn($tbl, 'categoria_eco')) {
            Schema::connection($conn1->getName())->table($tbl, static function (Blueprint $table): void {
                $table->string('categoria_eco');
            });
        }

        /*  !!!!!!!!!!!!!!!! DA FIX !!!!!!!!!!!!!!!!!!!
         \DB::update('update generale.'.$tbl.' set categoria_eco = (select categoria from progressione.categoria_propro where find_in_set(propro,lista_propro) and anno='.$anno.')');
         */

        $diff_sql = self::date_diff_sql('qua2kd', 'qua2ka', $params);
        /* categoria_ecoval o categoria_eco e basta ? */
        // B.categoria_eco<='.$table.'.categoria_ecoval  per caso mattara che era D poi tornata C, prob
        // metteremo parametro
        /** @var string $tableTyped */
        $tableTyped = $table;
        /** @var string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        /** @var string $fino_alTyped */
        $fino_alTyped = $params['fino_al'] ?? '';
        $sql =
            'update '
            .$tableTyped
            .' set gg_cateco_in_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua00f as B
		where B.ente='
            .$tableTyped
            .'.ente
		and   B.matr='
            .$tableTyped
            .'.matr

		and   B.categoria_eco>='
            .$tableTyped
            .'.categoria_ecoval
		and quaann=""
		and '
            .$fino_alTyped
            .'>= qua2kd
		';
        $fino_dal = $params['fino_dal'] ?? null;
        if (is_string($fino_dal) && $fino_dal !== '') {
            $sql .= \chr(13).'and ('.$fino_dal.'<=qua2ka or qua2ka=0) '.\chr(13);
        }

        $sql .= ' ) where '.$where;
        echo '<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    // end function

    // ----------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGCatEcoPosfunInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $params_fino_al = $params['fino_al'] ?? null;
        $params_fino_dal = $params['fino_dal'] ?? null;

        $diff_sql = self::date_diff_sql('qua2kd', 'qua2ka', $params);
        $tbl = new Qua00f;
        $fieldz = ['ente', 'matr', 'propro', 'posfun', 'quaann', 'qua2kd', 'qua2ka'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */

        $conn1 = $tbl->getConnection();
        $tbl1 = $tbl->getTable();
        if (! Schema::connection($conn1->getName())->hasColumn($tbl1, 'categoria_eco')) {
            Schema::connection($conn1->getName())->table($tbl1, static function (Blueprint $table): void {
                $table->string('categoria_eco');
            });
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_cateco_posfun_in_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_cateco_posfun_in_sede');
            });
        }

        /*  !!!!!!!!!!! DA FIX !!!!!!!!!!!!!!!!!!!!!
         * \DB::update(
         * 'update generale.'.$tbl1.' set categoria_eco =
         * ( select categoria from progressione.categoria_propro where find_in_set(propro,lista_propro) )'
         * );
         */
        // --- de gioia ha un periodo superiore in mezzo  substr(B.posfun,-1)<=substr('.$table.'.posfun,-1)
        // $table is already validated as non-empty-string above
        $tableTyped = $table;
        /** @var non-empty-string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        $finoAlParam = $params['fino_al'] ?? null;
        /** @var string $finoAlParam */
        $finoAlParamTyped = is_string($finoAlParam) ? (string) $finoAlParam : '';
        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        $sql =
            'update '
            .$tableTyped
            .' set gg_cateco_posfun_in_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua00f as B
		where B.ente='
            .$tableTyped
            .'.ente
		and   B.matr='
            .$tableTyped
            .'.matr
		and (
			B.categoria_eco>'
            .$tableTyped
            .'.categoria_ecoval
			or(
				B.categoria_eco='
            .$tableTyped
            .'.categoria_ecoval
				and   substr(B.posfun,-1)>=substr('
            .$tableTyped
            .'.posfun,-1)
			)
		)
		and quaann=""
		and '
            .$finoAlParamTyped
            .'>= qua2kd
		) where '
            .$whereTyped;
        echo '[Sigma\\Models\\Anag]['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    // ----------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGCatEcoFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $params_fino_al = $params['fino_al'] ?? null;

        $tbl = new Qua03f;
        $fieldz = ['ente', 'matr', 'q3desc', 'q3pro', 'q3fun', 'q32kd', 'q32ka', 'q3ann'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $conn1 = $tbl->getConnection();
        $tbl1 = $tbl->getTable();
        if (! Schema::connection($conn1->getName())->hasColumn($tbl1, 'categoria_eco')) {
            Schema::connection($conn1->getName())->table($tbl1, static function (Blueprint $table): void {
                $table->string('categoria_eco');
            });
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_cateco_fuori_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_cateco_fuori_sede');
            });
        }

        // !!!!!!!!!!! DA FIX !!!!!!!!!!!!!!!!!!!
        /*
         * \DB::update(
         * 'update generale.'.$tbl1.' set categoria_eco =
         * ( select categoria from progressione.categoria_propro where find_in_set(q3pro,lista_propro) and anno='.$anno.')'
         * );
         */
        $diff_sql = self::date_diff_sql('q32kd', 'q32ka', $params);

        // where q3desc not like "%ricon%"  and q3desc not like "%riscatto%"
        // $table is already validated as non-empty-string above
        $tableTyped = $table;
        /** @var non-empty-string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        /** @var non-empty-string $finoAlParam */
        $finoAlParam = $params['fino_al'] ?? throw new \Exception('fino_al must be non-empty string');
        $sql =
            'update '
            .$tableTyped
            .' set gg_cateco_fuori_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua03f as B
		where find_in_set(q3tipo,"101,102,103,104,105,121")
		and q3ann=""
		and q32ka!=0
		and  B.ente = '
            .$tableTyped
            .'.ente
		and  B.matr= '
            .$tableTyped
            .'.matr

		and   B.categoria_eco='
            .$tableTyped
            .'.categoria_ecoval
		and '
            .$finoAlParam
            .'>= q32kd
	) where '
            .$where;
        $conn->statement($sql);
    }

    // --------------------------------------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGCatEcoPosfunFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $params_fino_al = $params['fino_al'] ?? null;

        $diff_sql = self::date_diff_sql('q32kd', 'q32ka', $params);
        $tbl = new Qua03f;
        $fieldz = ['q3desc', 'q3ann', 'q32ka', 'q32kd', 'ente', 'matr', 'q3pro', 'q3fun'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        $conn1 = $tbl->getConnection();
        $tbl1 = $tbl->getTable();
        if (! Schema::connection($conn1->getName())->hasColumn($tbl1, 'categoria_eco')) {
            Schema::connection($conn1->getName())->table($tbl1, static function (Blueprint $table): void {
                $table->string('categoria_eco');
            });
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_cateco_posfun_fuori_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_cateco_posfun_fuori_sede');
            });
        }

        // !!!!!!!!!!! DA FIX !!!!!!!!!!!!!!!!!!!
        /*
         * \DB::update(
         * 'update generale.'.$tbl1.' set categoria_eco =
         * ( select categoria from progressione.categoria_propro where find_in_set(q3pro,lista_propro) )'
         * );
         */

        // where q3desc not like "%ricon%"  and q3desc not like "%riscatto%"
        /** @var non-empty-string $tableTyped */
        $tableTyped = $table;
        /** @var non-empty-string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        /** @var non-empty-string $finoAlParam */
        $finoAlParam = $params['fino_al'] ?? throw new \Exception('fino_al must be non-empty string');
        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        $sql =
            'update '
            .$tableTyped
            .' set gg_cateco_posfun_fuori_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.qua03f as B

		where find_in_set(q3tipo,"101,102,103,104,105,121")

		and q3ann=""
		and q32ka!=0
		and  B.ente = '
            .$tableTyped
            .'.ente
		and  B.matr= '
            .$tableTyped
            .'.matr

		and   B.categoria_eco='
            .$tableTyped
            .'.categoria_ecoval
		and   B.q3fun='
            .$tableTyped
            .'.posfun
		and '
            .$finoAlParam
            .'>= q32kd
	) where '
            .$whereTyped;
        $conn->statement($sql);
    }

    // --------------------------------------------------------------------------------------------------
    // -----------------------------------------------------------------------------

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGNOCatEcoInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_no_cateco_in_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_no_cateco_in_sede');
            });
        }

        $sql = 'update '.$table.' set gg_no_cateco_in_sede = (
		gg_in_sede - gg_cateco_in_sede
	) where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGNOCatEcoFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_no_cateco_fuori_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_no_cateco_fuori_sede');
            });
        }

        $sql = 'update '.$table.' set gg_no_cateco_fuori_sede = (
		gg_fuori_sede - gg_cateco_fuori_sede
	) where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGNOCatEcoPosfunInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_no_cateco_posfun_in_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_no_cateco_posfun_in_sede');
            });
        }

        $sql = 'update '.$table.' set gg_no_cateco_posfun_in_sede = (
		gg_in_sede - gg_cateco_posfun_in_sede
	) where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGNOCatEcoPosfunFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_no_cateco_posfun_fuori_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_no_cateco_posfun_fuori_sede');
            });
        }

        $sql = 'update '.$table.' set gg_no_cateco_posfun_fuori_sede = (
		gg_fuori_sede - gg_cateco_posfun_fuori_sede
	) where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAspettativeInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();
        $where = $params['where'] ?? null;
        $lista_codici_aspettative = $params['lista_codici_aspettative'] ?? null;
        $params_fino_al = $params['fino_al'] ?? null;
        $params_fino_dal = $params['fino_dal'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! is_string($lista_codici_aspettative) || $lista_codici_aspettative === '') {
            throw new \Exception('lista_codici_aspettative is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $diff_sql = self::date_diff_sql('asz2kd', 'asz2ka', $params);
        $tbl = new Asz00k1;
        $fieldz = ['asztip', 'aszcod', 'aszann', 'ente', 'matr', 'asz2kd', 'asz2ka'];
        // $tbl->indexIfNotExists($fieldz);
        /*
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field, $tbl->getTable(), $tbl->getConnection());
         * }
         */
        /** @var non-empty-string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        /** @var non-empty-string $tableTyped */
        $tableTyped = $table;
        /** @var non-empty-string $lista_codici_aspettativeTyped */
        $lista_codici_aspettativeTyped = $lista_codici_aspettative;
        /** @var non-empty-string $whereTyped */
        $whereTyped = $where;
        /** @var non-empty-string $fino_alTyped */
        $fino_alTyped = is_string($params['fino_al'] ?? null) && '' !== ($params['fino_al'] ?? '') ? $params['fino_al'] : '';
        $sql =
            'update '
            .$tableTyped
            .' set gg_aspettative_in_sede = (
		select '
            .$diff_sqlTyped
            .' as giorni
		from generale.asz00k1 as B
		where B.aszann=""
		and  B.ente = '
            .$tableTyped
            .'.ente
		and  B.matr= '
            .$tableTyped
            .'.matr
		and find_in_set(concat(asztip,"-",aszcod),"'
            .$lista_codici_aspettativeTyped
            .'")
		and '
            .$fino_alTyped
            .'>= asz2kd
	';
        $fino_dal = $params['fino_dal'] ?? null;
        if (is_string($fino_dal) && $fino_dal !== '') {
            $sql .= \chr(13).'and ('.$fino_dal.'<=asz2ka or asz2ka=0) '.\chr(13);
        }

        $sql .= ' ) where '.$whereTyped;
        echo '['.__LINE__.']['.__FILE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAspettativeFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $sql = 'update '.$table.' set gg_aspettative_fuori_sede = 0
		where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAspettativeCatEcoPondInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $table_aspettative = $params['table_aspettative'] ?? null;
        if (! is_string($table_aspettative) || $table_aspettative === '') {
            throw new \Exception('table_aspettative is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $lista_codici_aspettative = $params['lista_codici_aspettative'] ?? null;
        if (! is_string($lista_codici_aspettative) || $lista_codici_aspettative === '') {
            throw new \Exception('lista_codici_aspettative is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        // $tbl= new AspettativeProgressione();
        /* tbl lo passo da params cosi miglioro.
         * $fieldz=['asztip','aszcod','aszann','ente','matr','asz2kd','asz2ka'];
         * foreach ($fieldz as  $field) {
         * FilterTrait::indexIfNotExists($field,$tbl->getTable(),$tbl->getConnection());
         * }
         */
        // da rifare con truncate ed insert quando siamo stabili
        /** @var non-empty-string $table_aspettativeTyped */
        $table_aspettativeTyped = $table_aspettative;
        /** @var non-empty-string $lista_codici_aspettativeTyped */
        $lista_codici_aspettativeTyped = $lista_codici_aspettative;
        /** @var Connection $connTyped */
        $connTyped = $conn;
        $sql = 'drop table if exists '.$table_aspettativeTyped.';';
        $res = $connTyped->statement($sql);
        $sql =
            'create table '
            .$table_aspettativeTyped
            .'
	(select
		distinct B.ente,B.matr,asztip,aszcod,asz2kd,asz2ka,qua2kd,qua2ka
		,if(asz2kd>qua2kd,asz2kd,qua2kd) as dal,if(asz2ka<qua2ka,asz2ka,if(qua2ka=0,asz2ka,qua2ka)) as al
		,propro,posfun,"AAA" as categoria_eco,9999 as propro_val,9999 as posfun_val,"AAA" as categoria_eco_val,9999999999 as gg,999.99 as peso,9999999999.99 as gg_pond

		from generale.asz00k1 as B
		join generale.qua00f as Q
		on Q.ente=B.ente
		and Q.matr=B.matr
		and (
			(Q.qua2kd between B.asz2kd and B.asz2ka) or
			(Q.qua2kd >= B.asz2kd and B.asz2ka=0) or
			(B.asz2kd between Q.qua2kd and Q.qua2ka) or
			(B.asz2kd >= Q.qua2kd and Q.qua2ka=0)
		)

		where B.aszann=""
		and Q.quaann=""
		and find_in_set(concat(asztip,"-",aszcod),"'
            .$lista_codici_aspettativeTyped
            .'")

	);';
        $res = $connTyped->statement($sql);
        $parz = $params;
        $parz['table'] = $table_aspettativeTyped;
        $diff_sql = self::date_diff_sql('dal', 'al', $parz);

        // echo '<pre>';print_r($diff_sql);echo '</pre>';
        /** @var string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        $diff_sqlTyped = str_replace('COALESCE(sum(greatest(', '', $diff_sqlTyped);
        $diff_sqlTyped = str_replace(',dal)+1,0)),0)', ',dal)+1', $diff_sqlTyped);
        $diff_sqlTyped = str_replace(',dal))+1,0)),0)', ',dal))+1', $diff_sqlTyped);

        $sql = 'update '.$table_aspettativeTyped.' set gg=greatest('.$diff_sqlTyped.',0)';
        // echo '<pre>'.$sql.'</pre>';die('<hr/>['.__LINE__.']['.__FILE__.']');
        $res = $connTyped->statement($sql);
        // ---------
        $coeff = $params['coeff'] ?? null;
        if (! is_array($coeff) && ! is_object($coeff)) {
            throw new \Exception('coeff is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }
        /** @var array<string, mixed>|object $coeffTyped */
        $coeffTyped = $coeff;

        if (is_array($coeffTyped)) {
            if (! isset($coeffTyped['gg_cateco_posfun_in_sede'])) {
                dddx('andare su COEFF e aggiornare Anno');
            }

            /** @var object{value?: float|int|string|null}|null $catecoPosfunObj */
            $catecoPosfunObj = isset($coeffTyped['gg_cateco_posfun_in_sede']) && is_object($coeffTyped['gg_cateco_posfun_in_sede']) ? $coeffTyped['gg_cateco_posfun_in_sede'] : null;
            /** @var object{value?: float|int|string|null}|null $catecoNoPosfunObj */
            $catecoNoPosfunObj = isset($coeffTyped['gg_cateco_no_posfun_in_sede']) && is_object($coeffTyped['gg_cateco_no_posfun_in_sede']) ? $coeffTyped['gg_cateco_no_posfun_in_sede'] : null;
            /** @var object{value?: float|int|string|null}|null $noCatecoObj */
            $noCatecoObj = isset($coeffTyped['gg_no_cateco_in_sede']) && is_object($coeffTyped['gg_no_cateco_in_sede']) ? $coeffTyped['gg_no_cateco_in_sede'] : null;
        } else {
            /** @var object{gg_cateco_posfun_in_sede?: object{value?: float|int|string|null}, gg_cateco_no_posfun_in_sede?: object{value?: float|int|string|null}, gg_no_cateco_in_sede?: object{value?: float|int|string|null}} $coeffObj */
            $coeffObj = $coeffTyped;
            /** @var object{value?: float|int|string|null}|null $catecoPosfunObj */
            $catecoPosfunObj = isset($coeffObj->gg_cateco_posfun_in_sede) && is_object($coeffObj->gg_cateco_posfun_in_sede) ? $coeffObj->gg_cateco_posfun_in_sede : null;
            /** @var object{value?: float|int|string|null}|null $catecoNoPosfunObj */
            $catecoNoPosfunObj = isset($coeffObj->gg_cateco_no_posfun_in_sede) && is_object($coeffObj->gg_cateco_no_posfun_in_sede) ? $coeffObj->gg_cateco_no_posfun_in_sede : null;
            /** @var object{value?: float|int|string|null}|null $noCatecoObj */
            $noCatecoObj = isset($coeffObj->gg_no_cateco_in_sede) && is_object($coeffObj->gg_no_cateco_in_sede) ? $coeffObj->gg_no_cateco_in_sede : null;
        }

        $cateco_posfun = ($catecoPosfunObj !== null && is_object($catecoPosfunObj) && isset($catecoPosfunObj->value)) ? $catecoPosfunObj->value : null;
        $cateco_no_posfun = ($catecoNoPosfunObj !== null && is_object($catecoNoPosfunObj) && isset($catecoNoPosfunObj->value)) ? $catecoNoPosfunObj->value : null;
        $no_cateco = ($noCatecoObj !== null && is_object($noCatecoObj) && isset($noCatecoObj->value)) ? $noCatecoObj->value : null;

        // $no_propro_no_posfun=$coeff['gg_no_propro_no_posfun_in_sede']->value;
        // $no_propro_no_posfun=$no_propro_posfun; // solo in questo caso

        // $where is already validated as non-empty-string above
        $whereTyped = $where;
        /** @var non-empty-string $tableTyped */
        $tableTyped = $table;
        /** @var numeric-string $annoTyped */
        $annoTyped = (string) $anno;
        /** @var float|int|string $cateco_posfunTyped */
        $cateco_posfunTyped = $cateco_posfun ?? '0';
        /** @var float|int|string $cateco_no_posfunTyped */
        $cateco_no_posfunTyped = $cateco_no_posfun ?? '0';
        /** @var float|int|string $no_catecoTyped */
        $no_catecoTyped = $no_cateco ?? '0';
        $sql =
            'update '
            .$table_aspettativeTyped
            .' as A set propro_val=
		(select propro from '
            .$tableTyped
            .' as B
		where A.ente=B.ente and A.matr=B.matr
		 and '
            .str_replace($tableTyped.'.', 'B.', $whereTyped)
            .' limit 1)';
        $res = $connTyped->statement($sql);
        $sql =
            'update '
            .$table_aspettativeTyped
            .' as A set posfun_val=
		(select posfun from '
            .$tableTyped
            .' as B
		where A.ente=B.ente and A.matr=B.matr
		 and '
            .str_replace($tableTyped.'.', 'B.', $whereTyped)
            .' limit 1)';
        $connTyped->statement($sql);

        $sql =
            'update '
            .$table_aspettativeTyped
            .' set categoria_eco=(select categoria from categoria_propro where find_in_set(propro,lista_propro) and anno='
            .$annoTyped
            .')';
        $connTyped->statement($sql);
        $sql =
            'update '
            .$table_aspettativeTyped
            .' set categoria_eco_val=(select categoria from categoria_propro where find_in_set(propro_val,lista_propro) and anno='
            .$annoTyped
            .')';
        $connTyped->statement($sql);

        $sql =
            'update '
            .$table_aspettativeTyped
            .' set peso=if(categoria_eco=categoria_eco_val,if(substr(posfun,-1)=substr(posfun_val,-1),'
            .(string) $cateco_posfunTyped
            .','
            .(string) $cateco_no_posfunTyped
            .')
	,'
            .(string) $no_catecoTyped
            .')';
        $connTyped->statement($sql);
        $sql = 'update '.$table_aspettativeTyped.' set gg_pond=(gg*peso) ';
        $connTyped->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAspettativeCatEcoPondFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $table_aspettative = $params['table_aspettative'] ?? null;
        if (! is_string($table_aspettative) || $table_aspettative === '') {
            throw new \Exception('table_aspettative is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $coeff = $params['coeff'] ?? null;
        if (! is_array($coeff) && ! is_object($coeff)) {
            throw new \Exception('coeff is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        /** @var non-empty-string $table_aspettativeTyped */
        $table_aspettativeTyped = $table_aspettative;
        /** @var Connection $connTyped */
        $connTyped = $conn;
        $sql = 'drop table if exists '.$table_aspettativeTyped.';';
        $res = $connTyped->statement($sql);
        $sql = 'create table '.$table_aspettativeTyped.' (
		select distinct B.ente,B.matr,85 as asztip,q3tipo as aszcod,q3pro as propro,q3fun as posfun,"AAA" as categoria_eco,q32kd as dal,q32ka as al
		,9999 as propro_val,9999 as posfun_val,"AAA" as categoria_eco_val,9999999999 as gg,999.99 as peso,9999999999.99 as gg_pond
		from generale.qua03f as B where B.q3tipo=121 and q3ann=""  )';
        $res = $connTyped->statement($sql);

        $parz = $params;
        $parz['table'] = $table_aspettativeTyped;
        $diff_sql = self::date_diff_sql('dal', 'al', $parz);
        /** @var string $diff_sqlTyped */
        $diff_sqlTyped = $diff_sql;
        $diff_sqlTyped = str_replace('COALESCE(sum(greatest(', '', $diff_sqlTyped);
        $diff_sqlTyped = str_replace(',dal)+1,0)),0)', ',dal)+1', $diff_sqlTyped);
        $diff_sqlTyped = str_replace(',dal))+1,0)),0)', ',dal))+1', $diff_sqlTyped);

        $sql = 'update '.$table_aspettativeTyped.' set gg=greatest('.$diff_sqlTyped.',0)';
        echo '<pre>'.$sql.'</pre>';
        $res = $connTyped->statement($sql);
        // ------------------------------------------------------------
        /** @var array<string, mixed>|object $coeffTyped */
        $coeffTyped = $coeff;
        /** @var object{value?: float|int|string|null}|null $catecoPosfunObj2 */
        $catecoPosfunObj2 = is_array($coeffTyped) ? ($coeffTyped['gg_cateco_posfun_in_sede'] ?? null) : ($coeffTyped->{'gg_cateco_posfun_in_sede'} ?? null);
        /** @var object{value?: float|int|string|null}|null $catecoNoPosfunObj2 */
        $catecoNoPosfunObj2 = is_array($coeffTyped) ? ($coeffTyped['gg_cateco_no_posfun_in_sede'] ?? null) : ($coeffTyped->{'gg_cateco_no_posfun_in_sede'} ?? null);
        /** @var object{value?: float|int|string|null}|null $noCatecoObj2 */
        $noCatecoObj2 = is_array($coeffTyped) ? ($coeffTyped['gg_no_cateco_in_sede'] ?? null) : ($coeffTyped->{'gg_no_cateco_in_sede'} ?? null);

        $cateco_posfun = $catecoPosfunObj2->value ?? null;
        $cateco_no_posfun = $catecoNoPosfunObj2->value ?? null;
        $no_cateco = $noCatecoObj2->value ?? null;

        $sql =
            'update '
            .$table_aspettative
            .' as A set propro_val=
		(select propro from '
            .$table
            .' as B
		where A.ente=B.ente and A.matr=B.matr
		 and '
            .str_replace($table.'.', 'B.', (string) $where)
            .' limit 1)';
        $res = $conn->statement($sql);
        $sql =
            'update '
            .$table_aspettative
            .' as A set posfun_val=
		(select posfun from '
            .$table
            .' as B
		where A.ente=B.ente and A.matr=B.matr
		 and '
            .str_replace($table.'.', 'B.', (string) $where)
            .' limit 1)';
        $conn->statement($sql);

        $sql =
            'update '
            .$table_aspettative
            .' set categoria_eco=(select categoria from categoria_propro where find_in_set(propro,lista_propro) and anno='
            .$anno
            .')';
        $conn->statement($sql);
        $sql =
            'update '
            .$table_aspettative
            .' set categoria_eco_val=(select categoria from categoria_propro where find_in_set(propro_val,lista_propro) and anno='
            .$anno
            .')';
        $conn->statement($sql);

        $sql =
            'update '
            .$table_aspettative
            .' set peso=if(categoria_eco=categoria_eco_val,if(substr(posfun,-1)=substr(posfun_val,-1),'
            .$cateco_posfun
            .','
            .$cateco_no_posfun
            .')
	,'
            .$no_cateco
            .')';
        $conn->statement($sql);
        $sql = 'update '.$table_aspettative.' set gg_pond=(gg*peso) ';
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGCatEcoNoPosfunInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_cateco_no_posfun_in_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_cateco_no_posfun_in_sede');
            });
        }

        $sql =
            'update '
            .$table
            .' set gg_cateco_no_posfun_in_sede=gg_cateco_in_sede - gg_cateco_posfun_in_sede where '
            .$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGCatEcoNoPosfunFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! Schema::connection($conn->getName())->hasColumn($table, 'gg_cateco_no_posfun_fuori_sede')) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table): void {
                $table->integer('gg_cateco_no_posfun_fuori_sede');
            });
        }

        $sql =
            'update '
            .$table
            .' set gg_cateco_no_posfun_fuori_sede=gg_cateco_fuori_sede - gg_cateco_posfun_fuori_sede where '
            .$where;
        $conn->statement($sql);
    }

    // in anag.old c'e' una altra funzione capire quale dellle 2
    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAspettativePondInSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $sql = 'update schede set gg_aspettative_pond_in_sede = (
		select COALESCE(sum(gg_pond),0) from aspettative_progressione_in_sede
		where schede.ente =aspettative_progressione_in_sede.ente
		and schede.matr =aspettative_progressione_in_sede.matr
		) where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateGGAspettativePondFuoriSede(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $sql = 'update schede set gg_aspettative_pond_fuori_sede = (
		select COALESCE(sum(gg_pond),0) from aspettative_progressione_fuori_sede
		where schede.ente =aspettative_progressione_fuori_sede.ente
		and schede.matr =aspettative_progressione_fuori_sede.matr
		) where '.$where;
        echo '['.__LINE__.']['.__FILE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdatePosfunval(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $sql = 'update '.$table.' set posfunval=substr(posfun,-1) where '.$where;
        $conn->statement($sql);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function massUpdateCategoriaEcoval(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();

        $where = $params['where'] ?? null;
        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $sql =
            'update '.$table.' as A set categoria_ecoval=(
		select categoria from categoria_propro as B where find_in_set(A.propro,B.lista_propro)
		and anno='.$anno.'
		) where '.str_replace($table.'.', 'A.', (string) $where);
        $conn->statement($sql);
    }

    /**
     * @param array{
     *     where: string,
     *     coeff: iterable<int, array{name: string, value: int|float}|object{name?: string|null, value?: int|float|null}>
     * } $params
     *
     * @throws \Exception
     */
    public static function massUpdateGGTotPond(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();
        $where = $params['where'] ?? null;

        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $coeffData = $params['coeff'] ?? null;

        if (! is_iterable($coeffData)) {
            throw new \Exception('coeff is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $expressions = [];

        foreach ($coeffData as $row) {
            $name = null;
            $value = null;

            if (is_array($row)) {
                $name = isset($row['name']) ? (string) $row['name'] : null;
                $value = isset($row['value']) && is_numeric($row['value']) ? (float) $row['value'] : null;
            } elseif (is_object($row)) {
                $rowName = $row->name ?? null;
                if (is_string($rowName) && $rowName !== '') {
                    $name = $rowName;
                }

                $rowValue = $row->value ?? null;
                if (is_numeric($rowValue)) {
                    $value = (float) $rowValue;
                }
            }

            if ($name === null || $value === null || $value === 0.0) {
                continue;
            }

            $expressions[] = sprintf('(%s * %s)', $name, $value);
        }

        if ($expressions === []) {
            throw new \Exception('coeff is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $sql =
            'update '
            .$table
            .' set gg_tot_pond=('
            .\chr(13)
            .implode(\chr(13).'+', $expressions)
            .\chr(13)
            .') '
            .\chr(13)
            .' where '
            .$where;
        $conn->statement($sql);
    }

    /**
     * @param  array{where: string, anno: int, n_perf_ind: int}  $params
     *
     * @throws \Exception
     */
    public static function massUpdateUltimi3AnniPerfInd(array $params): void
    {
        $instance = self::getConcreteInstance();
        $table = $instance->getTable();
        $conn = $instance->getConnection();
        $where = $params['where'] ?? null;

        if (! is_string($where) || $where === '') {
            throw new \Exception('where is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        echo '<h3>'.__FUNCTION__.'</h3>';

        $year = isset($params['anno']) ? (int) $params['anno'] : null;
        if ($year === null) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $performanceCount = isset($params['n_perf_ind']) ? (int) $params['n_perf_ind'] : null;
        if ($performanceCount === null) {
            throw new \Exception('n_perf_ind is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $connectionName = $conn->getName();

        for ($i = 1; $i <= $performanceCount; $i++) {
            $targetYear = $year - $i;
            $fieldname = 'perf_ind_'.$targetYear;

            if (! Schema::connection($connectionName)->hasColumn($table, $fieldname)) {
                Schema::connection($connectionName)->table(
                    $table,
                    static function (Blueprint $blueprint) use ($fieldname): void {
                        $blueprint->decimal($fieldname, 10, 3);
                    }
                );
            }

            $sql = sprintf(
                'update %1$s as A set perf_ind_%2$d =
				(select COALESCE(sum(B.totale_punteggio * (datediff(B.al,B.dal)+1))/( sum(datediff(B.al,B.dal)+1)  ),0)
				from produ40.performance_individuale as B
				where B.anno=%2$d and (B.ha_diritto>0 or B.posfun>=100)
				and B.matr=A.matr
				) where A.ha_diritto>0 and A.anno=%3$d',
                $table,
                $targetYear,
                $year
            );
            $conn->statement($sql);
            echo '<pre>'.htmlspecialchars($sql).'</pre>';
        }
    }
}

// end class
