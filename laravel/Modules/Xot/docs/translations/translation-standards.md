- **Documentazione**: [Progressioni Translation System](../../laravel/Modules/Progressioni/docs/translation-system.md)

#### File Completati
1. `progressioni.php` - Traduzioni principali
2. `schede.php` - Gestione schede di valutazione
3. `valutatore.php` - Gestione valutatori
4. `criteri_valutazione.php` - Criteri di valutazione
5. `stipendio_tabellare.php` - Stipendi tabellari
6. `ced_diff.php` - Differenze CED
7. `max_cateco_posfun_anno.php` - Massimi categoria/posizione funzionale
8. `coeff.php` - Coefficienti
9. `scheda_criteri.php` - Schede criteri
10. `criteri_option.php` - Opzioni criteri
11. `categoria_propro.php` - Categorie ProPro
12. `stabi_dirigente.php` - Dirigenti di stabilimento
13. `pesi.php` - Pesi
14. `criteri_precedenza.php` - Criteri di precedenza
15. `my_log.php` - Log personali

### 🔄 Altri Moduli (Da Standardizzare)
- **Performance**: Parzialmente standardizzato
- **User**: Parzialmente standardizzato
- **Altri moduli**: Da analizzare e standardizzare

## Problemi Comuni e Soluzioni

### 1. Riferimenti Circolari
```php
// ❌ ERRATO
'label' => 'ced diff.navigation',

// ✅ CORRETTO
'label' => 'Differenze CED',
```

### 2. Struttura Semplice
```php
// ❌ ERRATO
'name' => 'Nome',

// ✅ CORRETTO
'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Nome identificativo',
],
```

### 3. Sintassi Obsoleta
```php
// ❌ ERRATO
return array(
    'field' => array(
        'label' => 'Etichetta',
    ),
);

// ✅ CORRETTO
return [
    'field' => [
        'label' => 'Etichetta',
    ],
];
```

## Checklist Standardizzazione

### ✅ Analisi e Documentazione
- [x] Analisi struttura attuale del modulo
- [x] Identificazione problemi e inconsistenze
- [x] Documentazione convenzioni e standard
- [x] Creazione piano di migrazione

### ✅ Implementazione Standard
- [x] Conversione struttura semplice a espansa
- [x] Rimozione riferimenti circolari
- [x] Aggiornamento sintassi moderna
- [x] Aggiunta PHPDoc e commenti

### ✅ Miglioramenti Qualità
- [x] Traduzioni specifiche per dominio
- [x] Placeholder e help text contestuali
- [x] Messaggi di successo/errore appropriati
- [x] Coerenza terminologica

### 🔄 Completamento
- [ ] Standardizzazione file rimanenti
- [ ] Test funzionali delle traduzioni
- [ ] Verifica PHPStan per tutti i file
- [ ] Aggiornamento documentazione finale

## Best Practice

### 1. Organizzazione
- Suddividere le traduzioni in file separati per contesto
- Mantenere una struttura coerente tra i diversi moduli
- Utilizzare nomi di chiavi coerenti per concetti simili

### 2. Completezza
- Includere sempre label, placeholder e help text per ogni campo
- Includere messaggi per tutti gli stati (success, error, empty, ecc.)
- Documentare opzioni per campi select e similari

### 3. Manutenzione
- Aggiornare le traduzioni quando si modificano le funzionalità
- Rimuovere le traduzioni non più utilizzate
- Verificare regolarmente la coerenza tra le traduzioni

### 4. Tipizzazione
- Utilizzare `declare(strict_types=1);` in tutti i file
- Aggiungere PHPDoc completo per ogni file
- Utilizzare sintassi moderna degli array

## Collegamenti

- [Progressioni Translation System](../../laravel/Modules/Progressioni/docs/translation-system.md)
- [Xot Best Practices](../../laravel/Modules/Xot/docs/translations-best-practices.md)
- [Laraxot Conventions](laraxot-conventions.md)

## Note Tecniche

### Problemi Risolti nel Modulo Progressioni
1. **Riferimenti Circolari**: Eliminati tutti i riferimenti che causavano loop
2. **Sintassi Obsoleta**: Convertita da `array()` a `[]`
3. **Struttura Inconsistente**: Standardizzata in tutti i file
4. **Traduzioni Generiche**: Sostituite con traduzioni specifiche

### Best Practice Applicate
1. **Tipizzazione Stretta**: `declare(strict_types=1);` in tutti i file
2. **Documentazione**: PHPDoc completo per ogni file
3. **Organizzazione**: Struttura gerarchica coerente
4. **Naming**: Convenzioni standardizzate

*Ultimo aggiornamento: Giugno 2025*
---
module: theme
topic: translation-standards
canonical: ../../../../Themes/docs/shared-components/translation-standards-Modules.md
---

See canonical documentation: ../../../../Themes/docs/shared-components/translation-standards-Modules.md