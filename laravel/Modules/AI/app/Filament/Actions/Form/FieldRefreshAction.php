<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Xot\Filament\Actions\Form;

use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Actions\XotBaseAction;

/**
 * Bottone accanto a un campo del form: ricalcola il valore con il gemello puro `get{Campo}()` del
 * record (regola accessor + gemello) e lo mette nel form. Non salva: salva l'utente con "Salva".
 *
 * 2026-11-05: logica ripristinata. Il commit `c254b66aa1` (2026-09-02, messaggio ".") l'aveva
 * ridotta alla sola notifica "Valore ricalcolato": il bottone mentiva su tutte le schede. Guardia:
 * Xot/tests/Unit/Filament/FieldRefreshActionTest.php.
 */
class FieldRefreshAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel();
        $this->icon('heroicon-o-arrow-path')
            ->label('')
            ->tooltip('Ricalcola valore')
            ->action(function (mixed $record, Set $set): void {
                $name = $this->getName();
                if (! is_string($name) || $name === '' || ! is_object($record)) {
                    $this->notify('Errore', 'Campo o record non valido', false);

                    return;
                }

                $getter = self::getterName($name);
                if (! self::hasPublicGetter($record, $getter)) {
                    $this->notify('Errore', sprintf('Metodo %s non disponibile (o non public) su [%s]', $getter, $record::class), false);

                    return;
                }

                $value = $this->toFieldState($record->{$getter}());
                $set($name, $value);

                $this->notify('Valore ricalcolato', is_scalar($value) || $value === null ? var_export($value, true) : get_debug_type($value), true);
            });
    }

    /**
     * Nome del gemello puro che calcola il campo: `gg_in_sede` => `getGgInSede`.
     */
    public static function getterName(string $field): string
    {
        return 'get'.Str::studly($field);
    }

    /**
     * Valore del gemello nel formato dello stato del campo: un DatePicker vuole la stringa nel suo
     * formato (Y-m-d), non un Carbon (es. getLastIntegParamAt()). Gli altri valori passano invariati.
     */
    public function toFieldState(mixed $value): mixed
    {
        if (! $value instanceof \DateTimeInterface) {
            return $value;
        }
        $component = $this->getSchemaComponent();

        return $value->format($component instanceof DateTimePicker ? $component->getFormat() : 'Y-m-d');
    }

    /**
     * Il gemello esiste davvero ed e' public. Ne' is_callable ne' method_exists bastano da soli:
     * Eloquent ha __call, quindi is_callable() e' true per QUALSIASI nome (getLastEsperienzaAt
     * inesistente finiva in BadMethodCallException, 500); method_exists() e' true anche per protected.
     */
    public static function hasPublicGetter(object $record, string $getter): bool
    {
        return method_exists($record, $getter) && (new \ReflectionMethod($record, $getter))->isPublic();
    }

    public static function getDefaultName(): ?string
    {
        return 'field_refresh';
    }

    private function notify(string $title, string $body, bool $success): void
    {
        $notification = Notification::make()->title($title)->body($body);
        ($success ? $notification->success() : $notification->danger())->send();
    }
}
