<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\preg_match;

/**
 * Middleware di sicurezza avanzato.
 *
 * Implementa multiple layer di sicurezza per proteggere
 * l'applicazione da attacchi comuni e migliorare la sicurezza.
 */
class SecurityMiddleware
{
    /** Richieste al minuto per IP (pagine, Livewire, API). */
    private const int DEFAULT_LIMIT = 300;

    /** Invii al minuto per IP verso indirizzi sensibili. */
    private const array STRICT_LIMITS = [
        'api/tickets/create' => 20,
        'api/tickets/search' => 50,
        'api/tickets' => 100,
        'auth/login' => 10,
        'auth/register' => 5,
        'password/reset' => 5,
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // 1. Rate Limiting avanzato
        $this->applyAdvancedRateLimiting($request);

        // 2. Validazione input e CSRF PRIMA di eseguire la richiesta.
        // Eseguiti dopo $next() erano inutili come protezione (l'azione era già avvenuta)
        // e rompevano il login: Filament rigenera sessione e token CSRF all'accesso,
        // quindi il confronto a posteriori falliva sempre con 419 "Page Expired".
        // NON spostarli dopo $next(): vedi Modules/Xot/docs/wiki/decisions/security-middleware-csrf-order.md
        $this->validateInputs($request);
        $this->enhanceCSRFProtection($request);

        // 3. Headers di sicurezza
        $response = $next($request);
        Assert::isInstanceOf($response, Response::class);
        $this->addSecurityHeaders($response, $request);

        // 4. Logging sicurezza
        $this->logSecurityEvents($request, $response);

        return $response;
    }

    /**
     * Rate limiting per IP e per gruppo di indirizzi (finestra fissa di 60 secondi).
     *
     * Prima c'erano tre contatori che bloccavano il sito intero (ADR security-middleware-rate-limit):
     * - per IP su tutte le pagine, ma con il limite dell'indirizzo richiesto: dopo 5 pagine
     *   qualsiasi, la pagina di accesso (limite 5) rispondeva 429;
     * - per User-Agent e per indirizzo, condivisi tra tutti i visitatori: 5 accessi al minuto
     *   in tutto il mondo bastavano a bloccare il login per chiunque;
     * - `cache()->put(+1, 60)` rinnovava la scadenza a ogni richiesta: il blocco non finiva mai.
     */
    private function applyAdvancedRateLimiting(Request $request): void
    {
        $this->checkIPRateLimit($request->ip() ?? 'unknown', $request->path(), $request->isMethodSafe());
    }

    /**
     * Controlla rate limit per IP sul gruppo dell'indirizzo (login, registrazione, … o "default").
     * I limiti stretti valgono solo per gli invii (POST, PUT, …): aprire la pagina non conta.
     */
    private function checkIPRateLimit(string $ip, string $endpoint, bool $safeMethod = true): void
    {
        [$bucket, $limit] = $this->getRateLimitBucket($endpoint, $safeMethod);
        $key = "security:rate_limit:{$bucket}:{$ip}";

        if (RateLimiter::tooManyAttempts($key, $limit)) {
            Log::warning('Rate limit exceeded for IP', [
                'ip' => $ip,
                'endpoint' => $endpoint,
                'bucket' => $bucket,
                'limit' => $limit,
            ]);

            abort(429, 'Too Many Requests');
        }

        RateLimiter::hit($key, 60);
    }

    /**
     * @return array{0: string, 1: int} gruppo e limite al minuto
     */
    private function getRateLimitBucket(string $endpoint, bool $safeMethod): array
    {
        if (! $safeMethod) {
            foreach (self::STRICT_LIMITS as $pattern => $limit) {
                if (str_contains($endpoint, $pattern)) {
                    return [$pattern, $limit];
                }
            }
        }

        return ['default', self::DEFAULT_LIMIT];
    }

    /**
     * Aggiungi header di sicurezza.
     */
    private function addSecurityHeaders(Response $response, Request $request): void
    {
        $secure = $request->secure();

        // Content Security Policy
        $csp = $this->buildCSP($secure);
        $response->headers->set('Content-Security-Policy', $csp);

        // Strict Transport Security — solo su connessioni HTTPS: su HTTP il browser
        // lo ignorerebbe, ma in ambienti proxy/browser aggressivi puo' comunque
        // influenzare l'upgrade forzato delle richieste.
        if ($secure) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // X-Frame-Options
        $response->headers->set('X-Frame-Options', 'DENY');

        // X-Content-Type-Options
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy
        $permissions = $this->buildPermissionsPolicy();
        $response->headers->set('Permissions-Policy', $permissions);

        // Cross-Origin Policies
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
    }

    /**
     * Costruisci Content Security Policy.
     */
    private function buildCSP(bool $secure = false): string
    {
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net",
            "img-src 'self' data: https: blob:",
            "media-src 'self' blob:",
            "connect-src 'self' https: wss:",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ];

        // Solo quando la risposta e' servita in HTTPS: altrimenti il browser
        // aggiornerebbe le sotto-risorse a https:// e il server HTTP locale
        // risponderebbe con connessione chiusa (ERR_CONNECTION_CLOSED).
        if ($secure) {
            $csp[] = 'upgrade-insecure-requests';
            $csp[] = 'block-all-mixed-content';
        }

        return implode('; ', $csp);
    }

    /**
     * Costruisci Permissions Policy.
     */
    private function buildPermissionsPolicy(): string
    {
        $permissions = [
            'camera=()',
            'microphone=()',
            'geolocation=(self)',
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
            'autoplay=()',
            'display-capture=()',
            'fullscreen=(self)',
            'gamepad=()',
            'midi=()',
            'screen-wake-lock=()',
            'xr-spatial-tracking=()',
        ];

        return implode(', ', $permissions);
    }

    /**
     * Log eventi di sicurezza.
     */
    private function logSecurityEvents(Request $request, Response $response): void
    {
        $securityData = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'status_code' => $response->getStatusCode(),
            'timestamp' => now(),
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'referer' => $request->header('referer'),
            'x_forwarded_for' => $request->header('x-forwarded-for'),
            'x_real_ip' => $request->header('x-real-ip'),
        ];

        // Log solo eventi sospetti
        if ($this->isSuspiciousRequest($request)) {
            Log::warning('Suspicious request detected', $securityData);
        }

        // Log tentativi di accesso falliti
        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            Log::warning('Failed access attempt', $securityData);
        }

        // Log errori server
        if ($response->getStatusCode() >= 500) {
            Log::error('Server error', $securityData);
        }
    }

    /**
     * Verifica se la richiesta è sospetta.
     */
    private function isSuspiciousRequest(Request $request): bool
    {
        // Pattern sospetti negli URL
        $suspiciousPatterns = [
            '/\.\.\//',           // Directory traversal
            '/<script/i',         // XSS attempts
            '/union\s+select/i',  // SQL injection
            '/eval\s*\(/i',       // Code injection
            '/base64_decode/i',   // PHP code injection
            '/system\s*\(/i',     // Command injection
            '/exec\s*\(/i',       // Command injection
            '/shell_exec/i',      // Command injection
        ];

        $url = $request->fullUrl();
        $input = $request->all();

        foreach ($suspiciousPatterns as $pattern) {
            $jsonInput = json_encode($input);
            if (preg_match($pattern, $url) || preg_match($pattern, $jsonInput)) {
                return true;
            }
        }

        // User Agent sospetti
        $userAgent = $request->userAgent();
        $suspiciousUserAgents = [
            'sqlmap',
            'nikto',
            'nmap',
            'masscan',
            'zap',
            'burp',
            'w3af',
            'acunetix',
            'nessus',
            'openvas',
        ];

        foreach ($suspiciousUserAgents as $suspicious) {
            if ($userAgent !== null && stripos($userAgent, $suspicious) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Valida input avanzata.
     */
    private function validateInputs(Request $request): void
    {
        $inputs = $request->all();

        foreach ($inputs as $key => $value) {
            if ($value !== null && is_string($value)) {
                $this->validateStringInput($key, $value);
            } elseif (is_array($value)) {
                $this->validateArrayInput($key, $value);
            }
        }
    }

    /**
     * Valida input stringa.
     */
    private function validateStringInput(string $key, string $value): void
    {
        // Controlla lunghezza eccessiva
        if (strlen($value) > 10000) {
            Log::warning('Suspicious input length', [
                'key' => $key,
                'length' => strlen($value),
            ]);
            abort(400, 'Input too long');
        }

        // Controlla caratteri sospetti
        $suspiciousChars = ['<', '>', '"', "'", '&', ';', '(', ')', '{', '}', '[', ']'];
        $suspiciousCount = 0;

        foreach ($suspiciousChars as $char) {
            $suspiciousCount += substr_count($value, $char);
        }

        if ($suspiciousCount > 10) {
            Log::warning('Suspicious input characters', [
                'key' => $key,
                'suspicious_count' => $suspiciousCount,
            ]);
        }
    }

    /**
     * Valida input array.
     *
     * @param  array<array-key, mixed>  $value
     */
    private function validateArrayInput(string $key, array $value): void
    {
        // Controlla profondità array
        if ($this->getArrayDepth($value) > 10) {
            Log::warning('Suspicious array depth', [
                'key' => $key,
                'depth' => $this->getArrayDepth($value),
            ]);
            abort(400, 'Array too deep');
        }

        // Controlla dimensione array
        if (count($value) > 1000) {
            Log::warning('Suspicious array size', [
                'key' => $key,
                'size' => count($value),
            ]);
            abort(400, 'Array too large');
        }
    }

    /**
     * Ottieni profondità array.
     *
     * @param  array<array-key, mixed>  $array
     */
    private function getArrayDepth(array $array): int
    {
        $maxDepth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->getArrayDepth($value) + 1;
                if ($depth > $maxDepth) {
                    $maxDepth = $depth;
                }
            }
        }

        return $maxDepth;
    }

    /**
     * Migliora protezione CSRF.
     */
    private function enhanceCSRFProtection(Request $request): void
    {
        // Verifica token CSRF per richieste POST/PUT/DELETE
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $token = $request->header('X-CSRF-TOKEN') ?: $request->input('_token');

            if (! $token || ! hash_equals(session()->token(), SafeStringCastAction::cast($token))) {
                Log::warning('CSRF token mismatch', [
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'user_id' => auth()->id(),
                ]);

                abort(419, 'CSRF token mismatch');
            }
        }

        // Verifica referer per richieste sensibili
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $referer = $request->header('referer');
            $host = $request->getHost();

            if ($referer && ! str_starts_with($referer, $request->getSchemeAndHttpHost())) {
                Log::warning('Suspicious referer', [
                    'ip' => $request->ip(),
                    'referer' => $referer,
                    'host' => $host,
                ]);

                abort(403, 'Invalid referer');
            }
        }
    }
}
