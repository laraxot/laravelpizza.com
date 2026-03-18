## Regole di naming per le azioni

- Le azioni che operano su una chiave specifica devono utilizzare la forma `By<Key>` (es. `UpdateRestiPondByValutatoreIdAction`).
- Il namespace corretto per Filament è sempre `Modules\<nome modulo>\Filament`, anche se i file risiedono in `app/Filament`.
- Esempio pratico: vedi la correzione e il ragionamento in [Azioni Organizzativa (Performance)](../../performance/docs/azioni_organizzativa.md).

## 🤖 Regole AI Queueable Actions Pattern

### Regole Fondamentali per il Modulo AI
- **CRITICAL AI RULE**: Tutte le operazioni AI devono usare Queueable Actions
- **CRITICAL AI RULE**: MAI creare AI service classes
- **CRITICAL AI RULE**: AI actions belong in `Modules/Xot/Actions/AI/` o modulo dedicato AI
- **CRITICAL AI RULE**: Use create-action skill per tutte le operazioni AI-specific

### Pattern di Implementazione per il Modulo AI
```php
// ❌ MALE: AI service class
class OllamaService {
    public function chat(array $messages) { /* ... */ }
}

// ✅ BENE: AI Queueable Action
class ChatOllamaAction extends QueueableAction {
    public function __construct(
        protected array $messages,
        protected string $model = 'qwen2.5-coder:7b'
    ) {}
    
    public function handle(): array {
        // Logica di business per chat Ollama
        return $this->processChat();
    }
}
```

### Caratteristiche dei Queueable Actions per il Modulo AI
- **Single Responsibility**: Ogni azione ha un unico scopo ben definito
- **Testability**: Tutte le azioni AI sono facilmente testabili con Pest
- **Reusability**: Azioni AI riutilizzabili in diversi contesti
- **Queue Support**: Supporto automatico per esecuzione asincrona
- **Clean Separation**: Separazione netta tra logica AI e altri componenti

### Collegamenti
- [Azioni Organizzativa (Performance)](../../performance/docs/azioni_organizzativa.md)

## Regole sui Model
- Nei moduli, i model devono **sempre** estendere `BaseModel` e **mai** direttamente `Model`.
- Il codice deve essere scritto già conforme agli standard richiesti da phpstan livello 10.
- Evitare duplicazioni di model: vedi la discussione e i rischi nella [documentazione Performance](../../Performance/docs/azioni_organizzativa.md#duplicazione-tra-organizzativatotvalutatore-e-organizzativatotvalutatoreid).

## Regole permanenti per Action Filament custom

### Pattern corretto
- Override di `setUp()` per configurare tutte le proprietà dell'action custom (label, icona, conferma, azione, ecc.).
- Nome univoco e documentato passato a `parent::make` (o gestito internamente da Filament).
- Tutte le label, heading e descrizioni devono provenire dai file di traduzione del modulo (mai stringhe hardcoded).
- Tipizzazione rigorosa di tutti i metodi, evitare `mixed` se non strettamente necessario.
- Documentazione aggiornata e collegata (modulo e root).
- Validazione statica con phpstan e test di regressione dopo ogni bugfix.

### Anti-pattern da evitare
- Closure anonime per azioni complesse o riusabili.
- Uso di `->label()` con stringhe hardcoded.
- Metodi statici con firma non compatibile con Filament.
- Duplicazione di logica tra action e controller.
- Nomi duplicati per le action.

### Checklist per ogni nuova Action Filament
- [ ] Override di `setUp()`
- [ ] Nome univoco e documentato
- [ ] Label e testi solo da file di traduzione
- [ ] Tipizzazione rigorosa
- [ ] Documentazione aggiornata (modulo e root)
- [ ] Validazione phpstan e test di regressione

### Esempio e motivazione
- Vedi [Performance/docs/organizzativa-migration-errors.md](../../performance/docs/organizzativa-migration-errors.md) per esempio pratico, motivazione e memoria storica.
- Queste regole sono obbligatorie per tutti i moduli che implementano action custom Filament.

### Collegamenti
- [Performance: pattern e anti-pattern Action Filament](../../performance/docs/organizzativa-migration-errors.md)
- [Indice e collegamenti root](../../../../docs/links.md)

## Regole sulle colonne delle tabelle Filament
- Le colonne delle tabelle Filament devono corrispondere esattamente a quelle del modello e della migrazione.
- Non inventare mai colonne (es. name, field_name, op, value) se non esistono realmente.
- Usare sempre i file di traduzione per le label.
- Vedi [Performance/docs/organizzativa_cat_coeffs.md](../../performance/docs/organizzativa_cat_coeffs.md) per esempio pratico, motivazione, correzione e checklist.
- Vedi [Performance/docs/organizzativa_cat_coeffs.md](../../performance/docs/organizzativa_cat_coeffs.md) per esempio pratico, motivazione, correzione e checklist.
- Vedi [Performance/docs/organizzativa_cat_coeffs.md](../../performance/docs/organizzativa_cat_coeffs.md) per esempio pratico, motivazione, correzione e checklist.
