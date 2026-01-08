# Regola del Buon Boy Scout - Progetto <nome progetto>

## Principio Fondamentale
**"Lascia il campo più pulito di come l'hai trovato"**

## Significato e Importanza
Questa regola è **SACRA** e **IMMUTABILE** nel progetto <nome progetto>. Ogni modifica al codice deve migliorare la codebase, non peggiorarla. La qualità del codice è responsabilità di ogni sviluppatore.

## Applicazione Globale

### In Tutti i Moduli
- **<nome progetto>**: Factory, seeder, modelli e documentazione
- **User**: Autenticazione, autorizzazione e gestione utenti
- **UI**: Componenti, widget e interfacce
- **Xot**: Funzionalità base e convenzioni

### In Tutti i File
- **PHP**: Codice più pulito, tipizzato e documentato
- **Markdown**: Documentazione completa e aggiornata
- **Blade**: Template organizzati e riutilizzabili
- **Config**: Configurazioni chiare e documentate

## Esempi di Applicazione

### Factory e Seeder
```php
// PRIMA: Errori e colonne non esistenti
'birth_date' => now()->subYears(random_int(18, 80)), // ❌ Colonna inesistente

// DOPO: Factory corretta e tipizzata  
'date_of_birth' => now()->subYears(random_int(18, 80)), // ✅ Colonna corretta
```

### Documentazione
```markdown
// PRIMA: Documentazione frammentaria
# Factory
- PatientFactory
- DoctorFactory

// DOPO: Documentazione completa
# Factory e Seeder
## PatientFactory
- Campi principali e specifici
- Stati personalizzati disponibili
- Esempi di utilizzo
- Best practices
```

## Checklist di Verifica Globale

### Prima di ogni modifica:
- [ ] Ho studiato la documentazione esistente?
- [ ] Ho compreso la struttura del progetto?
- [ ] Ho identificato le aree di miglioramento?

### Durante la modifica:
- [ ] Sto migliorando il codice esistente?
- [ ] Sto seguendo le convenzioni del progetto?
- [ ] Sto documentando le modifiche?

### Dopo la modifica:
- [ ] Il codice è più pulito di prima?
- [ ] La documentazione è stata aggiornata?
- [ ] I test passano e sono migliorati?
- [ ] La struttura è più organizzata?

## Responsabilità nel Progetto

### Sviluppatore:
- Applicare SEMPRE la regola del buon boy scout
- Migliorare il codice esistente
- Aggiornare sempre la documentazione

### Team Lead:
- Verificare il rispetto della regola
- Rifiutare modifiche che degradano la qualità
- Promuovere miglioramenti continui

### Code Review:
- Verificare sempre il rispetto della regola
- Richiedere miglioramenti se necessario
- Non approvare mai degradazioni del codice

## Anti-Pattern da Evitare

1. **"Fix later"**: Mai lasciare TODO o commenti di fix futuro
2. **"Works for me"**: Mai accettare codice che funziona ma è sporco
3. **"Quick fix"**: Mai fare modifiche rapide senza pulizia
4. **"Someone else will fix it"**: Mai delegare la pulizia ad altri
5. **"It's not my code"**: Mai ignorare problemi nel codice esistente

## Collegamenti

- [Regola Cursor](../../.cursor/rules/boy-scout-rule.mdc)
- [Regola <nome progetto>](../laravel/Modules/<nome progetto>/docs/boy-scout-rule.md)
- [Convenzioni Laraxot](laraxot-conventions.md)
- [Best Practices](best-practices.md)

---

**⚠️ RICORDA SEMPRE: Questa regola è SACRA e non può essere violata. Ogni modifica deve migliorare la codebase.**


