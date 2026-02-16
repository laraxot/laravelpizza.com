# Changelog Migrazioni Notify Module

## 2024-03-20: Aggiunta Campo Slug a Mail Templates

### Modifiche
- Aggiunto campo `slug` alla tabella `mail_templates`
- Implementato nella sezione `tableUpdate` della migrazione originale
- Aggiunto controllo di esistenza colonna

### Motivazioni
1. **Miglioramento Identificazione Template**
   - Riferimento stabile e prevedibile ai template
   - Indipendenza dalla classe Mailable
   - Facilità di migrazione

2. **Struttura Standardizzata**
   - Seguito pattern `XotBaseMigration`
   - Implementato nella sezione `tableUpdate` esistente
   - Mantenuta retrocompatibilità

3. **Best Practices**
   - Verifica esistenza colonna prima dell'aggiunta
   - Utilizzo metodi helper di `XotBaseMigration`
   - Documentazione completa delle modifiche

### Impatto
- Miglioramento gestione template
- Nessun impatto su dati esistenti
- Mantenuta compatibilità con codice esistente

### Collegamenti Correlati
- [Proposta Slug](./SPATIE_EMAIL_SLUG_PROPOSAL.md)
- [Sistema Template Email](./EMAIL_TEMPLATES.md)
- [Email Dottori](./DOCTOR_EMAILS.md) 
