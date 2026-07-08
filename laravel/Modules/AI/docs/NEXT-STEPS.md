# 🎯 Ollama MCP Integration - Stato Attuale e Prossimi Passi

**Data**: 2026-03-11  
**Status**: ✅ Setup Infrastructure COMPLETATO  
**Fase**: 1/4 (Setup Infrastructure)  
**Next**: Fase 2 (Implementazione Core)

---

## ✅ Cosa è Stato Completato

### 1. Infrastructure Setup
- ✅ Ollama server verificato (v0.12.5)
- ✅ 11 modelli disponibili (qwen2.5-coder:7b, qwen3, deepseek, etc.)
- ✅ Server attivo su http://127.0.0.1:11434
- ✅ Configurazione MCP aggiornata (.mcp.json)
- ✅ Package ollama-mcp@latest (v2.1.0) configurato
- ✅ Test connettività Ollama API riuscito

### 2. Documentazione Completa
- ✅ Visione e Filosofia (ollama-mcp-integration-vision.md)
- ✅ Guida Pratica (ollama-mcp-usage-guide.md)
- ✅ Regole Condivise (.agents/docs/ollama-mcp-rules.md)
- ✅ Memories (.agents/docs/memories.md)
- ✅ GitHub Issue #85 creata
- ✅ Commento progress aggiunto

### 3. Architettura Definita
- ✅ Routing intelligente (Ollama vs Cloud API)
- ✅ Model selection strategy
- ✅ Token efficiency parameters
- ✅ Caching strategy
- ✅ Monitoring approach

---

## 📋 Prossimi Passi (Fase 2: Implementazione Core)

### Priority: HIGH ⚠️

#### 1. Testare MCP Completo
**Task**: Verificare che MCP client possa comunicare con Ollama MCP server.

**Come**:
- Usare MCP client (Claude Desktop, Cursor, etc.)
- Verificare tools esposti da ollama-mcp
- Testare chat, generate, embeddings
- Documentare risultati

**Tempo stimato**: 30 minuti

#### 2. Implementare OllamaMCPAction
**Task**: Creare Queueable Action per interagire con Ollama tramite MCP.

**Location**: `Modules/AI/Actions/OllamaMCPAction.php`

**Struttura**:
```php
<?php

namespace Modules\AI\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Xot\Actions\AI\Ollama\ChatOllamaAction;

class OllamaMCPAction extends QueueableAction
{
    public function __construct(
        protected string $prompt,
        protected string $taskType = 'default',
        protected array $options = []
    ) {}

    public function handle(): string
    {
        // 1. Select model based on task type
        $model = $this->selectModel();
        
        // 2. Optimize parameters
        $params = $this->optimizeParameters();
        
        // 3. Check cache
        $cacheKey = $this->getCacheKey();
        
        // 4. Execute via MCP
        $response = $this->executeViaMCP($model, $params);
        
        // 5. Log metrics
        $this->logMetrics($response);
        
        return $response;
    }

    private function selectModel(): string
    {
        return match($this->taskType) {
            'code' => 'qwen2.5-coder:7b',
            'text' => 'qwen3:latest',
            'fast' => 'deepseek-coder:1.3b',
            'complex' => 'deepseek-r1:latest',
            default => 'qwen2.5-coder:7b'
        };
    }

    private function optimizeParameters(): array
    {
        return [
            'num_predict' => $this->options['num_predict'] ?? 256,
            'temperature' => $this->options['temperature'] ?? 0.3,
            'top_k' => $this->options['top_k'] ?? 20,
            'top_p' => $this->options['top_p'] ?? 0.7,
        ];
    }

    private function executeViaMCP(string $model, array $params): string
    {
        // TODO: Implementare chiamata MCP
        // Per ora, fallback a ChatOllamaAction esistente
        return app(ChatOllamaAction::class)
            ->executeOptimized($this->prompt, $params);
    }

    private function logMetrics(array $response): void
    {
        // TODO: Implementare logging strutturato
    }
}
```

**Tempo stimato**: 2 ore

#### 3. Implementare Routing Intelligente
**Task**: Creare action che decide automaticamente Ollama vs Cloud API.

**Location**: `Modules/AI/Actions/IntelligentRoutingAction.php`

**Struttura**:
```php
<?php

namespace Modules\AI\Actions;

use Spatie\QueueableAction\QueueableAction;

class IntelligentRoutingAction extends QueueableAction
{
    public function __construct(
        protected string $prompt,
        protected string $taskType = 'default'
    ) {}

    public function handle(): string
    {
        $complexity = $this->analyzeComplexity();
        
        if ($complexity === 'low' || $complexity === 'medium') {
            return app(OllamaMCPAction::class, [
                'prompt' => $this->prompt,
                'taskType' => $this->taskType
            ])->handle();
        }

        // Fallback to Cloud API
        return $this->fallbackToCloudAPI();
    }

    private function analyzeComplexity(): string
    {
        $tokenCount = str_word_count($this->prompt);
        
        if ($tokenCount < 100) return 'low';
        if ($tokenCount < 500) return 'medium';
        return 'high';
    }

    private function fallbackToCloudAPI(): string
    {
        // TODO: Implementare fallback a Claude/GPT-4
        return 'Cloud API response';
    }
}
```

**Tempo stimato**: 2 ore

#### 4. Setup Logging Strutturato
**Task**: Implementare logging per tutte le operazioni AI.

**Location**: `Modules/AI/Actions/LogAIRequestAction.php`

**Struttura**:
```php
<?php

namespace Modules\AI\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Log;

class LogAIRequestAction extends QueueableAction
{
    public function handle(
        string $provider,
        string $model,
        int $tokensInput,
        int $tokensOutput,
        float $durationMs,
        bool $cached = false
    ): void {
        Log::channel('ai')->info('AI Request', [
            'provider' => $provider,
            'model' => $model,
            'tokens_input' => $tokensInput,
            'tokens_output' => $tokensOutput,
            'tokens_total' => $tokensInput + $tokensOutput,
            'duration_ms' => $durationMs,
            'cached' => $cached,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
```

**Configurazione logging**:
```php
// config/logging.php
'channels' => [
    'ai' => [
        'driver' => 'daily',
        'path' => storage_path('logs/ai.log'),
        'level' => 'info',
        'days' => 30,
    ],
],
```

**Tempo stimato**: 1 ora

---

### Priority: MEDIUM 📊

#### 5. Test Pest per OllamaMCPAction
**Task**: Creare test con 100% coverage.

**Location**: `Modules/AI/tests/Unit/OllamaMCPActionTest.php`

**Struttura**:
```php
<?php

use Modules\AI\Actions\OllamaMCPAction;

it('executes chat with correct model', function () {
    $action = new OllamaMCPAction(
        prompt: 'Test prompt',
        taskType: 'code'
    );
    
    $result = $action->handle();
    
    expect($result)->toBeString();
});

it('selects correct model based on task type', function () {
    $action = new OllamaMCPAction(
        prompt: 'Test',
        taskType: 'code'
    );
    
    $model = $action->selectModel();
    
    expect($model)->toBe('qwen2.5-coder:7b');
});

it('optimizes parameters correctly', function () {
    $action = new OllamaMCPAction(
        prompt: 'Test',
        options: ['temperature' => 0.5]
    );
    
    $params = $action->optimizeParameters();
    
    expect($params['temperature'])->toBe(0.5);
    expect($params['num_predict'])->toBe(256);
});
```

**Tempo stimato**: 2 ore

#### 6. Implementare Caching Semantico
**Task**: Cache responses con similarity matching.

**Location**: `Modules/AI/Actions/SemanticCacheAction.php`

**Approccio**:
- Usare embeddings Ollama per similarity
- Cache con TTL dinamico
- Hit rate target: >70%

**Tempo stimato**: 3 ore

---

### Priority: LOW 📝

#### 7. Dashboard Metriche
**Task**: Dashboard per monitorare KPI.

**Location**: `Modules/AI/Filament/Pages/AIMetricsDashboard.php`

**Metriche**:
- Token saved vs baseline
- Response time (p50, p95, p99)
- Cost reduction
- Cache hit rate
- Provider distribution

**Tempo stimato**: 4 ore

#### 8. A/B Testing Framework
**Task**: Framework per testare strategie routing.

**Approccio**:
- Gruppo A: Routing attuale
- Gruppo B: Nuova strategia
- Metriche: Cost, Quality, Speed
- Durata: 1 settimana

**Tempo stimato**: 6 ore

---

## 🤝 Come Collaborare

### Per Coding Agents
1. Leggi docs in `laravel/Modules/AI/docs/`
2. Implementa action seguendo pattern definiti
3. Scrivi test con 100% coverage
4. Aggiorna docs dopo implementazione
5. Commenta in GitHub Issue #85

### Per Testing Agents
1. Crea integration tests per MCP
2. Performance benchmarks
3. Load testing Ollama server
4. Regression testing suite
5. Documenta risultati in docs/

### Per Documentation Agents
1. Mantieni docs sincronizzate
2. Aggiorna examples con codice reale
3. Crea tutorial step-by-step
4. Traduci docs in inglese se necessario
5. Versioning delle docs

### Per Research Agents
1. Testa nuovi modelli Ollama
2. Sperimenta parametri ottimali
3. Confronta Ollama vs Cloud API quality
4. Identifica nuovi use cases
5. Condividi scoperte in memories

---

## 📞 Contatti e Comunicazione

**GitHub Issue**: https://github.com/laraxot/base_quaeris_fila5_mono/issues/85

**Docs Location**: `laravel/Modules/AI/docs/`

**Rules**: `.agents/docs/ollama-mcp-rules.md`

**Memories**: `.agents/docs/memories.md`

---

## 🎯 Definition of Done

Per considerare la Fase 2 completata:

- [ ] MCP testato e funzionante
- [ ] OllamaMCPAction implementata
- [ ] IntelligentRoutingAction implementata
- [ ] Logging strutturato attivo
- [ ] Test Pest con 100% coverage
- [ ] Docs aggiornate
- [ ] GitHub Issue aggiornata
- [ ] Almeno 1 altro agente ha testato il sistema

---

## 🧘 Mantra del Giorno

> *"Prima la struttura, poi il codice,  
> Prima la comprensione, poi l'azione,  
> Prima la collaborazione, poi il successo."*

**OM SHANTI OM** 🙏

---

**Last Updated**: 2026-03-11 17:00 CET  
**Next Update**: Dopo completamento Fase 2
