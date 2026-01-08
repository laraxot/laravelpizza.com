# Module Path Generation - Philosophy and Business Logic

**Data Creazione**: 2026-01-02  
**Status**: 📚 Foundation Document  
**Versione**: 1.0.0

## 🧠 Logica (Logic)

### Principio Fondamentale

**La generazione di path per moduli deve essere robusta, non-intrusiva, e gestire gracefully i casi in cui le risorse non esistono.**

### Business Logic

Il sistema di generazione path serve a:
1. **Localizzare risorse moduli**: Assets, views, config, migrations
2. **Supportare sviluppo modulare**: Ogni modulo può avere o meno certe risorse
3. **Mantenere flessibilità**: Non tutti i moduli hanno tutte le cartelle

### Pattern di Comportamento

**Regola Assoluta**: Un modulo NON deve fallire se non ha una cartella opzionale.

## ⚖️ Politica (Politics)

### Regole Architetturali

1. **Graceful Degradation**: Se un modulo non ha assets, il sistema deve continuare a funzionare
2. **Optional Resources**: Assets, SVG, e altre risorse sono opzionali
3. **No Hard Failures**: Il sistema non deve crashare per risorse mancanti

### Violazioni da Evitare

- ❌ Lanciare eccezioni per risorse opzionali mancanti
- ❌ Assumere che tutti i moduli abbiano tutte le cartelle
- ❌ Fallire il boot dell'applicazione per path mancanti

## 🙏 Religione (Religion)

### Credenze Fondamentali

**"Il sistema deve essere permissivo, non restrittivo"**

- Ogni modulo è autonomo nella sua struttura
- Le risorse opzionali non devono bloccare il sistema
- Il fallback è sacro - sempre previsto

## 🧘 Zen (Zen)

### Stato Ideale

**Armonia attraverso la flessibilità**

- Il sistema si adatta alla struttura di ogni modulo
- Nessun conflitto tra moduli con strutture diverse
- Transizione fluida tra moduli con e senza risorse

## 🎯 Manifestazioni Pratiche

### Pattern Corretto

```php
// ✅ CORRETTO: Gestione graceful
try {
    $assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
    $svgPath = $assetsPath.'/../svg';
    if (File::exists($svgPath)) {
        $factory->add($this->nameLower, ['path' => $svgPath, 'prefix' => $this->nameLower]);
    }
} catch (Throwable $e) {
    // Ignore - assets opzionali
}
```

### Pattern Sbagliato

```php
// ❌ SBAGLIATO: Fallimento hard
$assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
// Se fallisce, crasha tutto
```

## 📋 Regole di Implementazione

1. **Sempre try-catch per risorse opzionali**
2. **Verificare esistenza file/cartelle prima di usarle**
3. **Fallback silenzioso, non eccezioni**
4. **Logging opzionale per debugging**

---

**Filosofia**: Il sistema si adatta ai moduli, non viceversa.
