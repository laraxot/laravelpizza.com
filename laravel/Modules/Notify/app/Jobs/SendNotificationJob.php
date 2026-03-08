<?php

declare(strict_types=1);

namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Actions\SendNotificationAction;
use Throwable;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public $tries;

    /**
     * Timeout del job in secondi.
     *
     * @var int
     */
    public $timeout;

    /**
     * Crea una nuova istanza del job.
     *
     * @param  Model  $recipient  Il destinatario della notifica
     * @param  string  $templateCode  Il codice del template da utilizzare
     * @param  array<string, mixed>  $data  I dati per compilare il template
     * @param  array<int, string>  $channels  I canali da utilizzare
     * @param  array<string, mixed>  $options  Opzioni aggiuntive per l'invio
     */
    public function __construct(
        protected Model $recipient,
        protected string $templateCode,
        protected array $data = [],
        protected array $channels = [],
        protected array $options = [],
    ) {
        $triesConfig = config('notify.queue.tries', 3);
        // @var mixed tries = is_numeric($triesConfig;

        $timeoutConfig = config('notify.queue.retry_after', 60);
        // @var mixed timeout = is_numeric($timeoutConfig;

        $queueConfig = config('notify.queue.queue', 'notifications');
        // @var mixed onQueue(is_string($queueConfig;
    }

    /**
     * Esegue il job.
     */
    public function handle(SendNotificationAction $action): void
    {
        $action->execute(// @var mixed recipient, $this->templateCode, $this->data, $this->channels, $this->options;
    }

    /**
     * Gestisce un fallimento del job.
     */
    public function failed(Throwable $exception): void
    {
        // Log dell'errore
        logger()->error('Errore nell\'invio della notifica', [
            'recipient_type' => get_class(// @var mixed recipient
            'recipient_id' => // @var mixed recipient->getKey(
            'template_code' => // @var mixed templateCode,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
