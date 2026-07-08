<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Modules\Ptv\Models\BaseScheda;
use Modules\Sigma\Datas\GgFilterData;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Traits\Extras\FunctionExtra;
use Modules\Sigma\Models\Traits\Extras\MassExtra;

/**
 * SchedaHelper - Aggregatore di TUTTI i metodi Helper per calcoli Scheda.
 *
 * Responsabilità: Calcoli puri senza side effects (delegation cascade).
 * Include FunctionExtra (gg*Tot, hh*Tot) + MassExtra + helper inline.
 * Tutti i metodi sono testabili isolatamente e riusabili.
 *
 * @see FunctionExtra
 * @see MassExtra
 * @see \Modules\Sigma\docs\refactoring\function-extra-is-helper-analysis.md
 */
trait SchedaHelper
{
    // ⚡ DELEGATION CASCADE: Helper calculations
    use FunctionExtra; // gg*Tot, hh*Tot (6 metodi pesanti DB)
    use MassExtra; // Massa calculations

    // Helper inline (34 metodi) seguono sotto
    protected function getGgAnno(): ?int
    {
        if ($this->gg_presenza_anno === null || $this->gg_assenza_anno === null) {
            return null;
        }

        $ggPresenza = is_numeric($this->gg_presenza_anno) ? (int) $this->gg_presenza_anno : 0;
        $ggAssenza = is_numeric($this->gg_assenza_anno) ? (int) $this->gg_assenza_anno : 0;

        return $ggPresenza - $ggAssenza;
    }

    protected function getGgFuoriSede(): ?int
    {
        // Guard: anagrafica deve esistere
        if (! \is_object($this->anag)) {
            return null;
        }

        // Setup parametri periodo
        $parz = [
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        // Calcolo puro delegato ad anagrafica
        $result = $this->anag->ggFuoriSedeTot($parz);

        /** @var int|null */
        return $result;
    }

    protected function getGgPresenzaAnno(): ?int
    {
        // Guard: data presenza al deve esistere
        $data_presenza_al = $this->criteriOptionsArr('data_presenza_al');
        if ($data_presenza_al == null || ! ($data_presenza_al instanceof Carbon)) {
            return null;
        }

        // Guard: anagrafica deve esistere
        if ($this->anag === null) {
            return null;
        }

        // Setup periodo annuale
        /** @var Carbon $data_presenza_alTyped */
        $data_presenza_alTyped = $data_presenza_al;
        $anno = $data_presenza_alTyped->year;
        $parz = [
            'date_min' => Date::createFromDate($anno, 1, 1)->startOfDay(),
            'date_max' => Date::createFromDate($anno, 12, 31)->endOfDay(),
        ];

        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        $result = $this->anag->ggInSedeTot($data);

        /** @var int|null */
        return $result ?? 0;
    }

    protected function getGgAssenzaAnno(): ?int
    {
        // Guard: matricola deve esistere
        if ($this->matr == null) {
            return null;
        }

        // Guard: data qualifica deve esistere
        if ($this->qua2kd == null) {
            return null;
        }

        // Setup periodo annuale
        $anno = $this->anno;
        $parz = [
            'date_min' => Date::createFromDate($anno, 1, 1)->startOfDay(),
            'date_max' => Date::createFromDate($anno, 12, 31)->endOfDay(),
        ];

        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        // Guard: anagrafica deve esistere
        if ($this->anag === null) {
            return 0;
        }

        $result = $this->anag->ggAssenzaInSedeTot($data);

        /** @var int|null */
        return $result;
    }

    protected function getPtime(): ?float
    {
        // Guard: periodo deve esistere
        if ($this->dal === null) {
            return null;
        }

        $dal = (int) $this->dal;
        $al = (int) ($this->al ?? 0);

        // Query periodi part-time con percentuali
        $qua00f = $this->qua00f()
            ->getQuery()
            ->selectRaw(
                <<<'SQL'
                if(oree=0,36,oree) as oree,
                if(oret=0,36,oret) as oret,
                if(oree=0,36,oree)/if(oret=0,36,oret) as perc,
                qua2kd,
                if(qua2kd > ?, qua2kd, ?) as dal,
                qua2ka,
                if(qua2ka > ? or qua2ka = 0, ?, qua2ka) as al,
                greatest(datediff(
                    if(qua2ka > ? or qua2ka = 0, ?, qua2ka),
                    if(qua2kd > ?, qua2kd, ?)
                ) + 1, 0) as dur
                SQL,
                [$dal, $dal, $al, $al, $al, $al, $dal, $dal]
            )
            ->ofRangeDate($dal, $al)
            ->get();

        // Calcolo somma ponderata
        $gg_tot = 0;
        $pond = 0;
        /** @var Qua00f $v */
        foreach ($qua00f as $v) {
            // Proprietà dinamiche da selectRaw - accesso sicuro via getAttribute
            $percValue = $v->getAttribute('perc');
            $durValue = $v->getAttribute('dur');
            $perc = is_numeric($percValue) ? (float) $percValue : 0.0;
            $dur = is_numeric($durValue) ? (float) $durValue : 0.0;
            $pond += $perc * $dur;
            $gg_tot += (int) $dur;
        }

        // Calcolo giorni part-time verticale (da escludere)
        $parz = [
            'date_min' => Date::createFromFormat('Ymd', (string) $this->dal),
            'date_max' => Date::createFromFormat('Ymd', (string) $this->al),
            'lista_tipo_codice' => '505-97,', // Part-time verticale
        ];
        $data = GgFilterData::from($parz);
        $gg_vert = $this->ggAssenzaInSedeTot($data);

        // Guard: divisione per zero
        if (($gg_tot - $gg_vert) == 0) {
            return null;
        }

        // Calcolo coefficiente
        return $pond / ($gg_tot - $gg_vert);
    }

    protected function getGgInSede(): ?int
    {
        // Guard: matricola deve esistere
        if ($this->matr == null) {
            return null;
        }

        // Guard: data qualifica deve esistere
        if ($this->qua2kd == null) {
            return null;
        }

        // Setup parametri periodo
        $parz = [
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        if ($this->anag === null) {
            return 0;
        }

        $result = $this->anag->ggInSedeTot($data);

        /** @var int|null */
        return $result ?? 0;
    }

    protected function getGgAsz(): ?int
    {
        // Guard: dati base devono esistere
        if ($this->matr == null || $this->qua2kd == null || $this->propro == null) {
            return null;
        }

        return $this->gg_asz_fuori_sede ?? 0;
    }

    protected function getHhAsz(): ?float
    {
        // Guard: dati base devono esistere
        if ($this->matr == null || $this->qua2kd == null || $this->propro == null) {
            return null;
        }

        $in_sede = $this->hh_asz_in_sede ?? 0.0;
        $fuori_sede = $this->hh_asz_fuori_sede ?? 0.0;

        return $in_sede + $fuori_sede;
    }

    protected function getTotalePond(): float
    {
        // Guard: periodo deve esistere
        if ($this->dal == null) {
            return 0.0;
        }

        // SIDE EFFECT: Aggiorna gg per tutte le schede anno+matr
        // Necessario per consistenza calcolo ponderato
        $sql =
            'update schede set gg=datediff(al,dal)+1 where anno="'.$this->anno.'" and matr="'.$this->matr.'"';
        $this->getConnection()->statement($sql);

        // Recupera tutte le schede valide (totale > 0)
        $rows = self::where('matr', $this->matr)
            ->where('anno', $this->anno)
            ->where('totale', '>', 0)
            ->get();

        // Calcolo somme ponderate
        $somma_totale_per_gg = 0.0;
        $somma_gg = 0;

        foreach ($rows as $row) {
            /** @var BaseScheda $row */
            $totale = isset($row->totale) && is_numeric($row->totale) ? (float) $row->totale : 0.0;
            $gg = isset($row->gg) && is_numeric($row->gg) ? (int) $row->gg : 0;
            $somma_totale_per_gg += $totale * (float) $gg;
            $somma_gg += $gg;
        }

        // Guard: divisione per zero
        if ($somma_gg === 0) {
            return 0.0;
        }

        // Calcolo punteggio ponderato
        return $somma_totale_per_gg / $somma_gg;
    }

    protected function getGgIntegParamsAsz(): ?float
    {
        // Guard: integParams deve avere almeno un record
        $integParams = $this->integParams;
        if ($integParams === null || $integParams->isEmpty()) {
            return null;
        }
        /** @var Integparam $last */
        $last = $integParams->last();
        if ($last === null) {
            return null;
        }
        $dal = $last->anv2kd;
        if ($dal === null) {
            return null;
        }

        // Setup lista tipologie assenza (aspettative)
        $lista_aspettative = $this->getListaTipoCodiceAspettative();
        // getListaTipoCodiceAspettative() restituisce sempre array
        $lista_aspettative_str = implode(',', $lista_aspettative);

        // Setup parametri query
        $parz = [
            'lista_tipo_codice' => $lista_aspettative_str,
            'date_min' => $dal,
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        return $this->anag !== null ? $this->anag->ggAssenzaInSedeTot($data) : null;
    }

    protected function getGgEsperienzaNoAsz(): ?int
    {
        // Preferenza: usa gg_integ_params se disponibile
        $gg_integ_params = $this->gg_integ_params ?? null;
        if ($gg_integ_params !== null) {
            $gg_totali = is_numeric($gg_integ_params) ? (int) $gg_integ_params : 0;
            $gg_assenza_val = $this->gg_integ_params_asz ?? null;
            $gg_assenza = is_numeric($gg_assenza_val) ? (int) $gg_assenza_val : 0;

            return $gg_totali - $gg_assenza;
        }

        // Fallback: usa calcolo categoria economica
        return $this->gg_cateco_posfun_no_asz;
    }

    protected function getGgNoAsz(): float
    {
        $in_sede = $this->gg_in_sede_no_asz ?? 0.0;
        $fuori_sede = $this->gg_fuori_sede_no_asz ?? 0.0;

        return $in_sede + $fuori_sede;
    }

    protected function getGgCatecoNoAsz(): int
    {
        $asz_cateco = $this->gg_asz_cateco ?? 0;

        return -$asz_cateco;
    }

    protected function getGgInSedeNoAsz(): float
    {
        $asz_hh = $this->hh_asz_in_sede ?? 0.0;

        return -($asz_hh / 6);
    }

    protected function getPosfunval(): ?int
    {
        if ($this->posfun == null) {
            return null;
        }

        return (int) substr((string) $this->posfun, -1);
    }

    protected function getGg(): int
    {
        return $this->gg_in_sede + $this->gg_fuori_sede;
    }

    protected function getGgAszInSede(): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // Setup lista aspettative da escludere
        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        // Setup parametri query
        $parz = [
            'lista_tipo_codice' => $lista_aspettative,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        $result = $this->anag->ggAssenzaInSedeTot($data);

        /** @var int|null */
        return $result;
    }

    protected function getGgAszFuoriSede(): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // Setup lista aspettative da escludere
        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        // Setup parametri query
        $parz = [
            'lista_tipo_codice' => $lista_aspettative,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        // Calcolo puro delegato ad anagrafica
        $result = $this->anag->ggAssenzaFuoriSedeTot($parz);

        /** @var int|null */
        return $result;
    }

    protected function getGgAszCateco(): int
    {
        return $this->gg_asz_cateco_in_sede + $this->gg_asz_cateco_fuori_sede;
    }

    protected function getGgAszCatecoInSede(): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // Setup categoria e lista aspettative
        $categoria = $this->categoriaPropro;
        if ($categoria === null) {
            return null;
        }
        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        // Setup parametri query
        $parz = [
            'lista_propro' => $categoria->lista_propro,
            'lista_tipo_codice' => $lista_aspettative,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        $result = $this->anag->ggAssenzaInSedeTot($data);

        /** @var int|null */
        return $result;
    }

    protected function getValutatoreId(): ?int
    {
        // Se stabi dirigente non esiste, non possiamo determinare valutatore
        $stabi_diri = $this->stabiDirigente;
        if (! \is_object($stabi_diri)) {
            return null;
        }

        // Se stabi dirigente ha già valutatore, usalo
        $valutatore_id = $stabi_diri->valutatore_id;
        if ($valutatore_id !== null) {
            return (int) $valutatore_id;
        }

        // Altrimenti crea/trova StabiDirigente e auto-assegna
        $stabi_dirigente_class = Str::of(static::class)
            ->beforeLast('\\')
            ->append('\\StabiDirigente')
            ->toString();
        $stabi = $stabi_dirigente_class::firstOrCreate([
            'anno' => $this->anno,
            'stabi' => $this->stabi,
            'repar' => 0,
        ]);

        if ($stabi->valutatore_id === null) {
            $stabi->valutatore_id = $stabi->id;
            $stabi->save();
        }

        return (int) $stabi->valutatore_id;
    }

    protected function getPerfIndMedia(): ?float
    {
        $data = [];

        for ($i = 1; $i <= $this->n_perf_ind; $i++) {
            $anno = $this->anno - $i;
            $ris = $this->perfInd($anno);

            if ($ris > 0.0) {
                $data[$anno] = $ris;
            }
        }

        if (count($data) === 0) {
            return null;
        }

        return array_sum($data) / count($data);
    }

    public function getGgCatecoPosfunNoAsz(): ?int
    {
        if ($this->gg_cateco_posfun == null) {
            // dddx($this->getGgCatecoPosfun());
        }

        return intval($this->gg_cateco_posfun) - intval($this->gg_asz_cateco_posfun);
    }

    public function getGgAszCatecoPosfunInSede(): ?int
    {
        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // dddx($value);
        $categoria = $this->categoriaPropro;
        if ($categoria === null) {
            return null;
        }
        $lista_aspettative = $this->getListaTipoCodiceAspettative();
        $parz = [
            'lista_propro' => $categoria->lista_propro,
            'lista_tipo_codice' => $lista_aspettative,
            'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);
        $result = $this->anag->ggAssenzaInSedeTot($data);
        /** @var int|null $value */
        $value = $result;

        return intval($value);
    }

    public function getPropro(): ?int
    {
        if ($this->getKey() == null) {
            return null;
        }
        if ($this->dal == null && is_numeric($this->anno)) {
            $this->dal = ($this->anno * 10000) + 101;
        }
        if ($this->al == null && is_numeric($this->anno)) {
            $this->al = ($this->anno * 10000) + 1231;
        }
        if ($this->qua2kd == null && is_numeric($this->anno)) {
            $rows = Qua00f::where('ente', $this->ente)->where('matr', $this->matr)->get();

            // ---
        }

        $first = $this->qua00f
            ->where('qua2kd', $this->qua2kd)
            ->first();

        /** @var int|null */
        return $first?->propro;
    }

    public function getGgCatecoPosfun(): ?int
    {
        // f($this->gg_cateco_posfun_in_sede==null){
        //    dddx($this->getGgCatecoPosfunInSede());
        // }
        if ($this->getKey() == null) {
            return null;
        }

        return intval($this->gg_cateco_posfun_in_sede) + intval($this->gg_cateco_posfun_fuori_sede);
    }

    public function getGgCatecoInSede(): ?int
    {
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        if ($this->anag === null) {
            return null;
        }

        $categoria = $this->categoriaPropro;
        if ($categoria == null) {
            return null;
        }
        // dddx($categoria->lista_propro);
        // $criteri = $this->criteriEsclusione;
        $parz = [
            'lista_propro' => $categoria->lista_propro,
            'lista_propro_sup' => $categoria->lista_propro_sup,
            // 'posfun'=>$this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        // $parz['value'] = $value;
        // dddx($parz);
        $result = $this->anag->ggInSedeTot($data);

        /** @var int|null */
        return $result;
    }

    public function getGgCateco(): ?int
    {
        return $this->gg_cateco_in_sede + $this->gg_cateco_fuori_sede;
    }

    public function getGgCatecoPosfunInSede(): ?int
    {
        if ($this->anag === null) {
            return null;
        }

        $categoria = $this->categoriaPropro;
        if ($categoria == null) {
            dddx($this->getPropro());
            dddx([
                'scheda' => $this,
                'propro' => $this->propro,
                // 'categoriaPropro_sql' => $this->categoriaPropro()->ddRawSql()
            ]);

            return null;
        }
        $parz = [
            'lista_propro' => $categoria->lista_propro,
            // 'lista_propro_sup' => $categoria->lista_propro_sup,
            'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        $result = $this->anag->ggInSedeTot($data);

        /** @var int|null */
        return $result;
    }

    public function getGgAszCatecoPosfunFuoriSede(): ?int
    {
        // DA FARE !

        return 0;
    }

    public function getGgCatecoFuoriSede(): ?int
    {
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        $categoria = $this->categoriaPropro;
        if ($categoria == null) {
            return null;
        }
        // dddx($categoria->lista_propro);
        // $criteri = $this->criteriEsclusione;
        $result = $this->anag->ggFuoriSedeTot([
            'lista_propro' => $categoria->lista_propro,
            'lista_propro_sup' => $categoria->lista_propro_sup,
            // 'posfun'=>$this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ]);

        /** @var int|null $value */
        $value = $result;

        return intval($value);
    }

    public function getGgCatecoPosfunFuoriSede(): ?int
    {
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $categoria = $this->categoriaPropro;
        if ($categoria == null) {
            return null;
        }
        $result = $this->anag->ggFuoriSedeTot([
            'lista_propro' => $categoria->lista_propro,
            'lista_propro_sup' => $categoria->lista_propro_sup,
            'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ]);

        /** @var int|null $value */
        $value = $result;

        return intval($value);
    }

    public function getCriteriOptions(): ?Collection
    {
        return $this->criteriOptions->keyBy('name')->map(static fn ($item) => match ($item->type) {
            'list' => explode(',', (string) $item->value),
            'int' => intval($item->value),
            'date' => Date::parse($item->value),
            default => $item->value,
        });
    }

    public function getGgIntegParams(): ?int
    {
        $last_integ = Integparam::where('ente', $this->ente)
            ->where('matr', $this->matr)
            ->latest('anv2ka')
            ->first();
        if ($last_integ == null) {
            return null;
        }

        $criteriOption = $this->getCriteriOptions();

        $data_presenza_al = $criteriOption->get('data_presenza_al');
        // aggiornare campo con il valore minimo ..
        // dddx(['rows'=>$rows,'data_presenza_al'=>$data_presenza_al]);

        $days = $last_integ->anv2kd->diffInDays($data_presenza_al, true);

        return intval($days);
    }
}
