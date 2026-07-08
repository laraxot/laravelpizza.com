<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\IndennitaCondizioniLavoro\Models\Traits\MutatorTrait;
use Modules\IndennitaCondizioniLavoro\Models\Traits\RelationshipTrait;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
// ------ ext models---
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
// ---- traits --
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Traits\SigmaModelTrait;
use Modules\Sigma\Models\Wstr01lx;
use Illuminate\Support\Facades\DB;
use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;
use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;

/**
 * Modules\IndennitaCondizioniLavoro\Models\ServizioEsterno.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $email
 * @property string|null $cognome
 * @property string|null $nome
 * @property int|null $trimestre
 * @property int|null $stabi
 * @property string|null $stabi_txt
 * @property int|null $repar
 * @property string|null $repar_txt
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $categoria_eco
 * @property int|null $posiz
 * @property string|null $posiz_txt
 * @property int|null $gg_presenza_anno
 * @property int|null $gg_presenza_periodo
 * @property int|null $gg_assenza_anno
 * @property string|null $hh_assenza_anno
 * @property int|null $gg_trasferte_anno
 * @property int|null $anno
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property \Illuminate\Support\Carbon|null $dal
 * @property \Illuminate\Support\Carbon|null $al
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $disci1
 * @property string $disci1_txt
 * @property string|null $codqua
 * @property string $codqua_txt
 * @property int|null $tot_presenza_periodo_plus_no_timbr
 * @property float|null $tot
 * @property int|null $valutatore_id
 * @property int|null $quadrimestre
 * @property-read Collection<int, Sto00f> $Sto00fYear
 * @property-read int|null $sto00f_year_count
 * @property-read Collection<int, Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read Collection<int, Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read Collection<int, Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read Collection<int, Asz00k1> $asz00k1Year
 * @property-read int|null $asz00k1_year_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo> $all_indennita_tipo
 * @property-read string $from_field
 * @property-read int|float $gg_p_time_vert_year
 * @property-read mixed $gg_parttimevert_anno
 * @property-read int|null $gg_parttimevert
 * @property-read mixed $gg_parttimevert_dalal
 * @property-read mixed $gg_presenza_dalal
 * @property-read \Illuminate\Support\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio> $indennita_tipo_dettaglio_all
 * @property-read mixed $last_data_assunz
 * @property-read int|float $perc_p_time_daterange
 * @property-read int|float $perc_p_time_year
 * @property-read mixed $perc_parttime_anno
 * @property-read float|null $perc_parttime
 * @property-read mixed $perc_parttime_dalal
 * @property-read mixed $titolo_di_studio
 * @property-read string $to_field
 * @property-read float|null $tot_x_ptime
 * @property-read Collection<int, IndennitaTipoDettaglio> $indennitaTipoDettaglio
 * @property-read int|null $indennita_tipo_dettaglio_count
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Qua00f> $qua00fDaterange
 * @property-read int|null $qua00f_daterange_count
 * @property-read Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read Collection<int, Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read StabiDirigente|null $stabiDirigente
 * @property-read Collection<int, Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read Collection<int, IndennitaTipoDettaglio> $tipoDettaglio
 * @property-read int|null $tipo_dettaglio_count
 * @property-read Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read Collection<int, Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 * @method static Builder|ServizioEsterno newModelQuery()
 * @method static Builder|ServizioEsterno newQuery()
 * @method static Builder|ServizioEsterno ofDate(int $date)
 * @method static Builder|ServizioEsterno ofEnteYear(int $ente, int $year)
 * @method static Builder|ServizioEsterno ofQuarter(int $quarter, int $year)
 * @method static Builder|ServizioEsterno ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|ServizioEsterno ofYear(int $year)
 * @method static Builder|ServizioEsterno query()
 * @method static Builder|ServizioEsterno whereAl($value)
 * @method static Builder|ServizioEsterno whereAnno($value)
 * @method static Builder|ServizioEsterno whereCategoriaEco($value)
 * @method static Builder|ServizioEsterno whereCodqua($value)
 * @method static Builder|ServizioEsterno whereCodquaTxt($value)
 * @method static Builder|ServizioEsterno whereCognome($value)
 * @method static Builder|ServizioEsterno whereCreatedAt($value)
 * @method static Builder|ServizioEsterno whereCreatedBy($value)
 * @method static Builder|ServizioEsterno whereDal($value)
 * @method static Builder|ServizioEsterno whereDisci1($value)
 * @method static Builder|ServizioEsterno whereDisci1Txt($value)
 * @method static Builder|ServizioEsterno whereEmail($value)
 * @method static Builder|ServizioEsterno whereEnte($value)
 * @method static Builder|ServizioEsterno whereGgAssenzaAnno($value)
 * @method static Builder|ServizioEsterno whereGgPresenzaAnno($value)
 * @method static Builder|ServizioEsterno whereGgPresenzaPeriodo($value)
 * @method static Builder|ServizioEsterno whereGgTrasferteAnno($value)
 * @method static Builder|ServizioEsterno whereHhAssenzaAnno($value)
 * @method static Builder|ServizioEsterno whereId($value)
 * @method static Builder|ServizioEsterno whereMatr($value)
 * @method static Builder|ServizioEsterno whereNome($value)
 * @method static Builder|ServizioEsterno wherePosfun($value)
 * @method static Builder|ServizioEsterno wherePosiz($value)
 * @method static Builder|ServizioEsterno wherePosizTxt($value)
 * @method static Builder|ServizioEsterno wherePropro($value)
 * @method static Builder|ServizioEsterno whereQua2ka($value)
 * @method static Builder|ServizioEsterno whereQua2kd($value)
 * @method static Builder|ServizioEsterno whereQuadrimestre($value)
 * @method static Builder|ServizioEsterno whereRep2ka($value)
 * @method static Builder|ServizioEsterno whereRep2kd($value)
 * @method static Builder|ServizioEsterno whereRepar($value)
 * @method static Builder|ServizioEsterno whereReparTxt($value)
 * @method static Builder|ServizioEsterno whereStabi($value)
 * @method static Builder|ServizioEsterno whereStabiTxt($value)
 * @method static Builder|ServizioEsterno whereTot($value)
 * @method static Builder|ServizioEsterno whereTotPresenzaPeriodoPlusNoTimbr($value)
 * @method static Builder|ServizioEsterno whereTrimestre($value)
 * @method static Builder|ServizioEsterno whereUpdatedAt($value)
 * @method static Builder|ServizioEsterno whereUpdatedBy($value)
 * @method static Builder|ServizioEsterno whereValutatoreId($value)
 * @method static Builder|ServizioEsterno withDays(int $date_min, int $date_max)
 * @property-read Profile|null $creator
 * @property-read string|null $codice_fiscale
 * @property-read string|null $inail
 * @property-read string|null $sesso
 * @property-read Profile|null $updater
 * @method static Builder<static>|ServizioEsterno ofEnte(int $ente)
 * @method static Builder<static>|ServizioEsterno ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @property-read Profile|null $deleter
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read Collection<int, Rep00f> $reparts
 * @property-read int|null $reparts_count
 * @property-read \Modules\IndennitaCondizioniLavoro\Models\ServizioEsternoIndennitaTipoDettaglioPivot|null $pivot
 * @property-read Collection<int, ServizioEsterno> $trasferte
 * @property-read int|null $trasferte_count
 * @mixin \Eloquent
 */
class ServizioEsterno extends BaseModel implements DateRangeFieldsContract, EnteMatrFieldsContract
{
    use MutatorTrait, RelationshipTrait, SigmaModelTrait {
        MutatorTrait::getFromFieldAttribute insteadof SigmaModelTrait;
        MutatorTrait::getToFieldAttribute insteadof SigmaModelTrait;
    }

    protected $table = 'condizioni_lavoro'; // sia condizioni_lavoro che servizio_esterno usano la stessa tabella

    protected $fillable = [
        'ente', 'matr', 'cognome', 'nome', 'email',
        'stabi', 'stabi_txt', 'repar', 'repar_txt',
        'propro', 'posfun', 'categoria_eco',
        'gg_presenza_anno', 'gg_assenza_anno', 'gg_trasferte_anno',
        'anno', 'trimestre', 'dal', 'al',
        'rep2kd', 'rep2ka', 'qua2kd', 'qua2ka',
        'gg_presenza_periodo',
        'tot_presenza_periodo_plus_no_timbr',
    ];

    protected function casts(): array
    {
        return [
            'dal' => 'datetime',
            'al' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function rangeFromField(): string
    {
        return 'dal';
    }

    public function rangeToField(): string
    {
        return 'al';
    }

    public function annFieldName(): string
    {
        return 'anno';
    }

    public function matrField(): string
    {
        return 'matr';
    }

    public function enteField(): string
    {
        return 'ente';
    }

    public function yearField(): string
    {
        return 'anno';
    }

    // ------ relationship ----------

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Sigma\Models\Rep00f, $this>
     */
    public function reparts(): HasMany
    {
        return $this->hasMany(Rep00f::class, 'repar', 'repar')
            ->where('repst1', $this->stabi);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Illuminate\Database\Eloquent\Model, $this>
     */
    public function trasferte(): HasMany
    {
        return $this->hasMany(self::trasferteRelatedClass(), 'matr', 'matr')
            ->where('ente', $this->ente);
    }

    /**
     * @return class-string<Model>
     */
    private static function trasferteRelatedClass(): string
    {
        $trasfertaClass = 'Modules\Trasferte\Models\FuoriSedeDip';
        if (class_exists($trasfertaClass) && is_subclass_of($trasfertaClass, Model::class)) {
            return $trasfertaClass;
        }

        return self::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this, \Modules\IndennitaCondizioniLavoro\Models\ServizioEsternoIndennitaTipoDettaglioPivot, 'pivot'>
     */
    public function indennitaTipoDettaglio(): BelongsToMany
    {
        $cross = 'servizio_esterno_x_indennita_tipo_dettaglio';
        $pivot_fields = ['gg'];

        return $this->belongsToMany(IndennitaTipoDettaglio::class, $cross)
            ->using(ServizioEsternoIndennitaTipoDettaglioPivot::class)
            ->withPivot($pivot_fields)
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this, \Modules\IndennitaCondizioniLavoro\Models\ServizioEsternoIndennitaTipoDettaglioPivot, 'pivot'>
     */
    public function tipoDettaglio(): BelongsToMany
    {
        $cross = 'servizio_esterno_x_indennita_tipo_dettaglio';
        $pivot_fields = ['gg'];

        return $this->belongsToMany(IndennitaTipoDettaglio::class, $cross)
            ->using(ServizioEsternoIndennitaTipoDettaglioPivot::class)
            ->withPivot($pivot_fields)
            ->withTimestamps();
    }

    // -------- mutators ------------

    public function getTotAttribute(?float $value): ?float
    {
        $tot = 0;
        foreach ($this->indennitaTipoDettaglio as $indennitumTipoDettaglio) {
            /** @var ServizioEsternoIndennitaTipoDettaglioPivot|null $pivot */
            $pivot = $indennitumTipoDettaglio->getRelationValue('pivot');
            if ($pivot !== null && is_object($pivot)) {
                $gg = isset($pivot->gg) && is_numeric($pivot->gg) ? (int) $pivot->gg : 0;
                $euroGiorno = isset($indennitumTipoDettaglio->euro_giorno) && is_numeric($indennitumTipoDettaglio->euro_giorno) ? (float) $indennitumTipoDettaglio->euro_giorno : 0.0;
                $tot += $euroGiorno * $gg;
            }
        }

        return $tot;
    }

    public function getTotXPtimeAttribute(?float $value): ?float
    {
        $tot = $this->tot ?? 0.0;
        $percPTime = $this->perc_p_time_daterange ?? null;
        $ptime = is_numeric($percPTime) ? (float) $percPTime : 0.0;

        return $tot * $ptime;
    }

    public function getReparTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $repart = $this->reparts()->where('repar', $this->repar)->first();
        if (! $repart instanceof Rep00f) {
            return null;
        }

        $dest1 = $repart->getAttribute('dest1');

        return is_string($dest1) ? $dest1 : null;
    }

    public function getDisci1Attribute(?string $value): ?string
    {
        $qua00f_curr = $this->qua00fDaterange->first();
        if (! \is_object($qua00f_curr)) {
            return null;
        }

        $disci1 = $qua00f_curr->getAttribute('disci1');

        return is_numeric($disci1) ? (string) $disci1 : null;
    }

    public function getCodquaAttribute(?string $value): ?string
    {
        $qua00f_curr = $this->qua00fDaterange->first();
        if (! $qua00f_curr instanceof Qua00f) {
            return '---';
        }

        $codqua = $qua00f_curr->getAttribute('codqua');

        // Type narrowing: codqua should be int from database, convert to string
        return is_numeric($codqua) ? (string) $codqua : (is_string($codqua) ? $codqua : '---');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo>
     */
    public function getAllIndennitaTipoAttribute(mixed $value): Collection
    {
        return IndennitaTipo::all();
    }

    public function getGgTrasferteAnnoAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }

        $trasferte = $this->trasferte;
        $giorni = [];

        foreach ($trasferte as $trasf) {
            if (! ($trasf instanceof Model)) {
                continue;
            }
            $dal = $trasf->getAttribute('dal');
            $al = $trasf->getAttribute('al');

            // Type narrowing: ensure $dal and $al are valid before calling toCarbonOrNull
            $dalDate = null;
            $alDate = null;

            if ($dal !== null && (is_string($dal) || is_numeric($dal) || $dal instanceof DateTimeInterface)) {
                $dalDate = $this->toCarbonOrNull($dal);
            }

            if ($al !== null && (is_string($al) || is_numeric($al) || $al instanceof DateTimeInterface)) {
                $alDate = $this->toCarbonOrNull($al);
            }

            if ($dalDate === null || $alDate === null) {
                continue;
            }

            $curr = $dalDate->copy();
            while ($curr->lte($alDate)) {
                $giorni[] = $curr->format('Ymd');
                $curr = $curr->copy()->addDay();
            }
        }

        $giorni = array_unique($giorni);
        $giorni = \count($giorni);

        $this->gg_trasferte_anno = $giorni;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $giorni;
        }

        $this->update([
            'gg_trasferte_anno' => $giorni,
        ]);

        return $giorni;
    }

    public function getGgPresenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }

        // 343    Called 'count' on Laravel collection, but could have been retrieved as a query.
        $gg = $this->wstr01lx()->select('wtdata')->distinct('wtdata')->get()->count();
        $this->gg_presenza_anno = $gg;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $gg;
        }

        $this->update([
            'gg_presenza_anno' => $gg,
        ]);

        return $gg;
    }

    public function getTotPresenzaPeriodoPlusNoTimbrAttribute(?int $value): ?int
    {
        $value ??= 0;
        $presenzaPeriodo = $this->gg_presenza_periodo ?? 0;

        if ($value < $presenzaPeriodo) {
            return $presenzaPeriodo;
        }

        return $value;
    }

    public function getGgAssenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }

        $asz = $this->asz00k1()->where('aszumi', 'G')->get();
        $sumResult = $asz->sum('aszdur');
        $gg = is_numeric($sumResult) ? (int) $sumResult : 0;
        $this->gg_assenza_anno = $gg;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $gg;
        }

        $this->update([
            'gg_assenza_anno' => $gg,
        ]);

        return $gg;
    }

    public function getHhAssenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }

        $asz = $this->asz00k1()->where('aszumi', 'O')
            ->whereRaw('concat(asztip,"-",aszcod)!="504-13"')
            ->get();
        $sumResult = $asz->sum('aszdur');
        $hh = is_numeric($sumResult) ? (int) $sumResult : 0;
        $this->hh_assenza_anno = $hh;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $hh;
        }

        $this->update([
            'hh_assenza_anno' => $hh,
        ]);

        return $hh;
    }

    public function getCognomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $anag = $this->anag;
        if (! $anag instanceof Anag) {
            return null;
        }

        $cognomeAttr = $anag->getAttribute('conome');
        $nomeAttr = $anag->getAttribute('nome');

        $cognome = is_string($cognomeAttr) ? $cognomeAttr : null;
        $nome = is_string($nomeAttr) ? $nomeAttr : null;

        $this->cognome = $cognome;
        $this->nome = $nome;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $cognome;
        }

        $this->update([
            'cognome' => $cognome,
            'nome' => $nome,
        ]);

        return $cognome;
    }

    public function getNomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $anag = $this->anag;
        if (! $anag instanceof Anag) {
            return null;
        }

        $nomeAttr = $anag->getAttribute('nome');
        $nome = is_string($nomeAttr) ? $nomeAttr : null;

        $this->nome = $nome;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $nome;
        }

        $this->update([
            'nome' => $nome,
        ]);

        return $nome;
    }

    // --------- function -----------

    /**
     * @param array<string, mixed> $params
     */
    public static function populate(array $params): void
    {
        // $params=array_merge(getRouteParameters(),$params);
        $anno = 0;
        $stabi = 0;
        $repar = 0;
        extract($params);
        $sql = '(
    		('.$anno.' between year(rep2kd) and year(rep2ka))
    		or
    		('.$anno.' >= year(rep2kd) and rep2ka=0)
    	)';
        $rows0 = Rep00f::where('repst1', $stabi)->where('repre1', $repar)->whereRaw($sql)->whereRaw('repann=""');
        foreach ($rows0->get() as $row) {
            $rep2kdRaw = $row->rep2kd ?? null;
            $rep2kaRaw = $row->rep2ka ?? null;
            // Type narrowing: toCarbonOrNull accepts mixed but returns Carbon|null
            /** @var \Carbon\Carbon|null $rep2kdDate */
            $rep2kdDate = self::toCarbonOrNull($rep2kdRaw);
            /** @var \Carbon\Carbon|null $rep2kaDate */
            $rep2kaDate = self::toCarbonOrNull($rep2kaRaw);

            $rep2kdFormatted = $rep2kdDate !== null ? $rep2kdDate->format('Ymd') : null;
            $rep2kaFormatted = $rep2kaDate !== null ? $rep2kaDate->format('Ymd') : null;
            $rep2kd = $rep2kdFormatted ?? (is_string($row->rep2kd) || is_numeric($row->rep2kd) ? (string) $row->rep2kd : '');
            $rep2ka = $rep2kaFormatted ?? (is_string($row->rep2ka) || is_numeric($row->rep2ka) ? (string) $row->rep2ka : '');
            $parz = ['ente' => $row->ente,
                'matr' => $row->matr,
                'stabi' => $row->repst1,
                'repar' => $row->repre1,
                'rep2kd' => $rep2kd,
                'rep2ka' => $rep2ka,
                'anno' => $anno, ];

            $obj = self::firstOrCreate($parz);
            $obj->rep2kd = $row->rep2kd;
            $obj->rep2ka = $row->rep2ka;
            $obj->anno = $anno;
            if ($obj->dal === null) {
                $obj->dal = Carbon::createFromDate($anno, 1, 1);
            }

            if ($obj->al === null) {
                $obj->al = Carbon::createFromDate($anno, 12, 31);
            }

            if ($obj->propro === 0 || $obj->propro === null) {
                // Type narrowing: ensure dal and al are valid before calling toCarbonOrNull
                $dalRaw = $obj->dal ?? null;
                $alRaw = $obj->al ?? null;
                // toCarbonOrNull() returns ?Carbon, add explicit type annotation
                /** @var \Carbon\Carbon|null $dalCarbon */
                $dalCarbon = self::toCarbonOrNull($dalRaw);
                /** @var \Carbon\Carbon|null $alCarbon */
                $alCarbon = self::toCarbonOrNull($alRaw);

                // Type narrowing: format() returns string, ensure we have valid strings
                /** @var string $dalFormatted */
                $dalFormatted = $dalCarbon !== null ? $dalCarbon->format('Ymd') : '';
                /** @var string $alFormatted */
                $alFormatted = $alCarbon !== null ? $alCarbon->format('Ymd') : '';

                // Ensure formatted values are strings for SQL concatenation
                /** @var string $dalFormattedStr */
                $dalFormattedStr = is_string($dalFormatted) ? $dalFormatted : '';
                /** @var string $alFormattedStr */
                $alFormattedStr = is_string($alFormatted) ? $alFormatted : '';

                $qua00fDateRangeSql = <<<'SQL'
(
    (? between qua2kd and qua2ka )
    or
    (? >= qua2kd and qua2ka=0 )
    or
    (? between qua2kd and qua2ka )
    or
    (? >= qua2kd and qua2ka=0 )
    or
    (qua2kd between ? and ?)
    or
    (qua2ka between ? and ?)
)
SQL;
                $qua00fDateRangeBindings = [
                    $dalFormattedStr,
                    $dalFormattedStr,
                    $alFormattedStr,
                    $alFormattedStr,
                    $dalFormattedStr,
                    $alFormattedStr,
                    $dalFormattedStr,
                    $alFormattedStr,
                ];
                if ($obj->anag === null) {
                    throw new Exception('obj-anag is null ['.__LINE__.']['.__FILE__.']');
                }

                $qua00f = $obj->anag->qua00f()->select('propro', 'posfun', 'posiz')->distinct()->whereRaw(DB::raw($qua00fDateRangeSql), $qua00fDateRangeBindings);
                // echo '<br/>'.$qua00f->count().' - '.$qua00f->first()->propro.'  - '.$qua00f->first()->posfun;
                if ($qua00f->get()->count() === 1) {
                    $first = $qua00f->first();
                    if ($first instanceof Model) {
                        $propro = $first->getAttribute('propro');
                        $posfun = $first->getAttribute('posfun');
                        $posiz = $first->getAttribute('posiz');

                        $obj->propro = is_numeric($propro) ? (int) $propro : null;
                        $obj->posfun = is_numeric($posfun) ? (int) $posfun : null;
                        $obj->posiz = is_numeric($posiz) ? (int) $posiz : null;
                    }
                } else {
                    echo '<br/>$qua00f->count() : '.$qua00f->count();
                    echo '<br/>ente :'.$obj->ente;
                    echo '<br/>matr :'.$obj->matr;
                    echo "<br/>qualcosa e' andato storto [".__LINE__.']['.__FILE__.']';
                    echo '<pre>';
                    print_r($qua00f->toSql());
                    $qua00f = $obj->anag->qua00f()->whereRaw(DB::raw($qua00fDateRangeSql), $qua00fDateRangeBindings)->orderBy('qua2kd')->get();

                    // foreach($qua00f as $v_qua00f){
                    $al_old = $obj->al;
                    $firstQua00f = $qua00f->first();
                    if ($firstQua00f instanceof Model) {
                        $qua2kd = $firstQua00f->getAttribute('qua2kd');
                        if ($qua2kd !== null && (is_string($qua2kd) || is_numeric($qua2kd) || $qua2kd instanceof DateTimeInterface)) {
                            $obj->al = Carbon::parse($qua2kd);
                        }
                    }
                    $obj->save();

                    $obj1 = $obj->replicate();
                    // Type narrowing: ensure qua00f[1] exists and is Model
                    if (isset($qua00f[1]) && $qua00f[1] instanceof Model) {
                        $qua00f_1 = $qua00f[1];
                        $qua2kd = $qua00f_1->getAttribute('qua2kd');
                        $qua2ka = $qua00f_1->getAttribute('qua2ka');

                        if ($qua2kd !== null && (is_string($qua2kd) || is_numeric($qua2kd) || $qua2kd instanceof DateTimeInterface)) {
                            $obj1->dal = Carbon::parse($qua2kd);
                        }
                        if ($qua2ka !== null && $qua2ka !== 0 && (is_string($qua2ka) || is_numeric($qua2ka) || $qua2ka instanceof DateTimeInterface)) {
                            $obj1->al = Carbon::parse($qua2ka);
                        } else {
                            $obj1->al = $al_old;
                        }
                    }
                    // 497    Property Modules\IndennitaCondizioniLavoro\Models\ServizioEsterno::$id (int) does not accept null.
                    // $obj1->id = null;
                    $obj1->save();
                }
            }

            $obj->save();
        }
    }

    /**
     * Helper method to convert mixed value to Carbon or null.
     */
    protected static function toCarbonOrNull(mixed $value): ?\Carbon\Carbon
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        if (is_string($value) || is_int($value)) {
            try {
                return Carbon::parse($value);
            } catch (Exception $e) {
                return null;
            }
        }

        return null;
    }

    // end function
}// end class
