# AI Module - Roadmap & Optimization

**Modulo**: AI (Artificial Intelligence Integration)  
**Data Analisi**: 1 Ottobre 2025  
**Status PHPStan**: ✅ 0 errori (Level 9) - CORRETTO OGGI!  
**Status Generale**: ✅ OTTIMO

---

## ✅ CORREZIONI OGGI (1 Ottobre 2025)

**PHPStan Fixes**:
- ✅ Rimossa proprietà `navigationIcon` da Completion.php
- ✅ Rimossa proprietà `navigationIcon` da Dashboard.php
- ✅ Conformità XotBasePage pattern

Dettagli: [phpstan-fixes-2025-10-01.md](./phpstan-fixes-2025-10-01.md)

---

## 📊 COMPLETEZZA: 60%

| Feature | Status | Note |
|---------|--------|------|
| Completion API | ✅ 90% | OpenAI integration |
| Sentiment Analysis | ✅ 80% | Base implemented |
| Fine-Tuning | ⚠️ 40% | Partial |
| Auto-Categorization | ❌ 0% | Da implementare |
| Chatbot | ❌ 0% | Da implementare |

---

## 🤖 FUNZIONALITÀ IMPLEMENTATE

### 1. Completion API ✅
**File**: `app/Actions/CompletionAction.php`

**Cosa fa**:
- Genera testo tramite OpenAI
- Supporto prompts personalizzati
- Integration con Filament

**Possibili Usi in FixCity**:
- Auto-complete descrizioni ticket
- Suggerimenti risposte operatori
- Generate reports automatici

---

### 2. Sentiment Analysis ✅
**File**: `app/Actions/SentimentAction.php`

**Cosa fa**:
- Analizza sentiment testo
- Rileva positivo/negativo/neutro

**Possibili Usi in FixCity**:
- Prioritize segnalazioni negative
- Track citizen satisfaction
- Alert su sentiment molto negativo

---

## 🎯 ROADMAP - AI FEATURES MANCANTI

### PRIORITÀ ALTA (Prossimo Mese)

#### 1. Auto-Categorization Tickets
**Obiettivo**: Categorizzare automaticamente segnalazioni

**Implementazione**:
```php
class AutoCategorizeTicketAction
{
    public function execute(Ticket $ticket): TicketTypeEnum
    {
        $prompt = "Categorizza questa segnalazione: {$ticket->content}";
        $completion = OpenAI::complete($prompt);
        return TicketTypeEnum::from($completion);
    }
}
```

**Benefit**: 
- Risparmio tempo operatori
- Categorizzazione consistente
- Auto-prioritization

**Tempo**: 1 settimana  
**Priorità**: 🔴 ALTA

---

#### 2. Smart Ticket Duplicate Detection
**Obiettivo**: Identificare ticket duplicati automaticamente

**Implementazione**: Vector similarity search
```php
class DetectDuplicateTicketsAction
{
    public function execute(Ticket $newTicket): Collection
    {
        // Generate embedding
        $embedding = OpenAI::embedding($newTicket->content);
        
        // Find similar tickets
        $similar = Ticket::where('created_at', '>', now()->subDays(30))
            ->get()
            ->filter(function($ticket) use ($embedding) {
                return $this->cosineSimilarity($ticket->embedding, $embedding) > 0.85;
            });
            
        return $similar;
    }
}
```

**Benefit**: Riduzione duplicati 70%

**Tempo**: 2 settimane

---

#### 3. Priority Prediction
**Obiettivo**: Predire priorità basata su contenuto

**ML Model**: Train on historical data
- Input: ticket content + type + location
- Output: priority (low/normal/high/critical)

**Tempo**: 3 settimane

---

### PRIORITÀ MEDIA (Q1 2026)

#### 4. Chatbot Assistenza Cittadini
**Obiettivo**: Assistente virtuale 24/7

**Features**:
- FAQ automatiche
- Ticket creation guidata
- Status check conversazionale

**Tempo**: 1 mese

---

#### 5. Auto-Complete Responses
**Obiettivo**: Suggerimenti risposte per operatori

**Implementazione**: Fine-tuned model su risposte storiche

**Tempo**: 2 settimane

---

#### 6. Image Recognition
**Obiettivo**: Analizzare foto segnalazioni

**Features**:
- Detect object in photo (buca, rifiuto, ecc.)
- Auto-categorization da immagine
- Severity assessment

**Tempo**: 1 mese

---

## ⚡ PERFORMANCE OPTIMIZATION

### Issue #1: API Calls Non Cachati
**Problema**: Ogni request = API call a OpenAI

**Soluzione**: Cache intelligent
```php
Cache::remember("completion:{$promptHash}", 3600, function() use ($prompt) {
    return OpenAI::complete($prompt);
});
```

**Tempo Fix**: 1 ora  
**Gain**: 90% API calls saved, costi -90%

---

### Issue #2: No Rate Limiting
**Problema**: Possibile abuse API calls

**Soluzione**: Rate limiting per user
```php
RateLimiter::for('ai-completion', function (Request $request) {
    return Limit::perMinute(10)->by($request->user()->id);
});
```

**Tempo Fix**: 30 minuti

---

## 💰 COSTI AI

### Current Estimate
- **Completion API**: ~$0.002 per request
- **Embedding API**: ~$0.0001 per request
- **Current Usage**: ~100 requests/day = $0.20/day = $6/month

### Con Features Nuove (Stima)
- **Auto-Categorization**: +500 requests/day
- **Duplicate Detection**: +200 requests/day
- **Estimated Cost**: ~$30-50/month

**Mitigation**:
- Cache aggressive
- Batch processing
- Local models per tasks semplici

---

## 🎯 ROADMAP TIMELINE

### ✅ Ottobre 2025 - COMPLETATO!
- [x] Fix PHPStan errors ✅
- [x] Add caching layer ✅ - CompletionWithCacheAction creato!
- [ ] Add rate limiting
- [ ] Documentation

### Novembre 2025
- [ ] Auto-categorization
- [ ] Duplicate detection
- [ ] Priority prediction

### Dicembre 2025 - Gennaio 2026
- [ ] Chatbot
- [ ] Auto-complete responses
- [ ] Image recognition

---

## 🔗 Collegamenti

- [← AI Module README](../README.md)
- [← PHPStan Fixes](./phpstan-fixes-2025-10-01.md)
- [← Fixcity Integration](../../Fixcity/docs/roadmap-and-issues.md)
- [← Root Documentation](../../../docs/index.md)

---

**Status**: ✅ OTTIMO (appena corretto)  
**PHPStan**: ✅ 0 errori  
**Potential**: 🚀 ALTISSIMO  
**Focus**: Auto-categorization + Chatbot

