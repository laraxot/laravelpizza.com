# Modifiche alla Migrazione Mail Templates

## Modifiche Effettuate

### File: `2018_10_10_000002_create_mail_templates_table.php`

#### Modifiche Strutturali
1. **Cambio di ID**
   - Da: `$table->increments('id')`
   - A: `$table->id()`
   - Motivo: Standardizzazione con le best practices di Laravel per l'uso di ID auto-incrementali

2. **Campi JSON**
   - Da: `$table->json('subject')->nullable()`
   - A: `$table->json('subject')`
   - Da: `$table->json('html_template')->nullable()`
   - A: `$table->json('html_template')`
   - Motivo: I campi subject e html_template sono essenziali per il funzionamento del template

3. **Aggiunta Versione**
   - Aggiunto: `$table->string('version')->default('1.0.0')`
   - Motivo: Tracciamento delle versioni dei template per gestire aggiornamenti e compatibilità

4. **Aggiunta Slug**
   ```php
   $this->tableUpdate(function (Blueprint $table): void {
       if (! $this->hasColumn('slug')) {
           $table->string('slug')->unique()->after('mailable');
       }
       $this->updateTimestamps($table);
   });
   ```
   - Motivo: Identificazione univoca e leggibile dei template

## Motivazioni delle Modifiche

1. **Standardizzazione**
   - Allineamento con le best practices di Laravel
   - Migliore integrazione con il framework Xot
   - Coerenza con altri moduli del sistema

2. **Migliore Gestione dei Template**
   - Tracciamento versioni per aggiornamenti
   - Identificazione univoca tramite slug
   - Campi obbligatori per garantire l'integrità dei dati

3. **Manutenibilità**
   - Struttura più chiara e documentata
   - Facile estensione futura
   - Migliore gestione delle dipendenze

## Impatto sulle Funzionalità

1. **Template Esistenti**
   - Necessaria migrazione dei dati
   - Generazione automatica degli slug
   - Aggiornamento delle versioni

2. **Nuovi Template**
   - Richiesto slug univoco
   - Versione iniziale 1.0.0
   - Campi subject e html_template obbligatori

3. **API e Interfacce**
   - Aggiornamento della documentazione
   - Modifica delle query di ricerca
   - Adattamento delle interfacce utente

## Piano di Migrazione

1. **Fase 1: Preparazione**
   ```php
   // Generazione slug per template esistenti
   MailTemplate::all()->each(function ($template) {
       $template->slug = Str::slug($template->mailable);
       $template->save();
   });
   ```

2. **Fase 2: Validazione**
   - Verifica unicità degli slug
   - Controllo integrità dei dati
   - Test delle funzionalità

3. **Fase 3: Deployment**
   - Backup dei dati
   - Esecuzione migrazione
   - Verifica post-migrazione

## Collegamenti Correlati

- [Regole Migrazioni](./MIGRATION_RULES.md)
- [Documentazione Template](./EMAIL_TEMPLATES.md)
- [Best Practices Database](../../../docs/best-practices/database.md)
- [Proposta Slug Template](./EMAIL_TEMPLATE_SLUG_PROPOSAL.md) 
