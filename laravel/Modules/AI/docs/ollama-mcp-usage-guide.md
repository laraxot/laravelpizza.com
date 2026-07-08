# 📘 Guida Pratica all'Utilizzo di Ollama MCP

**Data Creazione**: 2026-03-11  
**Versione**: 1.0.0  
**Compatibilità**: ollama-mcp v2.1.0+

---

## 🚀 Quick Start

### Prerequisiti

1. **Ollama installato e funzionante**
   ```bash
   # Verifica installazione
   ollama --version
   
   # Verifica server attivo
   curl http://127.0.0.1:11434/api/tags
   ```

2. **Modelli disponibili**
   ```bash
   # Lista modelli installati
   ollama list
   
   # Installa modello se necessario
   ollama pull qwen2.5-coder:7b
   ```

3. **Node.js e npm**
   ```bash
   node --version  # >= 18.x
   npm --version
   ```

### Configurazione MCP

Il file `.mcp.json` è già configurato:

```json
{
  "mcpServers": {
    "ollama": {
      "type": "stdio",
      "command": "npx",
      "args": ["-y", "ollama-mcp@latest"],
      "env": {
        "OLLAMA_HOST": "http://127.0.0.1:11434",
        "OLLAMA_MODEL": "qwen2.5-coder:7b",
        "OLLAMA_KEEP_ALIVE": "10m",
        "OLLAMA_TIMEOUT": "30000"
      }
    }
  }
}
```

---

## 🛠️ Funzionalità Disponibili

### 1. Chat Completion
Interazione conversazionale con modelli Ollama.

**Quando usarlo:**
- Generazione testo semplice
- Domande e risposte
- Brainstorming
- Prototipazione rapida

**Parametri ottimizzati:**
```json
{
  "model": "qwen2.5-coder:7b",
  "temperature": 0.3,
  "num_predict": 256,
  "top_k": 20,
  "top_p": 0.7
}
```

### 2. Code Generation
Generazione di codice con contesto.

**Quando usarlo:**
- Snippet di codice
- Funzioni helper
- Template boilerplate
- Refactoring semplice

**Modello consigliato:** `qwen2.5-coder:7b`

### 3. Embeddings
Generazione di vettori per RAG e similarity search.

**Quando usarlo:**
- Semantic search
- Document clustering
- Similarity matching
- RAG systems

### 4. Model Management
Gestione modelli Ollama.

**Operazioni:**
- List models
- Pull new models
- Delete models
- Model info

---

## 📊 Routing Intelligente

### Matrice di Routing

| Task Type | Complexity | Provider | Token Saved |
|-----------|-----------|----------|-------------|
| Text classification | Low | Ollama | 80% |
| Code snippet | Low-Medium | Ollama | 70% |
| Simple parsing | Low | Ollama | 90% |
| Template generation | Medium | Ollama | 60% |
| Complex reasoning | High | Cloud API | 0% |
| Multi-step analysis | High | Cloud API | 0% |
| Research synthesis | High | Hybrid | 30% |

### Decision Tree

```
START
  │
  ├─ È un task ripetitivo? 
  │   ├─ SI → Ollama (cached)
  │   └─ NO ↓
  │
  ├─ Richiede < 256 token output?
  │   ├─ SI → Ollama
  │   └─ NO ↓
  │
  ├─ È codice semplice?
  │   ├─ SI → Ollama qwen2.5-coder
  │   └─ NO ↓
  │
  ├─ Richiede reasoning profondo?
  │   ├─ SI → Cloud API (Claude/GPT-4)
  │   └─ NO → Ollama (default)
```

---

## 💡 Esempi Pratici

### Esempio 1: Classificazione Testo

**Task:** Classificare ticket support in categorie.

```typescript
// ❌ MALE: Cloud API per task semplice
const response = await openai.chat.completions.create({
  model: "gpt-4",
  messages: [{ role: "user", content: "Classify: 'Login non funziona'" }],
  max_tokens: 50
});
// Costo: ~$0.0015 per request

// ✅ BENE: Ollama MCP per task semplice
const response = await ollamaMCP.chat({
  model: "qwen2.5-coder:7b",
  messages: [{ role: "user", content: "Classify: 'Login non funziona'" }],
  options: { num_predict: 50, temperature: 0.1 }
});
// Costo: $0.00 + caching
// Risparmio: 100%
```

### Esempio 2: Generazione Codice

**Task:** Generare funzione helper PHP.

```php
// Prompt per Ollama MCP
$prompt = <<<PROMPT
Genera una funzione PHP che:
- Converte una stringa in slug URL-friendly
- Gestisce caratteri speciali italiani (à, è, é, etc.)
- Mantiene solo lettere, numeri e trattini
- Massimo 10 righe di codice

Signature: function slugify(string $text): string
PROMPT;

// Ollama genererà codice pulito e testabile
$code = $ollamaMCP->generate($prompt, [
    'model' => 'qwen2.5-coder:7b',
    'temperature' => 0.2,  // Bassa per coerenza
    'num_predict' => 200
]);
```

### Esempio 3: Parsing Strutturato

**Task:** Estrarre dati da testo non strutturato.

```php
// Input: "Meeting con Mario Rossi domani alle 15:00 in ufficio"
// Output: { person: "Mario Rossi", date: "tomorrow", time: "15:00", location: "ufficio" }

$prompt = "Estrai: persona, data, ora, luogo dal testo seguente in formato JSON.\n\nTesto: $input";
$parsed = $ollamaMCP->chat($prompt, ['temperature' => 0.0]);
```

---

## ⚙️ Configurazione Avanzata

### Environment Variables

```bash
# .env
OLLAMA_HOST=http://127.0.0.1:11434
OLLAMA_MODEL=qwen2.5-coder:7b
OLLAMA_KEEP_ALIVE=10m
OLLAMA_TIMEOUT=30000

# Ottimizzazione performance
OLLAMA_NUM_PARALLEL=4
OLLAMA_MAX_LOADED_MODELS=2
OLLAMA_FLASH_ATTENTION=1
```

### Parametri Ottimizzati per Token Efficiency

| Parametro | Valore | Impatto |
|-----------|--------|---------|
| `num_predict` | 128-256 | -50-70% output tokens |
| `temperature` | 0.1-0.3 | -10-20% variance |
| `top_k` | 10-20 | -5-15% exploration |
| `top_p` | 0.5-0.7 | -5-10% randomness |
| `repeat_penalty` | 1.1-1.2 | -5% repetition |
| `seed` | fixed | 100% reproducibility |

### Model Selection Strategy

```php
// Modules/AI/Actions/SelectOllamaModelAction.php
class SelectOllamaModelAction extends QueueableAction
{
    public function handle(string $taskType): string
    {
        return match($taskType) {
            'code_generation' => 'qwen2.5-coder:7b',
            'text_generation' => 'qwen3:latest',
            'fast_response' => 'deepseek-coder:1.3b',
            'complex_reasoning' => 'deepseek-r1:latest',
            default => 'qwen2.5-coder:7b'
        };
    }
}
```

---

## 🔍 Monitoring e Debugging

### Log delle Richieste

```php
// Modules/AI/Actions/LogOllamaRequestAction.php
class LogOllamaRequestAction extends QueueableAction
{
    public function handle(array $request, array $response): void
    {
        Log::channel('ollama')->info('Ollama MCP Request', [
            'model' => $request['model'] ?? 'default',
            'tokens_input' => $request['tokens']['input'] ?? 0,
            'tokens_output' => $response['tokens']['output'] ?? 0,
            'duration_ms' => $response['duration_ms'] ?? 0,
            'cached' => $response['cached'] ?? false,
            'timestamp' => now()->toIso8601String()
        ]);
    }
}
```

### Metriche da Tracciare

1. **Token Usage**
   - Input tokens per request
   - Output tokens per request
   - Token saved vs cloud API

2. **Performance**
   - Response time (p50, p95, p99)
   - Throughput (requests/second)
   - Error rate

3. **Cost Savings**
   - Cloud API cost avoided
   - Effective cost per token
   - ROI giornaliero/settimanale

4. **Model Usage**
   - Requests per model
   - Success rate per model
   - Average tokens per model

---

## 🐛 Troubleshooting

### Problemi Comuni

**1. Ollama MCP non risponde**
```bash
# Verifica Ollama server
curl http://127.0.0.1:11434/api/tags

# Riavvia Ollama
ollama serve

# Verifica log
journalctl -u ollama -f
```

**2. Modello non trovato**
```bash
# Lista modelli disponibili
ollama list

# Installa modello mancante
ollama pull qwen2.5-coder:7b
```

**3. Timeout errori**
```json
// Aumenta timeout in .mcp.json
{
  "env": {
    "OLLAMA_TIMEOUT": "60000"  // 60 secondi
  }
}
```

**4. Memory issues**
```bash
# Verifica memoria disponibile
free -h

# Riduci contesto Ollama
OLLAMA_CONTEXT_SIZE=2048 ollama serve
```

### Debug Mode

```bash
# Abilita debug logging
export OLLAMA_DEBUG=1
npx -y ollama-mcp@latest
```

---

## 📈 Best Practices

### 1. Caching Strategy

```php
// Cache responses per prompt simili
$cacheKey = 'ollama:' . md5($prompt);
$response = Cache::remember($cacheKey, 3600, function() use ($prompt) {
    return $ollamaMCP->chat($prompt);
});
```

### 2. Batch Processing

```php
// Raggruppa richieste simili
$batch = collect($prompts)->map(fn($p) => [
    'prompt' => $p,
    'options' => ['temperature' => 0.2]
]);

$responses = $ollamaMCP->batch($batch);
```

### 3. Graceful Degradation

```php
try {
    $response = $ollamaMCP->chat($prompt);
} catch (OllamaException $e) {
    // Fallback to cloud API
    $response = $openai->chat($prompt);
    Log::warning('Ollama fallback to OpenAI', ['error' => $e->getMessage()]);
}
```

### 4. Prompt Engineering

```php
// ✅ BENE: Prompt specifico e strutturato
$prompt = <<<PROMPT
Task: Classificare il seguente ticket in una delle categorie: [bug, feature, support, other]

Ticket: "{$ticketText}"

Rispondi SOLO con il nome della categoria, nessuna spiegazione.
PROMPT;

// ❌ MALE: Prompt vago
$prompt = "Che categoria è questo ticket? $ticketText";
```

---

## 🔗 Integrazione con Laraxot

### Queueable Action Pattern

```php
// Modules/AI/Actions/OllamaChatAction.php
namespace Modules\AI\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Xot\Actions\AI\Ollama\ChatOllamaAction;

class OllamaChatAction extends QueueableAction
{
    public function __construct(
        protected string $prompt,
        protected array $options = []
    ) {}
    
    public function handle(): string
    {
        $chatAction = app(ChatOllamaAction::class);
        
        return $chatAction->executeOptimized(
            $this->prompt,
            $this->options
        );
    }
}
```

### Service Provider Registration

```php
// Modules/AI/Providers/AIServiceProvider.php
public function register(): void
{
    $this->app->bind(OllamaMCPInterface::class, function($app) {
        return new OllamaMCPClient(
            config('services.ollama.host'),
            config('services.ollama.model')
        );
    });
}
```

---

## 📚 Risorse Aggiuntive

### Documentazione
- [Ollama Token Optimization](.agents/docs/ollama-token-optimization.md)
- [Ollama MCP Integration Vision](./ollama-mcp-integration-vision.md)
- [AI Module Architecture](./ai-module-architecture.md)

### External Links
- [Ollama Documentation](https://ollama.ai/docs)
- [ollama-mcp on npm](https://www.npmjs.com/package/ollama-mcp)
- [MCP Specification](https://modelcontextprotocol.io)

---

**Prossimo passo:** Testare l'integrazione MCP e creare GitHub Issue/Discussion per collaborazione multi-agente.
