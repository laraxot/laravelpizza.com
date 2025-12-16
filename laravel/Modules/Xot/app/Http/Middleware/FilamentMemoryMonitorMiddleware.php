<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware per monitorare l'uso della memoria nei pannelli Filament.
 * SuperMucca Memory Monitor 🐄
 */
class FilamentMemoryMonitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memoria iniziale
        $memoryStart = memory_get_usage(true);
        $memoryPeakStart = memory_get_peak_usage(true);
        $timeStart = microtime(true);

        // Esegui la richiesta
        $response = $next($request);

        // Memoria finale
        $memoryEnd = memory_get_usage(true);
        $memoryPeakEnd = memory_get_peak_usage(true);
        $timeEnd = microtime(true);

        // Calcola le metriche
        $memoryUsed = $memoryEnd - $memoryStart;
        $memoryPeak = $memoryPeakEnd - $memoryPeakStart;
        $executionTime = ($timeEnd - $timeStart) * 1000; // in millisecondi

        // Converti in MB per leggibilità
        $memoryUsedMB = round($memoryUsed / 1024 / 1024, 2);
        $memoryPeakMB = round($memoryPeak / 1024 / 1024, 2);
        $memoryTotalMB = round($memoryEnd / 1024 / 1024, 2);

        // Determina se è una richiesta Filament admin
        $isFilamentAdmin = $this->isFilamentAdminRequest($request);

        // Log solo per richieste Filament admin o se supera soglie
        if ($isFilamentAdmin || $this->shouldLog($memoryUsedMB, $executionTime)) {
            $this->logMemoryUsage($request, [
                'memory_used_mb' => $memoryUsedMB,
                'memory_peak_mb' => $memoryPeakMB,
                'memory_total_mb' => $memoryTotalMB,
                'execution_time_ms' => round($executionTime, 2),
                'is_filament_admin' => $isFilamentAdmin,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => $request->user()?->id,
            ]);
        }

        // Aggiungi header per debug (solo in development)
        if (config('app.debug') && config('filament_optimization.development.show_memory_stats', false)) {
            $response->headers->set('X-Memory-Used', $memoryUsedMB.'MB');
            $response->headers->set('X-Memory-Peak', $memoryPeakMB.'MB');
            $response->headers->set('X-Execution-Time', round($executionTime, 2).'ms');
        }

        return $response;
    }

    /**
     * Determina se la richiesta è per un pannello admin Filament.
     */
    private function isFilamentAdminRequest(Request $request): bool
    {
        $path = $request->path();

        // Pattern per riconoscere richieste admin Filament
        $adminPatterns = [
            '/admin',
            '/user/admin',
            '/<nome progetto>/admin',
            '/cms/admin',
            '/geo/admin',
            '/notify/admin',
            '/tenant/admin',
        ];

        foreach ($adminPatterns as $pattern) {
            if (str_starts_with($path, ltrim($pattern, '/'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determina se dovremmo loggare questa richiesta.
     */
    private function shouldLog(float $memoryUsedMB, float $executionTimeMs): bool
    {
        // Soglie configurabili
        $memoryThreshold = config('filament_optimization.monitoring.memory_threshold', 50); // MB
        $timeThreshold = config('filament_optimization.monitoring.slow_query_threshold', 1000); // ms

        return $memoryUsedMB > $memoryThreshold || $executionTimeMs > $timeThreshold;
    }

    /**
     * Logga l'uso della memoria.
     *
     * @param  array<string, mixed>  $metrics
     */
    private function logMemoryUsage(Request $request, array $metrics): void
    {
        $logLevel = $this->determineLogLevel($metrics);

        $message = sprintf(
            'Filament Memory Usage: %sMB used, %sMB peak, %sms execution time - %s %s',
            (string) $metrics['memory_used_mb'],
            (string) $metrics['memory_peak_mb'],
            (string) $metrics['execution_time_ms'],
            (string) $metrics['method'],
            (string) $metrics['url']
        );

        // Aggiungi contesto aggiuntivo
        $context = [
            'memory_metrics' => $metrics,
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
        ];

        // Log con il livello appropriato
        Log::log($logLevel, $message, $context);

        // Log separato per metriche ad alta memoria (per alerting)
        if ($metrics['memory_used_mb'] > 100) {
            Log::warning('High memory usage detected in Filament admin', $context);
        }
    }

    /**
     * Determina il livello di log basato sulle metriche.
     *
     * @param  array<string, mixed>  $metrics
     */
    private function determineLogLevel(array $metrics): string
    {
        $memoryMB = $metrics['memory_used_mb'];
        $timeMsec = $metrics['execution_time_ms'];

        // Critico: > 200MB o > 10 secondi
        if ($memoryMB > 200 || $timeMsec > 10000) {
            return 'critical';
        }

        // Errore: > 100MB o > 5 secondi
        if ($memoryMB > 100 || $timeMsec > 5000) {
            return 'error';
        }

        // Warning: > 50MB o > 2 secondi
        if ($memoryMB > 50 || $timeMsec > 2000) {
            return 'warning';
        }

        // Info: tutto il resto
        return 'info';
    }
}
