# Ollama Token Optimization Guide

## Parametri Chiave per Ridurre i Token

### 1. `num_predict` - Limite Token Output
Limita il numero massimo di token generati nella risposta.

```json
{
  "num_predict": 256
}
```
**Impatto**: Direttamente proporzionale alla riduzione. Valori consigliati: 128-512 per risposte brevi.

### 2. `num_ctx` - Contesto
Dimensione del contesto (token di input).

```json
{
  "num_ctx": 2048
}
```
**Impatto**: Riduce la memoria e i costi se non serve tutto il contesto.

### 3. `temperature` - Casualità
Controlla la creatività del modello. Valori bassi = risposte più deterministiche.

```json
{
  "temperature": 0.3
}
```
**Impatto**: 0.1-0.3 produce risposte più brevi e focalizzate.

### 4. `top_k` - Selezione Token
Limita la selezione ai K token più probabili.

```json
{
  "top_k": 20
}
```
**Impatto**: Valori bassi (10-30) riducono varietà e lunghezza.

### 5. `top_p` - Nucleus Sampling
Soglia cumulativa di probabilità.

```json
{
  "top_p": 0.7
}
```
**Impatto**: Valori bassi = risposte più brevi e concentrate.

### 6. `think` - Ragionamento (per modelli che supportano thinking)
Controlla il livello di ragionamento del modello.

```json
{
  "think": "low"
}
```
**Valori**: "high", "medium", "low"
**Impatto**: "low" può ridurre significativamente i token di ragionamento (27-51%).

### 7. `min_p` - Soglia Minima
Probabilità minima per la selezione del token.

```json
{
  "min_p": 0.05
}
```
**Impatto**: Filtra token improbabili, risposte più concise.

## Esempio di Richiesta Ottimizzata

```bash
curl http://localhost:11434/api/chat -d '{
  "model": "qwen2.5",
  "messages": [
    {
      "role": "user",
      "content": "Spiega brevemente cosa è Laravel"
    }
  ],
  "options": {
    "num_predict": 150,
    "temperature": 0.3,
    "top_k": 20,
    "top_p": 0.7,
    "num_ctx": 1024
  },
  "think": "low"
}'
```

## Utilizzo in Laravel con QueueableActions

### Azioni Disponibili
Le azioni sono in `Modules\Xot\Actions\AI\Ollama\`:
- `ChatOllamaAction` - Chat conversazionale
- `GenerateOllamaAction` - Generazione testo

### Configurazione
Aggiungi al file `.env`:
```env
OLLAMA_URL=http://localhost:11434
OLLAMA_MODEL=qwen2.5
OLLAMA_MAX_TOKENS=256
OLLAMA_TEMPERATURE=0.3
OLLAMA_TOP_K=20
OLLAMA_TOP_P=0.7
OLLAMA_CONTEXT_SIZE=1024
OLLAMA_THINKING=low
```

### Utilizzo

```php
use Modules\User\Actions\Ollama\ChatOllamaAction;

// Usage standard ottimizzato
$result = (new ChatOllamaAction())->executeOptimized('tua domanda');

// Usage minimal (minimo consumo)
$result = (new ChatOllamaAction())->executeMinimal('tua domanda');

// Usage con opzioni custom
$result = (new ChatOllamaAction())->execute('tua domanda', [
    'options' => [
        'num_predict' => 128,
        'temperature' => 0.1,
    ],
    'think' => 'low',
]);

// Risposta
echo $result['content']; // Risposta testuale
echo $result['tokens']['total']; // Token totali usati
```

## Riepilogo Risparmio Token

| Parametro | Impatto Stimato |
|-----------|-----------------|
| num_predict: 256 | 50-70% riduzione output |
| temperature: 0.3 | 10-20% riduzione |
| think: "low" | 27-51% riduzione ragionamento |
| top_k: 20 | 5-15% riduzione |
| top_p: 0.7 | 5-10% riduzione |

**Combinando tutti i parametri**: possibile riduzione **70-90%** dei token totali.

## Modelli Consigliati per Basso Consumo

1. **qwen2.5:0.5b** - Molto leggero
2. **llama3.2:1b** - Bilanciato
3. **gemma3:1b** - Buona qualità
4. **phi3:3.8b** - Ottimo rapporto qualità/velocità
