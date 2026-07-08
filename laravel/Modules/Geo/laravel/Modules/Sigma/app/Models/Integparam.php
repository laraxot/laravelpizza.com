<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Modules\Ptv\Models\Profile;
use Override;

/**
 * Modello per la gestione dei parametri di integrazione.
 *
 * @property int $id
 * @property string $ente Codice ente
 * @property string $matr Matricola
 * @property string $conome Cognome
 * @property string $nome Nome
 * @property Carbon $anv2kd Data inizio validità
 * @property Carbon $anv2ka Data fine validità
 * @property int $anvist Stato (default 0)
 * @property string $anvpar Parametro
 * @property float $anvimp Importo
 * @property float $anvqta Quantità (default 0.00)
 * @property string $anvvoc Vocabolario
 * @property string $anvdes Descrizione
 *
 * @method static Builder|Integparam newModelQuery()
 * @method static Builder|Integparam newQuery()
 * @method static Builder|Integparam query()
 * @method static Builder|Integparam whereId($value)
 * @method static Builder|Integparam whereEnte($value)
 * @method static Builder|Integparam whereMatr($value)
 * @method static Builder|Integparam whereConome($value)
 * @method static Builder|Integparam whereNome($value)
 * @method static Builder|Integparam whereAnv2kd($value)
 * @method static Builder|Integparam whereAnv2ka($value)
 * @method static Builder|Integparam whereAnvist($value)
 * @method static Builder|Integparam whereAnvpar($value)
 * @method static Builder|Integparam whereAnvimp($value)
 * @method static Builder|Integparam whereAnvqta($value)
 * @method static Builder|Integparam whereAnvvoc($value)
 * @method static Builder|Integparam whereAnvdes($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read string $full_name
 * @property-read string $validity_period
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|Integparam byEnte(string $ente)
 * @method static Builder<static>|Integparam byMatricola(string $matr)
 * @method static Builder<static>|Integparam byParametro(string $parametro)
 * @method static Builder<static>|Integparam byStato(int $stato)
 * @method static Builder<static>|Integparam byVocabolario(string $vocabolario)
 * @method static \Modules\Sigma\Database\Factories\IntegparamFactory factory($count = null, $state = [])
 * @method static Builder<static>|Integparam validInPeriod($startDate, $endDate)
 *
 * @mixin \Eloquent
 */
class Integparam extends BaseModel
{
    protected $table = 'integparam';

    /**
     * Gli attributi che sono assegnabili in massa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ente',
        'matr',
        'conome',
        'nome',
        'anv2kd',
        'anv2ka',
        'anvist',
        'anvpar',
        'anvimp',
        'anvqta',
        'anvvoc',
        'anvdes',
    ];

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return [
            'anv2kd' => 'date',
            'anv2ka' => 'date',
        ];
    }

    /**
     * Scope per filtrare per ente.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeByEnte(Builder $query, string $ente): Builder
    {
        return $query->where('ente', $ente);
    }

    /**
     * Scope per filtrare per matricola.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeByMatricola(Builder $query, string $matr): Builder
    {
        return $query->where('matr', $matr);
    }

    /**
     * Scope per filtrare per periodo di validità.
     *
     * @param  Builder<static>  $query
     * @param  Carbon|string  $startDate
     * @param  Carbon|string  $endDate
     * @return Builder<static>
     */
    protected function scopeValidInPeriod(Builder $query, $startDate, $endDate): Builder
    {
        return $query->where('anv2kd', '<=', $endDate)->where('anv2ka', '>=', $startDate);
    }

    /**
     * Scope per filtrare per stato.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeByStato(Builder $query, int $stato): Builder
    {
        return $query->where('anvist', $stato);
    }

    /**
     * Scope per filtrare per parametro.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeByParametro(Builder $query, string $parametro): Builder
    {
        return $query->where('anvpar', $parametro);
    }

    /**
     * Scope per filtrare per vocabolario.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeByVocabolario(Builder $query, string $vocabolario): Builder
    {
        return $query->where('anvvoc', $vocabolario);
    }

    /**
     * Verifica se il parametro è valido per una data specifica.
     *
     * @param  Carbon|string  $data
     */
    public function isValidForDate($data): bool
    {
        $data = $data instanceof Carbon ? $data : Date::parse($data);

        return $data->gte($this->anv2kd) && $data->lte($this->anv2ka);
    }

    /**
     * Verifica se il parametro è attivo.
     */
    public function isActive(): bool
    {
        return $this->anvist === 1;
    }

    /**
     * Ottiene il nome completo (cognome + nome).
     */
    protected function getFullNameAttribute(): string
    {
        return trim($this->conome.' '.$this->nome);
    }

    /**
     * Ottiene il periodo di validità come stringa.
     */
    protected function getValidityPeriodAttribute(): string
    {
        return $this->anv2kd->format('d/m/Y').' - '.$this->anv2ka->format('d/m/Y');
    }
}
