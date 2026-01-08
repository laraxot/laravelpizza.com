# Esempi Pratici Netfun

## 1. Invio SMS OTP

### 1.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class OtpSmsNotification extends NetfunSmsNotification
{
    /**
     * @var string
     */
    protected string $otp;

    /**
     * @var Carbon
     */
    protected Carbon $expiresAt;

    /**
     * @param string $otp
     * @param int $minutes
     */
    public function __construct(string $otp, int $minutes = 5)
    {
        $this->otp = $otp;
        $this->expiresAt = now()->addMinutes($minutes);

        parent::__construct(
            message: "Il tuo codice OTP è: {$otp}. Valido fino alle {$this->expiresAt->format('H:i')}.",
            sender: '<nome progetto>'
        );
    }

    /**
     * Get the OTP
     *
     * @return string
     */
    public function getOtp(): string
    {
        return $this->otp;
    }

    /**
     * Get the expiration time
     *
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 1.2 Utilizzo
```php
// Nel controller
public function sendOtp(User $user)
{
    try {
        // Genera OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Salva OTP nel database con scadenza
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);
        
        // Invia SMS
        $user->notify(new OtpSmsNotification($otp));

        return response()->json([
            'message' => 'OTP inviato con successo',
            'expires_at' => now()->addMinutes(5)
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio OTP', [
            'user_id' => $user->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio dell\'OTP'
        ], 500);
    }
}

// Verifica OTP
public function verifyOtp(Request $request, User $user)
{
    $request->validate([
        'otp' => 'required|string|size:6'
    ]);

    if ($user->otp !== $request->otp) {
        return response()->json([
            'message' => 'OTP non valido'
        ], 400);
    }

    if ($user->otp_expires_at->isPast()) {
        return response()->json([
            'message' => 'OTP scaduto'
        ], 400);
    }

    // OTP valido, resetta i campi
    $user->update([
        'otp' => null,
        'otp_expires_at' => null
    ]);

    return response()->json([
        'message' => 'OTP verificato con successo'
    ]);
}
```

## 2. Invio SMS Promemoria

### 2.1 Notification Class
```php
<?php

namespace Modules\Notify\Notifications;

use Illuminate\Support\Carbon;
use Modules\Notify\App\Data\NetfunSmsRequestData;

class AppointmentReminderNotification extends NetfunSmsNotification
{
    /**
     * @var Carbon
     */
    protected Carbon $appointmentDate;

    /**
     * @var string
     */
    protected string $doctorName;

    /**
     * @var string
     */
    protected string $location;

    /**
     * @var string|null
     */
    protected ?string $notes;

    /**
     * @param Carbon $appointmentDate
     * @param string $doctorName
     * @param string $location
     * @param string|null $notes
     */
    public function __construct(
        Carbon $appointmentDate,
        string $doctorName,
        string $location,
        ?string $notes = null
    ) {
        $this->appointmentDate = $appointmentDate;
        $this->doctorName = $doctorName;
        $this->location = $location;
        $this->notes = $notes;

        $message = "Promemoria: Hai un appuntamento con {$doctorName} il {$appointmentDate->format('d/m/Y H:i')}";
        $message .= " presso {$location}.";
        
        if ($notes) {
            $message .= " Note: {$notes}";
        }

        parent::__construct(
            message: $message,
            sender: '<nome progetto>'
        );
    }

    /**
     * Get the Netfun representation of the notification.
     *
     * @param mixed $notifiable
     * @return NetfunSmsRequestData
     */
    public function toNetfun($notifiable): NetfunSmsRequestData
    {
        return new NetfunSmsRequestData(
            to: $notifiable->phone_number,
            text: $this->message,
            from: $this->sender
        );
    }
}
```

### 2.2 Utilizzo
```php
// Nel controller
public function sendReminder(Appointment $appointment)
{
    try {
        // Verifica se l'appuntamento è nel futuro
        if ($appointment->date->isPast()) {
            throw new \Exception('Impossibile inviare promemoria per un appuntamento passato');
        }

        // Verifica se il promemoria è già stato inviato
        if ($appointment->reminder_sent_at) {
            throw new \Exception('Promemoria già inviato');
        }

        // Invia il promemoria
        $appointment->patient->notify(
            new AppointmentReminderNotification(
                appointmentDate: $appointment->date,
                doctorName: $appointment->doctor->name,
                location: $appointment->location,
                notes: $appointment->notes
            )
        );

        // Aggiorna lo stato del promemoria
        $appointment->update([
            'reminder_sent_at' => now()
        ]);

        return response()->json([
            'message' => 'Promemoria inviato con successo'
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio promemoria', [
            'appointment_id' => $appointment->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio del promemoria'
        ], 500);
    }
}
```

## 3. Invio SMS Massivo

### 3.1 Action
```php
<?php

namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsRequestData;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendBulkSmsAction
{
    use QueueableAction;

    /**
     * @var Collection
     */
    protected Collection $users;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var string
     */
    protected string $sender;

    /**
     * @var int
     */
    protected int $batchSize;

    /**
     * @var int
     */
    protected int $delayBetweenBatches;

    /**
     * @param Collection $users
     * @param string $message
     * @param string $sender
     * @param int $batchSize
     * @param int $delayBetweenBatches
     */
    public function __construct(
        Collection $users,
        string $message,
        string $sender,
        int $batchSize = 100,
        int $delayBetweenBatches = 1
    ) {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
        $this->batchSize = $batchSize;
        $this->delayBetweenBatches = $delayBetweenBatches;
    }

    /**
     * Esegue l'azione di invio SMS massivo
     *
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $results = [
            'total' => $this->users->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        try {
            // Prepara il batch di messaggi
            $messages = $this->users->map(function ($user) {
                return new NetfunSmsRequestData(
                    to: $user->phone_number,
                    text: $this->message,
                    from: $this->sender
                );
            })->chunk($this->batchSize);

            // Invia ogni batch
            foreach ($messages as $batch) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . config('notify.netfun.api_key'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->timeout(30)->post(config('notify.netfun.endpoint'), [
                        'messages' => $batch->map(fn($message) => $message->toArray())->values()->all()
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Errore HTTP: ' . $response->status());
                    }

                    $result = NetfunSmsResponseData::fromArray($response->json());
                    
                    if ($result->status !== 'success') {
                        throw new \Exception($result->error ?? 'Errore sconosciuto');
                    }

                    $results['success'] += $batch->count();

                } catch (\Exception $e) {
                    $results['failed'] += $batch->count();
                    $results['errors'][] = [
                        'batch_size' => $batch->count(),
                        'error' => $e->getMessage()
                    ];

                    Log::error('Errore invio batch SMS', [
                        'error' => $e->getMessage(),
                        'batch_size' => $batch->count()
                    ]);
                }

                // Attendi tra i batch
                if ($this->delayBetweenBatches > 0) {
                    sleep($this->delayBetweenBatches);
                }
            }

            return $results;

        } catch (\Exception $e) {
            Log::error('Eccezione invio SMS massivo', [
                'error' => $e->getMessage(),
                'total_users' => $this->users->count()
            ]);

            throw $e;
        }
    }
}
```

### 3.2 Utilizzo
```php
// Nel controller
public function sendBulkSms(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:160',
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id'
    ]);

    try {
        $users = User::whereIn('id', $request->user_ids)
            ->where('consent_sms', true)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Nessun utente valido trovato'
            ], 400);
        }

        $results = SendBulkSmsAction::make(
            users: $users,
            message: $request->message,
            sender: '<nome progetto>',
            batchSize: 100,
            delayBetweenBatches: 1
        )->onQueue('bulk-sms')->execute();

        return response()->json([
            'message' => 'Invio SMS massivo completato',
            'results' => $results
        ]);

    } catch (\Exception $e) {
        Log::error('Errore invio SMS massivo', [
            'error' => $e->getMessage(),
            'user_ids' => $request->user_ids
        ]);

        return response()->json([
            'message' => 'Errore nell\'invio degli SMS'
        ], 500);
    }
}
```

## 4. Gestione Errori Avanzata

### 4.1 Action con Retry e Circuit Breaker
```php
<?php

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithRetryAction extends SendNetfunSmsAction
{
    /**
     * @var int
     */
    protected int $maxRetries;

    /**
     * @var int
     */
    protected int $retryDelay;

    /**
     * @var int
     */
    protected int $circuitBreakerThreshold;

    /**
     * @var int
     */
    protected int $circuitBreakerTimeout;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        
        $this->maxRetries = config('notify.netfun.max_retries', 3);
        $this->retryDelay = config('notify.netfun.retry_delay', 1);
        $this->circuitBreakerThreshold = config('notify.netfun.circuit_breaker.threshold', 5);
        $this->circuitBreakerTimeout = config('notify.netfun.circuit_breaker.timeout', 60);
    }

    /**
     * Esegue l'azione con retry e circuit breaker
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        // Verifica circuit breaker
        if ($this->isCircuitBreakerOpen()) {
            throw new \Exception('Circuit breaker is open');
        }

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->maxRetries) {
            try {
                $result = parent::execute();
                
                // Reset circuit breaker on success
                $this->resetCircuitBreaker();
                
                return $result;

            } catch (\Exception $e) {
                $lastException = $e;
                $attempts++;

                if ($attempts === $this->maxRetries) {
                    // Increment circuit breaker counter
                    $this->incrementCircuitBreaker();
                    
                    Log::error('Tentativi esauriti per invio SMS', [
                        'to' => $this->to,
                        'error' => $e->getMessage(),
                        'attempts' => $attempts
                    ]);
                    
                    throw $e;
                }

                Log::warning('Tentativo fallito, riprovo...', [
                    'attempt' => $attempts,
                    'error' => $e->getMessage()
                ]);

                sleep($this->retryDelay);
            }
        }

        throw $lastException;
    }

    /**
     * Verifica se il circuit breaker è aperto
     *
     * @return bool
     */
    protected function isCircuitBreakerOpen(): bool
    {
        return Cache::get('netfun_circuit_breaker', false);
    }

    /**
     * Incrementa il contatore del circuit breaker
     */
    protected function incrementCircuitBreaker(): void
    {
        $key = 'netfun_circuit_breaker_failures';
        $failures = Cache::get($key, 0) + 1;
        
        Cache::put($key, $failures, $this->circuitBreakerTimeout);

        if ($failures >= $this->circuitBreakerThreshold) {
            Cache::put('netfun_circuit_breaker', true, $this->circuitBreakerTimeout);
        }
    }

    /**
     * Resetta il circuit breaker
     */
    protected function resetCircuitBreaker(): void
    {
        Cache::forget('netfun_circuit_breaker');
        Cache::forget('netfun_circuit_breaker_failures');
    }
}
```

## 5. Monitoraggio Avanzato

### 5.1 Action con Metriche e Prometheus
```php
<?php

namespace Modules\Notify\Actions;

use Prometheus\CollectorRegistry;
use Modules\Notify\App\Data\NetfunSmsResponseData;

class SendNetfunSmsWithMetricsAction extends SendNetfunSmsAction
{
    /**
     * @var CollectorRegistry
     */
    protected CollectorRegistry $prometheus;

    public function __construct(
        string $to,
        string $message,
        string $sender
    ) {
        parent::__construct($to, $message, $sender);
        $this->prometheus = app(CollectorRegistry::class);
    }

    /**
     * Esegue l'azione con metriche
     *
     * @return NetfunSmsResponseData
     * @throws \Exception
     */
    public function execute(): NetfunSmsResponseData
    {
        $startTime = microtime(true);
        
        try {
            $result = parent::execute();
            
            // Registra metriche di successo
            $this->recordMetrics(true, microtime(true) - $startTime, [
                'message_id' => $result->message_id,
                'status' => $result->status
            ]);
            
            return $result;

        } catch (\Exception $e) {
            // Registra metriche di errore
            $this->recordMetrics(false, microtime(true) - $startTime, [
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Registra le metriche
     *
     * @param bool $success
     * @param float $duration
     * @param array $context
     */
    protected function recordMetrics(bool $success, float $duration, array $context = []): void
    {
        // Incrementa il contatore totale
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_total',
            'Total number of SMS sent'
        )->inc();

        // Incrementa il contatore di successo/errore
        $this->prometheus->getOrRegisterCounter(
            'netfun',
            'sms_' . ($success ? 'success' : 'error'),
            'Number of successful/failed SMS'
        )->inc();

        // Registra la durata
        $this->prometheus->getOrRegisterHistogram(
            'netfun',
            'sms_duration_seconds',
            'SMS sending duration in seconds'
        )->observe($duration);

        // Log dettagliato
        Log::info('Metriche SMS', array_merge([
            'success' => $success,
            'duration' => $duration,
            'to' => $this->to,
            'sender' => $this->sender
        ], $context));
    }
}
```

## 6. Esempi di Test

### 6.1 Test Unitario
```php
<?php

namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Actions\SendNetfunSmsAction;
use Modules\Notify\App\Data\NetfunSmsResponseData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NetfunSmsActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_sms_sent_with_valid_data()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $result = $action->execute();

        $this->assertInstanceOf(NetfunSmsResponseData::class, $result);
        $this->assertEquals('success', $result->status);
        $this->assertEquals('123456', $result->message_id);
        
        Http::assertSent(function ($request) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   $request['messages'][0]['text'] == 'Test message' &&
                   $request['messages'][0]['from'] == 'TEST';
        });
    }

    public function test_sms_fails_with_invalid_number()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'error',
                'error' => 'Invalid phone number'
            ], 400)
        ]);

        $this->expectException(\Exception::class);

        $action = SendNetfunSmsAction::make(
            to: 'invalid',
            message: 'Test message',
            sender: 'TEST'
        );

        $action->execute();
    }

    public function test_rate_limiting()
    {
        $action = SendNetfunSmsAction::make(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il raggiungimento del rate limit
        Cache::put('netfun_rate_limit_' . date('YmdHis'), 100, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rate limit exceeded');

        $action->execute();
    }

    public function test_circuit_breaker()
    {
        $action = new SendNetfunSmsWithRetryAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        // Simula il circuit breaker aperto
        Cache::put('netfun_circuit_breaker', true, 60);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Circuit breaker is open');

        $action->execute();
    }
}
```

### 6.2 Test di Integrazione
```php
<?php

namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;

class NetfunNotificationIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Cache::flush();
    }

    public function test_otp_notification_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => true
        ]);

        $otp = '123456';
        
        $user->notify(new OtpSmsNotification($otp));

        Http::assertSent(function ($request) use ($otp) {
            return $request->url() == config('notify.netfun.endpoint') &&
                   $request['messages'][0]['to'] == '+393331234567' &&
                   str_contains($request['messages'][0]['text'], $otp);
        });

        Queue::assertPushed(SendNetfunSmsAction::class);
    }

    public function test_user_cannot_receive_sms_without_consent()
    {
        $user = User::factory()->create([
            'phone_number' => '+393331234567',
            'consent_sms' => false
        ]);

        $user->notify(new NetfunSmsNotification('Test message'));

        Http::assertNothingSent();
        Queue::assertNothingPushed();
    }

    public function test_bulk_sms_sent()
    {
        Http::fake([
            config('notify.netfun.endpoint') => Http::response([
                'status' => 'success',
                'message_id' => '123456'
            ], 200)
        ]);

        $users = User::factory()->count(3)->create([
            'consent_sms' => true
        ]);

        $results = SendBulkSmsAction::make(
            users: $users,
            message: 'Test message',
            sender: 'TEST'
        )->execute();

        $this->assertEquals(3, $results['total']);
        $this->assertEquals(3, $results['success']);
        $this->assertEquals(0, $results['failed']);

        Http::assertSentCount(1);
    }

    public function test_metrics_recorded()
    {
        $action = new SendNetfunSmsWithMetricsAction(
            to: '+393331234567',
            message: 'Test message',
            sender: 'TEST'
        );

        $metrics = $action->recordMetrics(true, 0.5, [
            'message_id' => '123456'
        ]);

        $this->assertTrue($metrics['success']);
        $this->assertEquals(0.5, $metrics['duration']);
        $this->assertEquals('123456', $metrics['message_id']);
    }
}
```

## 7. Collegamenti Utili

- [Documentazione Netfun](https://www.netfunitalia.it/)
- [API Netfun](https://v2.smsviainternet.it/api/rest/v1/)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Cache](https://laravel.com/docs/cache)
- [Prometheus PHP Client](https://github.com/promphp/prometheus_client_php) 
