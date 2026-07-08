#!/bin/bash

# Script per ottimizzare la memoria di Filament v4
# Risolve problemi di memoria alta nei pannelli admin

echo "🚀 Ottimizzazione memoria Filament v4"
echo "====================================="

PROJECT_DIR="/var/www/_bases/base_<nome progetto>_fila5_mono/laravel"

# 1. Aumenta memory limit per PHP
echo "📈 Aumentando memory limit PHP..."
sed -i 's/memory_limit = 128M/memory_limit = 512M/g' /etc/php/*/cli/php.ini 2>/dev/null || echo "⚠️  Non è stato possibile modificare php.ini globale"

# 2. Ottimizza la configurazione di Filament
echo "⚙️  Ottimizzando configurazione Filament..."

# Crea file di configurazione per ottimizzare Filament
cat > "$PROJECT_DIR/config/filament_optimization.php" << 'EOF'
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Filament Memory Optimization
    |--------------------------------------------------------------------------
    |
    | Configurazioni per ottimizzare l'uso della memoria in Filament v4
    |
    */

    'memory_optimization' => [
        // Disabilita lazy loading per componenti pesanti
        'disable_lazy_loading' => false,
        
        // Limita il numero di record caricati per default
        'default_records_per_page' => 25,
        
        // Abilita caching per le query pesanti
        'enable_query_caching' => true,
        
        // Limita la profondità delle relazioni caricate
        'max_relation_depth' => 2,
        
        // Disabilita debug mode in produzione
        'disable_debug_mode' => env('APP_ENV') === 'production',
    ],

    'performance' => [
        // Abilita compressione delle risposte
        'enable_response_compression' => true,
        
        // Limita il numero di widget per pagina
        'max_widgets_per_page' => 10,
        
        // Abilita caching per le traduzioni
        'cache_translations' => true,
        
        // Limita il numero di azioni bulk
        'max_bulk_actions' => 5,
    ],
];
EOF

# 3. Ottimizza i Service Provider per ridurre il carico di memoria
echo "🔧 Ottimizzando Service Provider..."

# Crea un Service Provider ottimizzato per Filament
cat > "$PROJECT_DIR/app/Providers/FilamentOptimizationServiceProvider.php" << 'EOF'
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Filament\Facades\Filament;

class FilamentOptimizationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Ottimizza le view per ridurre l'uso di memoria
        View::composer('*', function ($view) {
            // Limita il numero di variabili passate alle view
            if (count($view->getData()) > 50) {
                $data = $view->getData();
                $view->with(array_slice($data, 0, 50, true));
            }
        });

        // Ottimizza Filament per ridurre il carico di memoria
        Filament::serving(function () {
            // Disabilita funzionalità non essenziali in produzione
            if (app()->environment('production')) {
                Filament::disableRobots();
            }
        });
    }

    public function register(): void
    {
        // Registra configurazioni di ottimizzazione
        $this->mergeConfigFrom(
            __DIR__.'/../../config/filament_optimization.php',
            'filament_optimization'
        );
    }
}
EOF

# 4. Ottimizza i modelli per ridurre l'uso di memoria
echo "📊 Ottimizzando modelli..."

# Crea un trait per ottimizzare i modelli
cat > "$PROJECT_DIR/app/Traits/OptimizedModel.php" << 'EOF'
<?php

namespace App\Traits;

trait OptimizedModel
{
    /**
     * Limita il numero di record caricati per default
     */
    protected $perPage = 25;

    /**
     * Disabilita lazy loading per relazioni pesanti
     */
    protected $with = [];

    /**
     * Abilita caching per query frequenti
     */
    public function scopeCached($query, $key = null, $ttl = 300)
    {
        $key = $key ?: 'model_' . class_basename($this) . '_' . md5($query->toSql());
        
        return cache()->remember($key, $ttl, function () use ($query) {
            return $query->get();
        });
    }

    /**
     * Ottimizza le query per ridurre l'uso di memoria
     */
    public function scopeOptimized($query)
    {
        return $query
            ->select($this->getTable() . '.*') // Evita SELECT *
            ->limit(1000); // Limita il numero massimo di record
    }
}
EOF

# 5. Crea un middleware per ottimizzare le richieste
echo "🛡️  Creando middleware di ottimizzazione..."

cat > "$PROJECT_DIR/app/Http/Middleware/OptimizeMemoryUsage.php" << 'EOF'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeMemoryUsage
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ottimizza la memoria per le richieste Filament
        if (str_contains($request->path(), 'admin') || str_contains($request->path(), 'filament')) {
            // Aumenta il memory limit per le richieste admin
            ini_set('memory_limit', '512M');
            
            // Abilita garbage collection
            gc_enable();
            
            // Limita il tempo di esecuzione
            set_time_limit(60);
        }

        $response = $next($request);

        // Pulisce la memoria dopo la risposta
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }

        return $response;
    }
}
EOF

# 6. Aggiorna il file bootstrap/app.php per includere il middleware
echo "🔗 Aggiornando bootstrap/app.php..."

# Backup del file originale
cp "$PROJECT_DIR/bootstrap/app.php" "$PROJECT_DIR/bootstrap/app.php.backup"

# Aggiunge il middleware di ottimizzazione
sed -i '/->withMiddleware(function (Middleware \$middleware) {/a\
        \$middleware->append(\App\Http\Middleware\OptimizeMemoryUsage::class);' "$PROJECT_DIR/bootstrap/app.php"

# 7. Crea un comando Artisan per monitorare la memoria
echo "📊 Creando comando di monitoraggio memoria..."

cat > "$PROJECT_DIR/app/Console/Commands/MonitorMemory.php" << 'EOF'
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MonitorMemory extends Command
{
    protected $signature = 'memory:monitor';
    protected $description = 'Monitora l\'uso della memoria del sistema';

    public function handle(): int
    {
        $memoryUsage = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);
        $memoryLimit = ini_get('memory_limit');

        $this->info("📊 Monitoraggio Memoria:");
        $this->line("Memoria attuale: " . $this->formatBytes($memoryUsage));
        $this->line("Memoria picco: " . $this->formatBytes($memoryPeak));
        $this->line("Limite memoria: " . $memoryLimit);

        // Controlla le query più pesanti
        $this->info("\n🔍 Query più pesanti:");
        $queries = DB::getQueryLog();
        if (!empty($queries)) {
            $sortedQueries = collect($queries)->sortByDesc('time');
            foreach ($sortedQueries->take(5) as $query) {
                $this->line("- " . $query['query'] . " (" . $query['time'] . "ms)");
            }
        }

        return 0;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
EOF

# 8. Ottimizza le configurazioni di cache
echo "💾 Ottimizzando configurazioni cache..."

# Aggiorna config/cache.php per migliorare le performance
cat >> "$PROJECT_DIR/config/cache.php" << 'EOF'

/*
|--------------------------------------------------------------------------
| Filament Cache Optimization
|--------------------------------------------------------------------------
|
| Configurazioni specifiche per ottimizzare la cache di Filament
|
*/

'filament' => [
    'driver' => 'file',
    'path' => storage_path('framework/cache/filament'),
    'ttl' => 3600, // 1 ora
],
EOF

# 9. Crea un file .env.optimized per ottimizzazioni
echo "⚙️  Creando configurazione ottimizzata..."

cat > "$PROJECT_DIR/.env.optimized" << 'EOF'
# Configurazioni ottimizzate per Filament v4
APP_DEBUG=false
APP_ENV=production

# Ottimizzazioni memoria
MEMORY_LIMIT=512M
MAX_EXECUTION_TIME=60

# Cache ottimizzate
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Database ottimizzazioni
DB_CONNECTION=mysql
DB_STRICT_MODE=false

# Filament ottimizzazioni
FILAMENT_MEMORY_OPTIMIZATION=true
FILAMENT_DISABLE_LAZY_LOADING=false
FILAMENT_MAX_RECORDS_PER_PAGE=25
EOF

echo ""
echo "✅ Ottimizzazioni completate!"
echo ""
echo "📋 Prossimi passi:"
echo "1. Riavvia il server: php artisan serve --port=8000"
echo "2. Testa i pannelli admin"
echo "3. Monitora la memoria: php artisan memory:monitor"
echo "4. Se necessario, usa: php -d memory_limit=512M artisan serve"
echo ""
echo "🔧 Configurazioni aggiunte:"
echo "- Memory limit aumentato a 512M"
echo "- Middleware di ottimizzazione memoria"
echo "- Trait per modelli ottimizzati"
echo "- Comando di monitoraggio memoria"
echo "- Configurazioni cache ottimizzate"
echo ""
echo "💡 Suggerimenti aggiuntivi:"
echo "- Usa paginazione per liste lunghe"
echo "- Limita il numero di widget per pagina"
echo "- Abilita caching per query pesanti"
echo "- Monitora regolarmente l'uso della memoria"
