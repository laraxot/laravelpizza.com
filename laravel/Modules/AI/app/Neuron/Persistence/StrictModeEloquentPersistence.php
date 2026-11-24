<?php

declare(strict_types=1);

namespace Modules\AI\Neuron\Persistence;

use Closure;
use Illuminate\Database\MySqlConnection;
use NeuronAI\Workflow\Persistence\EloquentPersistence;

/**
 * EloquentPersistence di neuron-ai con lo strict mode MySQL acceso solo durante le sue scritture.
 *
 * neuron rifiuta di scrivere un run in pausa se la sessione MySQL non e' in strict mode
 * (un valore base64 troncato in silenzio renderebbe il run irrecuperabile). Le connessioni
 * del tenant hanno `strict => false` per il resto dell'applicazione, quindi qui lo strict
 * mode si accende per la durata della scrittura e poi si rimette la modalita' di prima:
 * la garanzia di neuron vale davvero, e le altre query della richiesta non cambiano.
 *
 * @see Modules/AI/docs/agents.md#binding-e-strict-mode-mysql
 */
final class StrictModeEloquentPersistence extends EloquentPersistence
{
    private const string STRICT_MODE = 'STRICT_TRANS_TABLES';

    /** @see Modules/AI/docs/agents.md#binding-e-strict-mode-mysql */
    protected function atomically(Closure $operation): bool
    {
        $connection = (new $this->modelClass)->getConnection();
        if (! $connection instanceof MySqlConnection) {
            return parent::atomically($operation);
        }

        $previous = $connection->scalar('SELECT @@SESSION.sql_mode');
        $previous = is_string($previous) ? $previous : '';
        if (str_contains($previous, 'STRICT_')) {
            return parent::atomically($operation);
        }

        $connection->statement('SET SESSION sql_mode = ?', [ltrim($previous.','.self::STRICT_MODE, ',')]);

        try {
            return parent::atomically($operation);
        } finally {
            $connection->statement('SET SESSION sql_mode = ?', [$previous]);
        }
    }
}
