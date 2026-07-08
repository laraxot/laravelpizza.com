<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Performance\Models\BaseIndividualeModel;
use Spatie\QueueableAction\QueueableAction;

/**
 * @template TModel of Model
 */
class GetHaDirittoMotivoAction
{
    use QueueableAction;

    public int $year;

    /**
     * @param  BaseIndividualeModel<object>  $model
     * @param  array<string, mixed>  $criteriEsclusione
     * @param  array<string, mixed>  $criteriOption
     * @return array{0:int,1:string}
     */
    public function execute(BaseIndividualeModel $model, array $criteriEsclusione, array $criteriOption): array
    {
        $haDiritto = true;
        $motivi = [];
        $anno = (int) ($model->anno ?? $this->year ?? 0);

        foreach ($criteriEsclusione as $criterio => $valore) {
            if (! is_string($criterio)) {
                throw new Exception('Chiave criterio non valida.');
            }

            $metodo = 'check'.Str::studly($criterio);
            if (! method_exists($this, $metodo)) {
                continue;
            }

            $params = $criteriOption;
            $params[$criterio] = $valore;
            $params['date_max'] = $anno * 10000 + 1231;
            $params['date_min'] = $anno * 10000 + 101;

            $callable = [$this, $metodo];
            // @phpstan-ignore-next-line
            $messaggio = $callable($params, $model);

            if ($messaggio !== '') {
                $motivi[] = $messaggio;
                $haDiritto = false;
            }
        }

        return [$haDiritto ? 1 : 0, implode(', ', $motivi)]; // @phpstan-ignore-line
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object{gg_ruolo:int|null}  $scheda
     */
    public function checkMinGgRuolo(array $params, object $scheda): string
    {
        if (! isset($params['min_gg_ruolo'])) {
            throw new Exception('min_gg_ruolo is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $min = (int) $params['min_gg_ruolo'];
        $valore = (int) ($scheda->gg_ruolo ?? 0);

        return $valore < $min ? sprintf('no min gg_ruolo [%d]', $valore) : '';
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkMinGgAnno(array $params, object $scheda): string
    {
        if (! isset($params['min_gg_anno'])) {
            throw new Exception('min_gg_anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $min = (int) $params['min_gg_anno'];
        $presenza = (int) ($scheda->gg_presenza_anno ?? 0);
        $assenza = (int) ($scheda->gg_assenza_anno ?? 0);
        $effettivi = $presenza - $assenza;

        return $effettivi < $min ? sprintf('no min gg_anno [%d]', $effettivi) : '';
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkNoposizList(array $params, object $scheda): string
    {
        if (! isset($params['noposiz_list'])) {
            throw new Exception('noposiz_list is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $lista = array_filter(array_map('trim', explode(',', (string) $params['noposiz_list'])));
        $posiz = (string) ($scheda->posiz ?? '');

        return in_array($posiz, $lista, true) ? sprintf('no_posiz [%s]', $posiz) : '';
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkNoproproList(array $params, object $scheda): string
    {
        if (! isset($params['nopropro_list'])) {
            throw new Exception('nopropro_list is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $lista = array_filter(array_map('trim', explode(',', (string) $params['nopropro_list'])));
        $propro = (string) ($scheda->propro ?? '');

        return in_array($propro, $lista, true) ? sprintf('no_propro [%s]', $propro) : '';
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkNoposfunList(array $params, object $scheda): string
    {
        if (! isset($params['noposfun_list'])) {
            throw new Exception('noposfun_list is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $lista = array_filter(array_map('trim', explode(',', (string) $params['noposfun_list'])));
        $posfun = (string) ($scheda->posfun ?? '');

        return in_array($posfun, $lista, true) ? sprintf('no_posfun [%s]', $posfun) : '';
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkNodisci1List(array $params, object $scheda): string
    {
        if (! isset($params['nodisci1_list'])) {
            throw new Exception('nodisci1_list is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $lista = array_filter(array_map('trim', explode(',', (string) $params['nodisci1_list'])));
        $disci1 = (string) ($scheda->disci1 ?? '');

        return in_array($disci1, $lista, true) ? sprintf('no_disci1 [%s]', $disci1) : '';
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkMaxGgAssenzeAnno(array $params, object $scheda): string
    {
        if (! isset($params['max_gg_assenze_anno'])) {
            throw new Exception('max_gg_assenze_anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $max = (int) $params['max_gg_assenze_anno'];
        $assenze = (int) ($scheda->gg_assenza_anno ?? 0);

        return $assenze > $max ? sprintf('max gg assenze anno [%d]>[%d]', $assenze, $max) : '';
    }

    /**
     * Alias storico.
     *
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkMaxGgAssenzaAnno(array $params, object $scheda): string
    {
        return $this->checkMaxGgAssenzeAnno($params, $scheda);
    }

    /**
     * @param  array<string, mixed>  $params
     * @param  object  $scheda
     */
    public function checkDateMinAssunz(array $params, object $scheda): string
    {
        if (! isset($params['date_min_assunz'])) {
            throw new Exception('date_min_assunz is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $dateMin = $params['date_min_assunz'];
        $dateMin = $dateMin instanceof Carbon ? $dateMin : Carbon::parse((string) $dateMin);

        $lastAssunzione = $scheda->last_data_assunz ?? null;
        if ($lastAssunzione === null) {
            return '';
        }

        $lastAssunzione = $lastAssunzione instanceof Carbon ? $lastAssunzione : Carbon::parse((string) $lastAssunzione);

        if ($lastAssunzione->greaterThan($dateMin)) {
            return sprintf('date min assunz [%s]>[%s][1]', $lastAssunzione->format('Y-m-d'), $dateMin->format('Y-m-d'));
        }

        return '';
    }

    // Metodi checkMinGgPropro, checkMinGgProproPosfun, checkMinGgTempoDeterminato, checkMinGgEffettuati
    // sono lasciati vuoti in quanto non implementavano logica neanche nella versione precedente.
}
