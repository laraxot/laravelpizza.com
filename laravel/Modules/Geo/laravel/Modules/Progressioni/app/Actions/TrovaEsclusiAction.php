<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

// use Illuminate\Support\Arr;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Models\Scheda as Progressioni;

// -------- services --------
// use Modules\Xot\Services\ArrayService;

class TrovaEsclusiAction
{
    public int $year;

    public function execute(int $year): string
    {
        // $data = ($this->rows->get()->toArray());

        if ($year === 0) {
            return '<h3>Selezionare un anno</h3>';
        }
        $this->year = $year;

        $criteri_esclusione = CriteriEsclusione::where('anno', $year)
            ->get()
            ->pluck('value', 'name')
            ->all();
        // dddx($criteri_esclusione);
        $criteri_option = CriteriOption::where('anno', $year)
            ->get()
            ->pluck('value', 'name')
            ->all();

        $schede = Progressioni::where('anno', $year)->get();
        foreach ($schede as $scheda) {
            /** @var array<int|string, mixed> $criteri_esclusione */
            /** @var array<int|string, mixed> $criteri_option */
            $parz = [
                'scheda' => $scheda,
                'criteri_esclusione' => $criteri_esclusione,
                'criteri_option' => $criteri_option,
            ];
            $result = $this->criteriScheda($parz, $year);
            $scheda->motivo = $result['motivo'];
            $scheda->ha_diritto = $result['ha_diritto'];
            $scheda->save();
        }

        return '<h3>+Fatto</h3>';
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array{ha_diritto: int, motivo: string}
     */
    public function checkScheda(array $params, int $year): array
    {
        if (! isset($params['criteri_esclusione'])) {
            $params['criteri_esclusione'] = CriteriEsclusione::where('anno', $year)
                ->get()
                ->pluck('value', 'name')
                ->all();
        }

        if (! isset($params['criteri_option'])) {
            $params['criteri_option'] = CriteriOption::where('anno', $year)
                ->get()
                ->pluck('value', 'name')
                ->all();
        }

        /** @var Scheda|\Modules\Progressioni\Models\Progressioni $scheda */
        $scheda = $params['scheda'];
        /** @var array{scheda: Scheda|\Modules\Progressioni\Models\Progressioni, criteri_esclusione: array<string, mixed>, criteri_option: array<string, mixed>} $typedParams */
        $typedParams = $params;
        $result = $this->criteriScheda($typedParams, $year);
        $scheda->motivo = $result['motivo'];
        $scheda->ha_diritto = $result['ha_diritto'];
        $scheda->save();

        return $result;
    }

    /**
     * @param  array{scheda: Scheda|\Modules\Progressioni\Models\Progressioni, criteri_esclusione: array<int|string, mixed>, criteri_option: array<int|string, mixed>}  $params
     * @return array{ha_diritto: int, motivo: string}
     */
    public function criteriScheda(array $params, int $year): array
    {
        /** @var Scheda|\Modules\Progressioni\Models\Progressioni $scheda */
        $scheda = $params['scheda'];
        /** @var array<int|string, mixed> $criteri_esclusione */
        $criteri_esclusione = $params['criteri_esclusione'];
        /** @var array<int|string, mixed> $criteri_option */
        $criteri_option = $params['criteri_option'];

        $motivo = '';
        $ha_diritto = 1;

        foreach ($criteri_esclusione as $k => $v) {
            $func = 'check'.Str::studly((string) $k);
            $parz = $criteri_option;
            $parz[$k] = $v;
            $parz['date_max'] = $year * 10000 + 1231;
            $parz['date_min'] = $year * 10000 + 101;

            if (method_exists($this, $func)) {
                $msg = (string) $this->$func($parz, $scheda);
            } else {
                $msg = 'func ['.self::class.']['.$func.'] not exists ['.__LINE__.']['.__FILE__.']';
            }

            if ($msg !== '') {
                $motivo .= ($motivo === '' ? '' : ', ').(string) $msg;
                $ha_diritto = 0;
            }
        }

        return [
            'ha_diritto' => $ha_diritto,
            'motivo' => $motivo,
        ];
    }

    /** @return array<string, mixed> */
    public function criteriOptions(int $year): array
    {
        $options = CriteriOption::where('anno', $year)
            ->get()
            ->pluck('value', 'name');

        return $options->mapWithKeys(
            static fn (mixed $value, mixed $key): array => is_string($key) ? [$key => $value] : []
        )->all();
    }

    public function check(string $criterio_name, mixed $criterio_value, Scheda $scheda, int $year): string
    {
        $func = 'check'.Str::studly($criterio_name);
        $parz = $this->criteriOptions($year);
        $parz[$criterio_name] = $criterio_value;
        $parz['date_max'] = $year * 10000 + 1231;
        $parz['date_min'] = $year * 10000 + 101;

        if (! method_exists($this, $func)) {
            throw new InvalidArgumentException(sprintf('Metodo %s non disponibile', $func));
        }

        return (string) $this->$func($parz, $scheda);
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgRuolo(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($min_gg_ruolo)) {
            throw new Exception('min_gg_ruolo is not set');
        }

        if ($scheda->gg_ruolo < $min_gg_ruolo) {
            return 'no min gg_ruolo ['.(string) $scheda->gg_ruolo.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinPerfIndCountLast3Years(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($min_perf_ind_count_last_3_years)) {
            throw new Exception('min_perf_ind_count_last_3_years is not set');
        }

        if ($scheda->perf_ind_count_last_3_years < $min_perf_ind_count_last_3_years) {
            return 'no min_perf_ind_count_last_3_years ['.(string) $scheda->perf_ind_count_last_3_years.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgPosiz1InSede(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($min_gg_posiz_1_in_sede)) {
            throw new Exception('min_gg_posiz_1_in_sede is not set');
        }

        if ($scheda->gg_posiz_1_in_sede < $min_gg_posiz_1_in_sede) {
            return 'no min_gg_posiz_1_in_sede ['.(string) $scheda->gg_posiz_1_in_sede.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgCatecoPosfunNoAsz(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($min_gg_cateco_posfun_no_asz)) {
            throw new Exception('min_gg_cateco_posfun_no_asz is not set');
        }

        if ($scheda->gg_cateco_posfun_no_asz < $min_gg_cateco_posfun_no_asz) {
            return ' no min_gg_cateco_posfun_no_asz[my:'.(string) $scheda->gg_cateco_posfun_no_asz.'][min:'.(string) $min_gg_cateco_posfun_no_asz.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgCatecoPosfunInSedeNoAsz(array $parz, Scheda $scheda): string
    {
        extract($parz);
        /*
        dddx(
            [
                'gg_cateco_posfun_in_sede_no_asz' => $scheda->gg_cateco_posfun_in_sede_no_asz,
            ]
        );
        */
        if (! isset($min_gg_cateco_posfun_in_sede_no_asz)) {
            throw new Exception('min_gg_cateco_posfun_in_sede_no_asz is not set');
        }

        if ($scheda->gg_cateco_posfun_in_sede_no_asz < $min_gg_cateco_posfun_in_sede_no_asz) {
            return ' no min_gg_cateco_posfun_in_sede_no_asz [my:'.(string) $scheda->gg_cateco_posfun_in_sede_no_asz.'][min:'.(string) $min_gg_cateco_posfun_in_sede_no_asz.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgCatecoPosfunLavoratiInSede(array $parz, Scheda $_scheda): string
    {
        extract($parz);

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkPresentiIlGiorno(array $parz, Scheda $_scheda): string
    {
        extract($parz);

        return '';
    }

    // ---

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkListaPropro(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($lista_propro)) {
            throw new Exception('lista_propro is not set');
        }

        $propro = $scheda->propro;
        if (\in_array($propro, explode(',', (string) $lista_propro), true)) {
            return 'no propro';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkListaPosiz(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($lista_posiz)) {
            throw new Exception('lista_posiz is not set');
        }

        $posiz = $scheda->posiz;
        if (\in_array($posiz, explode(',', (string) $lista_posiz), true)) {
            return 'no posiz';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkListaProproPosfun(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($lista_propro_posfun)) {
            throw new Exception('lista_propro_posfun is not set');
        }

        $propro_posfun = $scheda->propro.'-'.$scheda->posfun;
        if (\in_array($propro_posfun, explode(',', (string) $lista_propro_posfun), true)) {
            return 'no propro posfun';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkDisci(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($disci)) {
            throw new Exception('disci is not set');
        }

        if (\in_array($scheda->disci1, explode(',', (string) $disci), true)) {
            return 'no disci';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkListaAszTipCodEsclusoSubito(array $parz, Scheda $scheda): string
    {
        extract($parz);

        if (! isset($lista_asz_tip_cod_escluso_subito)) {
            throw new Exception('lista_asz_tip_cod_escluso_subito is not set');
        }

        if (! isset($data_presenza_al)) {
            throw new Exception('$data_presenza_al is not set');
        }

        if (! isset($min_gg_asz_tip_cod_escluso_subito)) {
            throw new Exception('min_gg_asz_tip_cod_escluso_subito is not set');
        }

        $asz_al = (int) Carbon::parse((string) $data_presenza_al)->format('Ymd');
        $asz_dal = (int) Carbon::parse((string) $data_presenza_al)
            ->subDays((int) $min_gg_asz_tip_cod_escluso_subito)
            ->format('Ymd');

        $tmp = $scheda->asz()
            ->ofRangeDate($asz_dal, $asz_al)
            ->select('asztip', 'aszcod')
            ->distinct()
            ->get()
            ->toArray();
        $excludedItems = explode(',', (string) $lista_asz_tip_cod_escluso_subito);
        /** @var array<int, array{asztip: mixed, aszcod: mixed}> $tmp */
        $mappedItems = array_map(static fn (mixed $item): string => (string) ($item['asztip'] ?? '').'-'.(string) ($item['aszcod'] ?? ''), $tmp);
        $tmp1 = count(array_intersect($mappedItems, $excludedItems));

        if ($scheda->matr === 23698) {
            // dddx(explode(',',$lista_asz_tip_cod_escluso_subito));
            // dddx($tmp1);
        }

        if ($tmp1 > 0) {
            return 'asz_tip_cod_escluso_subito';
        }

        return '';
    }

    // ---

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgPropro(array $parz, Scheda $_scheda): string
    {
        extract($parz);

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgProproPosfun(array $parz, Scheda $_scheda): string
    {
        extract($parz);

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgAnno(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($min_gg_anno)) {
            throw new Exception('min_gg_anno is not set');
        }

        // dddx($scheda->gg_presenza_anno);
        // dddx($scheda->gg_assenza_anno);
        $eff = $scheda->gg_presenza_anno - $scheda->gg_assenza_anno;
        if ($eff < $min_gg_anno) {
            return 'no min gg_anno ['.(string) $eff.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgTempoDeterminato(array $parz, Scheda $_scheda): string
    {
        extract($parz);

        // dddx($scheda->gg_tempo_determinato);
        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMinGgEffettuati(array $parz, Scheda $_scheda): string
    {
        extract($parz);

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkNoposizList(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($noposiz_list)) {
            throw new Exception('noposiz_list is not set');
        }

        $noposiz_arr = explode(',', (string) $noposiz_list);
        if (\in_array($scheda->posiz, $noposiz_arr, false)) {
            return 'no_posiz ['.(string) $scheda->posiz.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkNoproproList(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($nopropro_list)) {
            throw new Exception('nopropro_list is not set');
        }

        $arr = explode(',', (string) $nopropro_list);
        if (\in_array($scheda->propro, $arr, false)) {
            return 'no_propro ['.(string) $scheda->propro.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkNoposfunList(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($noposfun_list)) {
            throw new Exception('noposfun_list is not set');
        }

        $arr = explode(',', (string) $noposfun_list);
        if (\in_array($scheda->posfun, $arr, false)) {
            return 'no_posfun ['.(string) $scheda->posfun.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkNodisci1List(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($nodisci1_list)) {
            throw new Exception('nodisci1_list is not set');
        }

        $arr = explode(',', (string) $nodisci1_list);
        if (\in_array($scheda->disci1, $arr, false)) {
            return 'no_disci1 ['.(string) $scheda->disci1.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkMaxGgAssenzeAnno(array $parz, Scheda $scheda): string
    {
        extract($parz);
        if (! isset($max_gg_assenze_anno)) {
            throw new Exception('max_gg_assenze_anno is not set');
        }

        if ($scheda->gg_assenza_anno > $max_gg_assenze_anno) {
            return 'max gg assenze anno ['.(string) $scheda->gg_assenza_anno.']>['.(string) $max_gg_assenze_anno.']';
        }

        return '';
    }

    /**
 * @param array<string, mixed> $parz
 * @return string
 */
    public function checkDateMinAssunz(array $parz, Scheda $scheda): string
    {
        extract($parz);

        if (! isset($date_min_assunz)) {
            throw new Exception('date_min_assunz is not set');
        }

        $last_data_assunz = $scheda->last_data_assunz;
        /*
        if (! is_object($last_data_assunz)) {
            $last_data_assunz = Carbon::parse($last_data_assunz);
        }
        if (! is_object($date_min_assunz)) {
            $date_min_assunz = Carbon::parse($date_min_assunz);
        }
        */
        // dddx($last_data_assunz);
        if ($last_data_assunz > $date_min_assunz) {
            return 'date min assunz ['.(string) $scheda->last_data_assunz.']>['.(string) $date_min_assunz.'][2]';
        }

        return '';
    }
}
