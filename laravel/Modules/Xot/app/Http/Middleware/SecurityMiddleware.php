<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Rate Limiting avanzato
        $this->applyAdvancedRateLimiting($request);

        // 2. Headers di sicurezza
        $response = $next($request);
        Assert::isInstanceOf($response, Response::class);
        $this->addSecurityHeaders($response);

        // 3. Logging sicurezza
        $this->logSecurityEvents($request, $response);

        // 4. Validazione input avanzata
        $this->validateInputs($request);

        // 5. Protezione CSRF avanzata
        $this->enhanceCSRFProtection($request);

        return $response;
    }

    /**
     * Applica rate limiting avanzato.
     */
    private function applyAdvancedRateLimiting(Request $request): void
    {
        $ip = $request->ip() ?? 'unknown';
        $userAgent = $request->userAgent() ?? 'unknown';
        $endpoint = $request->path();

        // Rate limiting per IP
        $this->checkIPRateLimit($ip, $endpoint);

        // Rate limiting per User Agent
        $this->checkUserAgentRateLimit($userAgent, $endpoint);

        // Rate limiting per endpoint specifici
        $this->checkEndpointRateLimit($endpoint, $ip);
    }

    /**
     * Controlla rate limit per IP.
     */
    private function checkIPRateLimit(string $ip, string $endpoint): void
    {
        $key = "rate_limit:ip:{$ip}";
        $limit = $this->getRateLimitForEndpoint($endpoint);

        $current = (int) cache()->get($key, 0);

        if ($current >= $limit) {
            Log::warning('Rate limit exceeded for IP', [
                'ip' => $ip,
                'endpoint' => $endpoint,
                'current' => $current,
                'limit' => $limit,
            ]);

            abort(429, 'Too Many Requests');
        }

        cache()->put($key, $current + 1, 60); // 1 minuto
    }

    /**
     * Controlla rate limit per User Agent.
     */
    private function checkUserAgentRateLimit(string $userAgent, string $endpoint): void
    {
        $key = 'rate_limit:ua:'.md5($userAgent);
        $limit = $this->getRateLimitForEndpoint($endpoint);

        $current = (int) cache()->get($key, 0);

        if ($current >= $limit) {
            Log::warning('Rate limit exceeded for User Agent', [
                'user_agent' => $userAgent,
                'endpoint' => $endpoint,
                'current' => $current,
                'limit' => $limit,
            ]);

            abort(429, 'Too Many Requests');
        }

        cache()->put($key, $current + 1, 60);
    }

    /**
     * Controlla rate limit per endpoint.
     */
    private function checkEndpointRateLimit(string $endpoint, string $ip): void
    {
        $key = "rate_limit:endpoint:{$endpoint}";
        $limit = $this->getRateLimitForEndpoint($endpoint);

        $current = (int) cache()->get($key, 0);

        if ($current >= $limit) {
            Log::warning('Rate limit exceeded for endpoint', [
                'endpoint' => $endpoint,
                'ip' => $ip,
                'current' => $current,
                'limit' => $limit,
            ]);

            abort(429, 'Too Many Requests');
        }

        cache()->put($key, $current + 1, 60);
    }

    /**
     * Ottieni rate limit per endpoint.
     */
    private function getRateLimitForEndpoint(string $endpoint): int
    {
        $limits = [
            'api/tickets' => 100,
            'api/tickets/create' => 20,
            'api/tickets/search' => 50,
            'auth/login' => 5,
            'auth/register' => 3,
            'password/reset' => 2,
        ];

        foreach ($limits as $pattern => $limit) {
            if (str_contains($endpoint, $pattern)) {
                return $limit;
            }
        }

        return 60; // Default limit
    }

    /**
     * Aggiungi header di sicurezza.
     */
    private function addSecurityHeaders(Response $response): void
    {
        // Content Security Policy
        $csp = $this->buildCSP();
        $response->headers->set('Content-Security-Policy', $csp);

        // Strict Transport Security
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

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
    private function buildCSP(): string
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
            'upgrade-insecure-requests',
            'block-all-mixed-content',
        ];

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
            'ambient-light-sensor=()',
            'autoplay=()',
            'battery=()',
            'bluetooth=()',
            'display-capture=()',
            'fullscreen=(self)',
            'gamepad=()',
            'midi=()',
            'notifications=(self)',
            'persistent-storage=(self)',
            'push=()',
            'screen-wake-lock=()',
            'speaker=()',
            'web-share=()',
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
        if ($this->isSuspiciousRequest($request, $response)) {
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
    private function isSuspiciousRequest(Request $request, Response $response): bool
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

            if (! $token || ! hash_equals(session()->token(), (string) $token)) {
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
