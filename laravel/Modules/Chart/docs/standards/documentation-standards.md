# Best Practice di Documentazione

## Principi Fondamentali

### 1. Struttura Documentazione
- Ogni modulo deve avere una cartella `docs`
- Ogni file `.md` importante deve essere referenziato da almeno 5 altri file
- Usare collegamenti bidirezionali per garantire tracciabilità

### 2. Contenuto Documentazione
- Documentare SEMPRE prima di implementare
- Aggiornare la documentazione dopo ogni modifica
- Includere esempi di codice e spiegazioni dettagliate

### 3. Collegamenti
- Ogni file `.md` importante deve essere referenziato da almeno 5 altri file
- Usare collegamenti bidirezionali per garantire tracciabilità
- Mantenere aggiornati i collegamenti

## Esempio di Implementazione

### 1. Struttura Cartelle
```
docs/
├── standards/
│   ├── migrations.md
│   ├── error-handling.md
│   ├── single-table-inheritance.md
│   ├── validation.md
│   └── documentation.md
├── modules/
│   ├── doctor/
│   │   ├── models.md
│   │   ├── actions.md
│   │   └── resources.md
│   └── patient/
│       ├── models.md
│       ├── actions.md
│       └── resources.md
└── architecture/
    ├── structure.md
    └── patterns.md
```

### 2. Esempio di File
```markdown

# Titolo

## Descrizione
Breve descrizione del contenuto.

## Collegamenti
- [Migrations](standards/migrations.md)
- [Error Handling](standards/error-handling.md)
- [Single Table Inheritance](standards/single-table-inheritance.md)
- [Validation](standards/validation.md)
- [Documentation](standards/documentation.md)

## Contenuto
Dettagli del contenuto.

## Esempi
```php
// Esempio di codice
```

## Note
Note aggiuntive.
```

### 3. Collegamenti Bidirezionali
```markdown

# File A

## Collegamenti
- [File B](file-b.md)
- [File C](file-c.md)
- [File D](file-d.md)
- [File E](file-e.md)
- [File F](file-f.md)

# File B

## Collegamenti
- [File A](file-a.md)
- [File C](file-c.md)
- [File D](file-d.md)
- [File E](file-e.md)
- [File F](file-f.md)
```

## Errori Comuni

### 1. Documentazione Mancante
❌ Non documentare prima di implementare
✅ Documentare SEMPRE prima di implementare

### 2. Collegamenti Mancanti
❌ Non referenziare file importanti
✅ Ogni file `.md` importante deve essere referenziato da almeno 5 altri file

### 3. Documentazione Non Aggiornata
❌ Non aggiornare la documentazione dopo modifiche
✅ Aggiornare SEMPRE la documentazione dopo ogni modifica

## Checklist

### Prima di Creare un Nuovo File
- [ ] Struttura cartelle corretta
- [ ] Collegamenti bidirezionali
- [ ] Esempi di codice
- [ ] Note aggiuntive

### Prima di Modificare un File Esistente
- [ ] Aggiorna la documentazione
- [ ] Verifica collegamenti
- [ ] Test di regressione 
