# Regole Critiche per il Posizionamento della Documentazione

## ⚠️ REGOLA CRITICA: POSIZIONAMENTO DOCUMENTAZIONE

**ERRORE GRAVE**: Posizionare documentazione specifica di un modulo nella cartella docs generica invece che nella cartella docs del modulo specifico.

## Struttura Corretta della Documentazione

### 1. Documentazione Generica (Progetto-wide)
**Posizione**: `/var/www/html/_bases/base_<nome progetto>/docs/`
- Regole generali del progetto
- Pattern architetturali comuni
- Best practices globali
- Documentazione di sistema

### 2. Documentazione Specifica Modulo
**Posizione**: `/var/www/html/_bases/base_<nome progetto>/laravel/Modules/{ModuleName}/docs/`
- Documentazione specifica del modulo
- Widget del modulo
- Resource del modulo
- Pattern specifici del modulo

## Esempi di Posizionamento Corretto

### ✅ CORRETTO - Documentazione Modulo Specifica
```
/var/www/html/_bases/base_<nome progetto>/laravel/Modules/SaluteMo/docs/
├── appointment-states-overview-widget.md
├── appointment-resource.md
├── models/
│   └── appointment.md
└── widgets/
    └── appointment-widgets.md
```

### ❌ ERRATO - Documentazione nella Cartella Generica
```
/var/www/html/_bases/base_<nome progetto>/docs/
├── widgets/
│   └── appointment-states-overview-widget.md  # ❌ ERRORE GRAVE
```

## Regole di Decisione

### Quando Usare `/docs/` (Generica)
- **Regole globali**: Pattern che si applicano a tutti i moduli
- **Architettura**: Documentazione del sistema Laraxot
- **Best practices**: Convenzioni generali
- **Setup**: Configurazione del progetto

### Quando Usare `/laravel/Modules/{ModuleName}/docs/` (Specifica)
- **Widget specifici**: Widget di un modulo particolare
- **Resource specifiche**: Resource di un modulo particolare
- **Model specifici**: Documentazione di modelli specifici
- **Pattern specifici**: Pattern utilizzati solo in quel modulo

## Checklist di Verifica

Prima di creare qualsiasi documentazione, verificare:

1. **Il contenuto è specifico di un modulo?**
   - ✅ Sì → Usare `/laravel/Modules/{ModuleName}/docs/`
   - ❌ No → Usare `/docs/`

2. **Il contenuto si applica a tutto il progetto?**
   - ✅ Sì → Usare `/docs/`
   - ❌ No → Usare `/laravel/Modules/{ModuleName}/docs/`

3. **Il contenuto è un widget/resource di un modulo specifico?**
   - ✅ Sì → **OBBLIGATORIO** `/laravel/Modules/{ModuleName}/docs/`
   - ❌ No → Verificare altri criteri

## Errori Comuni da Evitare

### ❌ ERRORE GRAVE: Widget in Cartella Generica
```php
// ❌ ERRORE GRAVE
/var/www/html/_bases/base_<nome progetto>/docs/widgets/appointment-widget.md

// ✅ CORRETTO
/var/www/html/_bases/base_<nome progetto>/laravel/Modules/SaluteMo/docs/appointment-widget.md
```

### ❌ ERRORE GRAVE: Resource in Cartella Generica
```php
// ❌ ERRORE GRAVE
/var/www/html/_bases/base_<nome progetto>/docs/resources/appointment-resource.md

// ✅ CORRETTO
/var/www/html/_bases/base_<nome progetto>/laravel/Modules/SaluteMo/docs/appointment-resource.md
```

## Penalità per Violazioni

- **Prima violazione**: Correzione immediata + documentazione della regola
- **Violazioni ripetute**: Rischio di perdita di fiducia nell'assistente
- **Violazioni gravi**: Possibile interruzione del lavoro

## Processo di Correzione

Se viene rilevato un errore di posizionamento:

1. **Eliminare immediatamente** il file dalla posizione errata
2. **Ricreare il file** nella posizione corretta
3. **Aggiornare le regole** per evitare ripetizioni
4. **Documentare l'errore** per apprendimento futuro

## Note Importanti

- **SEMPRE** verificare il contesto prima di creare documentazione
- **SEMPRE** usare la cartella docs del modulo per contenuti specifici
- **MAI** posizionare documentazione specifica di modulo nella cartella generica
- **SEMPRE** seguire la struttura gerarchica del progetto 