<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;

/**
 * Invia un SMS delegando dinamicamente al motore configurato per `$driver`.
 *
 * Migrato dal vecchio `SmsService` (facade statica fluente
 * `make()->setLocalVars()->mergeVars()->send()`): un solo `execute()`
 * sostituisce l'intera catena, impostando prima le proprietà (come faceva
 * `setLocalVars()`/`mergeVars()`) e poi tentando il dispatch.
 *
 * Il dispatch per riflessione verso `Actions\SMS\SmsEngines\{Driver}Engine`
 * è preservato as-is dal Service originale (comportamento invariato):
 * nessun engine concreto esiste in questo namespace, quindi l'azione lancia
 * sempre `RuntimeException` — esattamente come faceva `SmsService::send()`
 * puntando al vecchio namespace `Services\SmsEngines`, mai popolato. Non è
 * stato introdotto un fix funzionale qui: è fuori scope della migrazione
 * Services → Actions (vedi story `notify-services-to-actions.story.md`).
 *
 * @SuppressWarnings("PHPMD.ShortVariable") Trade-off: la proprietà pubblica `$to` è parte dell'API SMS esistente.
 */
class SendSmsAction
{
    use QueueableAction;

    public ?string $to = null;

    public ?string $from = null;

    public ?string $body = null;

    /**
     * @var array<string, mixed>
     */
    public array $vars = [];

    public string $driver = 'netfun';

    /**
     * @param  array<string, mixed>  $vars  Variabili del template SMS (chiavi note: to, from, body).
     * @return array<string, mixed> Vars aggiornate con l'esito del motore (status_code, status_txt, ...).
     *
     * @throws RuntimeException Se il motore SMS per `$driver` non esiste o è incompleto.
     */
    public function execute(array $vars, string $driver = 'netfun'): array
    {
        $this->driver = $driver;
        $this->setLocalVars($vars);

        $engineClassName = '\\Modules\\Notify\\Actions\\SMS\\SmsEngines\\'.Str::studly($this->driver).'Engine';

        if (! class_exists($engineClassName)) {
            throw new RuntimeException("La classe del motore SMS {$engineClassName} non esiste");
        }

        if (! method_exists($engineClassName, 'make')) {
            throw new RuntimeException("La classe {$engineClassName} non implementa il metodo make()");
        }

        $instance = $engineClassName::make();

        if (! is_object($instance)) {
            throw new RuntimeException("Il metodo make() di {$engineClassName} non ha restituito un oggetto");
        }

        foreach (['setLocalVars', 'send', 'getVars'] as $method) {
            if (! method_exists($instance, $method)) {
                throw new RuntimeException("L'istanza di {$engineClassName} non implementa il metodo {$method}()");
            }
        }

        try {
            $reflectionClass = new ReflectionClass($instance);

            $setLocalVarsMethod = $reflectionClass->getMethod('setLocalVars');
            $setLocalVarsMethod->invoke($instance, $this->vars);

            $sendMethod = $reflectionClass->getMethod('send');
            $sendMethod->invoke($instance);

            $getVarsMethod = $reflectionClass->getMethod('getVars');
            $result = $getVarsMethod->invoke($instance);

            if (! is_array($result)) {
                $result = [];
            }

            /** @var array<string, mixed> $typedResult */
            $typedResult = [];
            foreach ($result as $key => $value) {
                if (is_string($key)) {
                    $typedResult[$key] = $value;
                }
            }

            $this->mergeVars($typedResult);
        } catch (ReflectionException $e) {
            throw new RuntimeException('Errore durante la chiamata dei metodi: '.$e->getMessage());
        }

        return $this->vars;
    }

    /**
     * @param  array<string, mixed>  $vars
     */
    private function setLocalVars(array $vars): void
    {
        if (isset($vars['to']) && is_string($vars['to'])) {
            $this->to = $vars['to'];
        }
        if (isset($vars['from']) && is_string($vars['from'])) {
            $this->from = $vars['from'];
        }
        if (isset($vars['body']) && is_string($vars['body'])) {
            $this->body = $vars['body'];
        }

        $this->mergeVars($vars);
    }

    /**
     * @param  array<string, mixed>  $vars
     */
    private function mergeVars(array $vars): void
    {
        $this->vars = array_merge($this->vars, $vars);
    }
}
