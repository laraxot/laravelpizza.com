<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

use function Safe\sys_getloadavg;

/**
 * Middleware per il monitoring delle performance.
 *
 * Monitora automaticamente le performance di ogni richiesta
 * e registra le metriche per l'analisi.
 */
class PerformanceMonitoringMiddleware
{
    public function __construct() {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        // Registra utilizzo memoria iniziale
        $this->recordMemoryUsage();

        // Registra utilizzo CPU
        $this->recordCpuUsage();

        // Esegui la richiesta
        $response = $next($request);

        // Calcola metriche finali
        $endTime = microtime(true);
        $responseTime = ($endTime - $startTime) * 1000; // Converti in millisecondi

        // Registra la richiesta
        Assert::isInstanceOf($response, Response::class);
        $statusCode = $response->getStatusCode();
        $this->recordRequest(
            $request->method(),
            $request->path(),
            $responseTime,
            $statusCode
        );

        // Registra utilizzo memoria finale
        $this->recordMemoryUsage();

        // Aggiungi header di performance
        $this->addPerformanceHeaders($response, $responseTime, $startMemory);

        return $response;
    }

    /**
     * Aggiungi header di performance alla risposta.
     */
    private function addPerformanceHeaders(Response $response, float $responseTime, int $startMemory): void
    {
        $endMemory = memory_get_usage(true);
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // MB

        $response->headers->set('X-Response-Time', round($responseTime, 2).'ms');
        $response->headers->set('X-Memory-Usage', round($memoryUsed, 2).'MB');
        $response->headers->set('X-Peak-Memory', round(memory_get_peak_usage(true) / 1024 / 1024, 2).'MB');
        $queryLog = DB::getQueryLog();
        $queryCount = is_array($queryLog) ? count($queryLog) : 0;
        $response->headers->set('X-DB-Queries', (string) $queryCount);
    }

    /**
     * Registra utilizzo memoria.
     */
    private function recordMemoryUsage(): void
    {
        $memoryUsage = memory_get_usage(true) / 1024 / 1024; // MB
        Cache::increment('memory_usage_total', $memoryUsage);
        Cache::put('memory_usage_current', $memoryUsage, 300); // 5 minuti
    }

    private function recordCpuUsage(): void
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $loadValue = $load[0];
            $cpuUsage = (float) $loadValue * 100;
            Cache::put('cpu_usage_current', $cpuUsage, 300); // 5 minuti
        }
    }

    /**
     * Registra richiesta.
     */
    private function recordRequest(string $method, string $path, float $responseTime, int $statusCode): void
    {
        Cache::increment('total_requests');
        Cache::increment('requests_per_minute');
        // Aggiorna tempi di risposta
        $currentAvg = Cache::get('avg_response_time', 0);
        $totalRequests = Cache::get('total_requests', 1);
        $currentAvgFloat = is_numeric($currentAvg) ? (float) $currentAvg : 0.0;
        $totalRequestsFloat = is_numeric($totalRequests) ? (float) $totalRequests : 1.0;
        $newAvg = (($currentAvgFloat * ($totalRequestsFloat - 1)) + $responseTime) / $totalRequestsFloat;
        Cache::put('avg_response_time', $newAvg, 3600);

        // Aggiorna min/max
        $minTime = Cache::get('min_response_time', $responseTime);
        $maxTime = Cache::get('max_response_time', $responseTime);

        if ($responseTime < $minTime) {
            Cache::put('min_response_time', $responseTime, 3600);
        }
        if ($responseTime > $maxTime) {
            Cache::put('max_response_time', $responseTime, 3600);
        }

        // Registra errori
        if ($statusCode >= 400) {
            Cache::increment('total_errors');
        }
    }
}
