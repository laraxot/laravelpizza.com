# 📜 Ollama MCP Rules - Regole Condivise per Agenti AI

**Data Creazione**: 2026-03-11  
**Ultimo Aggiornamento**: 2026-03-11  
**Versione**: 1.0.0  
**Status**: Active

---

## 🚨 Regole Critiche

### 1. MCP-First Approach
**CRITICAL**: Quando si lavora con Ollama, usare SEMPRE MCP invece di chiamate HTTP dirette.

```php
// ❌ MALE: Chiamata HTTP diretta
$response = Http::post('http://localhost:11434/api/generate', [...]);

// ✅ BENE: Tramite MCP
$response = $ollamaMCP->generate([...]);
```

**Motivazione**: MCP fornisce:
- Standardizzazione
- Better error handling
- Automatic logging
- Caching integration

### 2. Routing Intelligence
**CRITICAL**: Prima di usare Cloud API, valutare SEMPRE se Ollama è sufficiente.

**Decision Tree**:
```
Task complexity?
├─ Low (classification, parsing) → Ollama
├─ Medium (code generation) → Ollama
└─ High (complex reasoning) → Cloud API
```

### 3. Token Efficiency Priority
**CRITICAL**: Ogni richiesta deve essere ottimizzata per risparmiare token.

**Parametri obbligatori**:
```json
{
  "num_predict": 128-256,
  "temperature": 0.1-0.3,
  "top_k": 10-20,
  "top_p": 0.5-0.7
}
```

### 4. Docs-First Protocol
**CRITICAL**: Prima di implementare, aggiornare SEMPRE la documentazione.

**Workflow**:
1. Leggi docs in `laravel/Modules/AI/docs/`
2. Aggiorna docs con nuova funzionalità
3. Implementa codice
4. Aggiorna docs con risultati

---

## 📋 Regole Tecniche

### 5. Queueable Actions Only
**RULE**: Tutte le operazioni AI devono usare Queueable Actions.

```php
// ✅ BENE: Queueable Action
class ProcessWithOllamaAction extends QueueableAction
{
    public function handle(): array
    {
        return $this->process();
    }
}
```

**Location**: `Modules/AI/Actions/`

### 6. No Service Classes
**RULE**: MAI creare Service classes per logica AI.

**Motivazione**: Violano DRY e creano manutenibilità overhead.

**Alternative**: Queueable Actions

### 7. Caching Strategy
**RULE**: Implementare caching per tutte le richieste ripetute.

```php
$cacheKey = 'ollama:' . md5($prompt . json_encode($options));
return Cache::remember($cacheKey, 3600, fn() => $ollamaMCP->chat($prompt));
```

### 8. Error Handling
**RULE**: Ogni chiamata Ollama deve avere fallback.

```php
try {
    return $ollamaMCP->chat($prompt);
} catch (OllamaException $e) {
    Log::warning('Ollama failed, using fallback');
    return $this->fallbackToCloudAPI($prompt);
}
```

---

## 🎯 Regole di Routing

### 9. Complexity-Based Routing
**RULE**: Routing basato su complessità del task.

| Task Type | Complexity | Provider | Threshold |
|-----------|-----------|----------|-----------|
| Classification | Low | Ollama | tokens < 100 |
| Code generation | Medium | Ollama | tokens < 500 |
| Text parsing | Low | Ollama | tokens < 200 |
| Complex reasoning | High | Cloud | tokens > 500 |
| Multi-step analysis | High | Cloud | always |

### 10. Model Selection
**RULE**: Selezionare modello appropriato per task.

```php
$model = match($taskType) {
    'code' => 'qwen2.5-coder:7b',
    'text' => 'qwen3:latest',
    'fast' => 'deepseek-coder:1.3b',
    'complex' => 'deepseek-r1:latest',
    default => 'qwen2.5-coder:7b'
};
```

---

## 📊 Regole di Monitoring

### 11. Logging Requirements
**RULE**: Loggare ogni richiesta Ollama.

**Required fields**:
```php
Log::info('Ollama request', [
    'model' => $model,
    'tokens_input' => $inputTokens,
    'tokens_output' => $outputTokens,
    'duration_ms' => $duration,
    'cached' => $cached,
    'timestamp' => now()
]);
```

### 12. Metrics Tracking
**RULE**: Tracciare metriche chiave.

**Required metrics**:
- Token saved vs baseline
- Response time (p50, p95, p99)
- Error rate
- Cache hit rate
- Cost reduction

---

## 🤝 Regole Collaborative

### 13. Documentation Updates
**RULE**: Aggiornare docs dopo ogni modifica significativa.

**Trigger points**:
- Nuova funzionalità implementata
- Cambio architetturale
- Nuovo pattern scoperto
- Bug fix importante

### 14. Cross-Agent Communication
**RULE**: Comunicare modifiche agli altri agenti.

**Channels**:
- Docs: `laravel/Modules/AI/docs/`
- Issues: GitHub Issues
- Comments: Codice commentato

### 15. Knowledge Sharing
**RULE**: Condividere scoperte e best practices.

**Format**:
```markdown
## Scoperta: [Titolo]
**Data**: YYYY-MM-DD
**Contesto**: ...
**Scoperta**: ...
**Impatto**: ...
**Raccomandazione**: ...
```

---

## 🔒 Regole di Sicurezza

### 16. Data Privacy
**RULE**: Dati sensibili devono usare Ollama, mai Cloud API.

**Sensitive data**:
- Password, API keys
- PII (nomi, email, indirizzi)
- Dati aziendali critici
- Informazioni finanziarie

### 17. Anonymization
**RULE**: Anonimizzare dati prima di inviare a Cloud API.

```php
$anonymized = preg_replace('/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/', '[EMAIL]', $text);
$anonymized = preg_replace('/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/', '[PHONE]', $anonymized);
```

---

## ⚡ Regole Performance

### 18. Batch Processing
**RULE**: Raggruppare richieste quando possibile.

```php
// ✅ BENE: Batch processing
$prompts = collect($items)->map(fn($item) => [
    'prompt' => $this->buildPrompt($item),
    'options' => ['temperature' => 0.2]
]);
$responses = $ollamaMCP->batch($prompts);
```

### 19. Context Optimization
**RULE**: Minimizzare contesto per task semplici.

```php
// ❌ MALE: Contesto inutile
$prompt = "Sei un esperto programmatore PHP con 20 anni di esperienza...";

// ✅ BENE: Contesto minimo
$prompt = "PHP function to validate email";
```

### 20. Timeout Management
**RULE**: Impostare timeout appropriati.

```php
$timeout = match($complexity) {
    'low' => 5000,    // 5s
    'medium' => 15000, // 15s
    'high' => 30000,   // 30s
    default => 10000
};
```

---

## 📖 Regole Documentation

### 21. Docs Location
**RULE**: Documentazione tecnica in `laravel/Modules/AI/docs/`.

**Structure**:
```
laravel/Modules/AI/docs/
├── ollama-mcp-integration-vision.md    # Filosofia
├── ollama-mcp-usage-guide.md            # Guida pratica
├── ollama-mcp-rules.md                  # Regole (questo file)
└── architecture/                        # Architettura
    ├── routing-strategy.md
    ├── caching-strategy.md
    └── testing-strategy.md
```

### 22. Memory Updates
**RULE**: Aggiornare memories dopo apprendimenti importanti.

**Location**: `.agents/docs/memories.md`

**Format**:
```markdown
## [YYYY-MM-DD] - [Titolo Apprendimento]
**Categoria**: [Technical/Process/Pattern]
**Descrizione**: ...
**Impatto**: ...
**Prossimi Steps**: ...
```

---

## 🧪 Regole Testing

### 23. Test Coverage
**RULE**: 100% coverage per codice critico AI.

**Required tests**:
- Unit tests per Actions
- Integration tests per MCP
- Performance benchmarks
- Error handling tests

### 24. Mocking Strategy
**RULE**: Mock Ollama MCP nei test unitari.

```php
// Tests/Unit/OllamaActionTest.php
it('processes chat correctly', function() {
    $mock = Mockery::mock(OllamaMCPInterface::class);
    $mock->shouldReceive('chat')
         ->once()
         ->andReturn('test response');
    
    $action = new OllamaChatAction($mock);
    $result = $action->handle();
    
    expect($result)->toBe('test response');
});
```

---

## 🔄 Regole Aggiornamento

### 25. Rule Review
**RULE**: Rivedere queste regole ogni sprint.

**Trigger**:
- Nuove scoperte
- Cambiamenti architetturali
- Feedback agenti
- Metriche performance

### 26. Rule Proposal
**RULE**: Proporre nuove regole tramite discussione.

**Process**:
1. Proponi in GitHub Discussion
2. Discuti con altri agenti
3. Ottieni consensus
4. Aggiungi a questo file
5. Notifica tutti gli agenti

---

## 📊 Enforcement

### Compliance Check
Ogni agente deve verificare compliance con queste regole:

```bash
# Check docs updated
git diff --name-only | grep "laravel/Modules/AI/docs/"

# Check tests written
git diff --name-only | grep "tests/"

# Check Queueable Actions used
grep -r "class.*Action extends QueueableAction" Modules/AI/Actions/
```

---

## 🙏 Mantra delle Regole

> *"Le regole guidano, non limitano.  
> La flessibilità serve, la disciplina nasce.  
> Ogni agente le segue, il sistema migliora.  
> Ollama risparmia, il cloud completa."*

**OM** 🕉️

---

**Next Review**: 2026-03-18 (tra 7 giorni)  
**Responsible**: Tutti gli agenti AI
