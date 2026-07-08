<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Traits;

use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\StabiDirigente;
use Schema;

/**
 * Modules\Progressioni\Models\Traits\ProgressioniFunctionTrait.
 */
trait ProgressioniFunctionTrait
{
    // ------------------ functions -----------------

    public function getDateMax(): int
    {
        return $this->anno * 10000 + 1231;
    }

    /**
     * @return int|array<int, string>|string|Carbon|null
     */
    public function getOption(string $name): int|array|string|Carbon|null
    {
        $option = CriteriOption::where("anno", $this->anno)
            ->where("name", $name)
            ->first();

        if ($option === null) {
            return null;
        }

        $type = $option->getAttribute("type");
        $value = $option->getAttribute("value");

        if ($type === "list") {
            return is_string($value) ? explode(",", $value) : [];
        }

        if ($type === "int") {
            return is_numeric($value) ? (int) (string) $value : null;
        }

        if ($type === "date") {
            if (! is_string($value) || $value === "") {
                return null;
            }

            try {
                return Carbon::parse($value);
            } catch (Exception) {
                return null;
            }
        }

        return is_string($value) ? $value : null;
    }

    public function msg(string $name): ?string
    {
        $msg = $this->messages()->firstWhere('type', $name);
        if (! \is_object($msg)) {
            $this->messages()->create(['type' => $name, 'txt' => $name]);

            return nl2br($name);
        }

        return nl2br((string) (isset($msg->txt) ? $msg->txt : ''));
    }

    /**
     * Get list of tipo-codice combinations from assenze.
     *
     * @return array<int, string> Array of tipo-codice pairs
     */
    public function getListaTipoCodiceAspettative(): array
    {
        $assenze = isset($this->assenze) ? $this->assenze : [];

        // Type guard for array structure
        if (! is_array($assenze)) {
            return [];
        }

        $lista_aspettative = collect($assenze)
            ->map(static function ($item): string {
                // Type guard for array item structure
                if (! is_array($item)) {
                    return '';
                }

                $tipo = is_string($item['tipo'] ?? null) || is_numeric($item['tipo'] ?? null)
                    ? (string) ($item['tipo'])
                    : '';
                $codice = is_string($item['codice'] ?? null) || is_numeric($item['codice'] ?? null)
                    ? (string) ($item['codice'])
                    : '';

                return $tipo.'-'.$codice;
            })
            ->filter(static fn (string $item): bool => $item !== '')
            ->values()
            ->all();

        /** @var array<int, string> $result */
        $result = $lista_aspettative;

        return $result;
    }

    /** @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkListaPropro(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];
        extract($params);
        $propro = $this->propro;
        if (! isset($lista_propro)) {
            throw new Exception('lista_propro is not in params');
        }

        if (\in_array($propro, explode(',', (string) $lista_propro), true)) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no propro';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /*
    public function criteriOptionsArr(?string $str = null): array|null|string
    {
        $res=once(function() use ($str){
            if ($str === null) {
                return $this->criteriOptions->pluck('value', 'name')
                    ->all();
            }

            $res = $this->criteriOptions->firstWhere('name', $str);
            if ($res === null) {
                return null;
            }

            if (isset($res->type) && $res->type === 'date' && isset($res->value) && $res->value !== null) {
                // Property Modules\Progressioni\Models\CriteriOption::$value (string|null) does not accept Carbon\Carbon.
                $res->value = Carbon::parse($res->value)->toDateString();
            }
            return $res;
        });
        $res= isset($res->value) ? (is_array($res->value) ? $res->value : null) : null;
        return $res;
    }
    */
    /**
     * @return array<int, string>
     */
    // @phpstan-ignore-next-line
    public function criteriEsclusioneFields(): array
    {
        $result = $this->criteriEsclusione
            ->filter(
                static fn ($item): bool => Str::startsWith((string) $item->name, 'min_') && $item->value !== 0 && $item->value !== ''
            )
            ->map(
                static function ($item) {
                    $item->name = Str::after((string) $item->name, 'min_');

                    return $item;
                }
            )
            ->pluck('name')
            ->filter(static fn (mixed $name): bool => is_string($name))
            ->values()
            ->all();

        /** @var array<int, string> $result */
        return $result;
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkListaPosiz(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);
        if (! isset($lista_posiz)) {
            throw new Exception('lista_propro is not set');
        }

        $posiz = $this->posiz;
        if (\in_array($posiz, explode(',', (string) $lista_posiz), true)) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no posiz';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkMinGgPosiz1InSede(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($min_gg_posiz_1_in_sede)) {
            throw new Exception('min_gg_posiz_1_in_sede is not set');
        }

        if ($this->gg_posiz_1_in_sede < $min_gg_posiz_1_in_sede) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no min_gg_posiz_1_in_sede';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkMinGgCatecoPosfunNoAsz(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($min_gg_cateco_posfun_no_asz)) {
            throw new Exception('min_gg_cateco_posfun_no_asz is not set');
        }

        if ($this->gg_cateco_posfun_no_asz < $min_gg_cateco_posfun_no_asz) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no min_gg_posiz_1_in_sede';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkMinGgPropro(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($min_gg_propro)) {
            throw new Exception('min_gg_propro is not set');
        }

        if ($this->gg_cateco_fuori_sede + $this->gg_cateco_in_sede < $min_gg_propro) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no min gg cateco';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkMinGgProproPosfun(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($min_gg_propro_posfun)) {
            throw new Exception('min_gg_propro_posfun is not set');
        }

        $my_gg_propro_posfun = $this->gg_cateco_posfun_fuori_sede + $this->gg_cateco_posfun_in_sede;
        if ($this->matr === 23990) { // debug
            // dddx($my_gg_propro_posfun.'  '.$min_gg_propro_posfun);
        }

        if ($my_gg_propro_posfun < $min_gg_propro_posfun) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no min gg cateco posfun [my:'.(string) $my_gg_propro_posfun.'][min:'.(string) $min_gg_propro_posfun.']';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkMinGgAnno(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($min_gg_anno)) {
            throw new Exception('min_gg_anno is not set');
        }

        if ($this->gg_presenza_anno - $this->gg_assenza_anno < $min_gg_anno) {
            // * --  ci vuole un controllo se "vuoto"
            $ha_diritto = 0;
            $motivo_arr[] = 'no min gg anno pres['.$this->gg_presenza_anno.'] asz ['.$this->gg_assenza_anno.']';
            // */
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkMinGgCatecoPosfunLavoratiInSede(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params); // da fare

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>} */
    // @phpstan-ignore-next-line
    public function checkListaProproPosfun(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];
        extract($params);

        if (! isset($lista_propro_posfun)) {
            throw new Exception('lista_propro_posfun is not set');
        }

        $propro_posfun = $this->propro.'-'.$this->posfun;
        if (\in_array($propro_posfun, explode(',', (string) $lista_propro_posfun), true)) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no propro posfun';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     * @return array{int, array<int, string>} */
    // @phpstan-ignore-next-line
    public function checkDisci(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($disci)) {
            throw new Exception('disci is not set');
        }

        if (\in_array($this->disci1, explode(',', (string) $disci), true)) {
            $ha_diritto = 0;
            $motivo_arr[] = 'no disci';
        }

        return [$ha_diritto, $motivo_arr];
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return array{int, array<int, string>}
     */
    // @phpstan-ignore-next-line
    public function checkListaAszTipCodEsclusoSubito(array $params): array
    {
        $ha_diritto = 1;
        $motivo_arr = [];

        extract($params);

        if (! isset($data_presenza_al)) {
            throw new Exception('data_presenza_al is not set');
        }

        if (! isset($lista_asz_tip_cod_escluso_subito)) {
            throw new Exception('lista_asz_tip_cod_escluso_subito is not set');
        }

        // Type guard for date parsing
        if (! is_string($data_presenza_al)) {
            throw new Exception('data_presenza_al must be string');
        }

        try {
            $asz_al = (int) Carbon::parse($data_presenza_al)->format('Ymd');
            $asz_dal = (int) Carbon::parse($data_presenza_al)->subDays(730)->format('Ymd');
        } catch (Exception $e) {
            throw new Exception('Invalid date format for data_presenza_al: '.$e->getMessage());
        }

        /** @var array<int, array<string, mixed>> $tmp */
        /** @phpstan-ignore-next-line */
        $tmp = $this->asz()->ofRangeDate($asz_dal, $asz_al)->select('asztip', 'aszcod')->distinct()->get()->toArray();
        /** @var Collection<int, string> $mappedItems */
        $mappedItems = collect($tmp)->map(static function (mixed $item): string {
            if (! is_array($item)) {
                return '';
            }

            $asztip = is_string($item['asztip'] ?? null) || is_numeric($item['asztip'] ?? null)
                ? (string) ($item['asztip'])
                : '';
            $aszcod = is_string($item['aszcod'] ?? null) || is_numeric($item['aszcod'] ?? null)
                ? (string) ($item['aszcod'])
                : '';

            return $asztip.'-'.$aszcod;
        });

        $explodedList = array_filter(explode(',', (string) $lista_asz_tip_cod_escluso_subito));
        $tmp1 = $mappedItems->intersect($explodedList)->count();

        if ($this->matr === 23698) {
            // dddx(explode(',',$lista_asz_tip_cod_escluso_subito));
            // dddx($tmp1);
        }

        if ($tmp1 > 0) {
            $ha_diritto = 0;
            $motivo_arr[] = 'asz_tip_cod_escluso_subito';
        }

        return [$ha_diritto, $motivo_arr];
    }

    public function perfInd(int $anno): ?float
    {
        $table = $this->getTable();
        $conn = $this->getConnection();
        $fieldname = 'perf_ind_'.$anno;
        if (! Schema::connection($conn->getName())->hasColumn($table, $fieldname)) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $table) use ($fieldname): void {
                $table->decimal($fieldname, 10, 3);
            });
        }

        /*
         * ->where('totale_punteggio', '>', 0) mi serve per escludere le righe non valutate.
         */
        try {
            $rows = $this->performanceIndividuale()
                ->where('anno', $anno)
            // ->where('totale_punteggio', '>', 0)
                ->get();
        } catch (Error $e) {
            return 0.0;
        }

        $tbl = 'performance_individuale';
        $sql = '( COALESCE(sum('.$tbl.'.totale_punteggio * (datediff('.$tbl.'.al,'.$tbl.'.dal)+1))/( sum(datediff('.$tbl.'.al,'.$tbl.'.dal)+1)  ),0) ) as perf_ind';
        // $sql1=(B.ha_diritto>0 or B.posfun>=100)
        $perf_ind = $this->performanceIndividuale()->selectRaw($sql)
            ->where('anno', $anno)
            ->whereRaw('( '.$tbl.'.ha_diritto>0 or '.$tbl.'.posfun>=100)')
            // ->where('totale_punteggio', '>', 0)

            ->first();

        if ($perf_ind == null) {
            return null;
        }

        $value = 0.0;
        if (is_object($perf_ind) && isset($perf_ind->perf_ind)) {
            $perfIndValue = $perf_ind->perf_ind;
            $value = is_numeric($perfIndValue) ? (float) $perfIndValue : 0.0;
        }

        return $value;
    }

    public function valutatoreId(): ?int
    {
        $where = [
            'stabi' => $this->stabi,
            'repar' => $this->repar,
            'anno' => $this->anno,
        ];

        $where1 = [
            'stabi' => $this->stabi,
            'repar' => 0,
            'anno' => $this->anno,
        ];

        StabiDirigente::where('anno', $this->anno)->where('valutatore_id', 0)->update(['valutatore_id' => null]);

        $stabi_repar = StabiDirigente::where($where)->first();
        if (! \is_object($stabi_repar)) {
            return null;
        }

        if ($stabi_repar->valutatore_id !== null) {
            return $stabi_repar->valutatore_id;
        }

        $stabi_0 = StabiDirigente::where($where1)->first();
        if (! \is_object($stabi_0)) {
            return null;
        }

        return $stabi_0->valutatore_id;
    }

    /*
    public function isPo(): bool
    {
        return $this->posfun >= 100;
    }

    public function isRegionale(): bool
    {
        return $this->disci1 === 203;
    }
    */
    public function listaCodiciAspettative(): string // shortcut
    {$assenze = $this->assenze ?? null;
        if ($assenze === null || ! method_exists($assenze, 'map')) {
            return '';
        }

        return $assenze->map(static function ($item): string {
            $tipo = isset($item->tipo) ? (string) $item->tipo : '';
            $codice = isset($item->codice) ? (string) $item->codice : '';

            return $tipo.'-'.$codice;
        })->implode(',');
    }

    public function canSendEmail(): bool
    {
        return (bool) $this->ha_diritto;
    }
}
