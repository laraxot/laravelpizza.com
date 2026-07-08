# Miglioramenti al Prompt docs.txt

> **Collegamenti correlati**
> - [README.md documentazione generale](../../docs/README.md)
> - [Struttura dei Prompt](../../laravel/Modules/Xot/docs/prompts.md)
> - [Regole per i Prompt](../../laravel/Modules/Xot/docs/prompt_rules.md)
> - [README.md toolkit bashscripts](../README.md)

## Introduzione

Il file `/bashscripts/prompts/docs.txt` contiene un prompt utilizzato per guidare la documentazione nei progetti modulari Laravel. Questo documento descrive i miglioramenti apportati al prompt per renderlo completamente indipendente dal progetto e riutilizzabile.

## Miglioramenti Implementati

### 1. Rimozione Riferimenti Specifici al Progetto

- Rimossi tutti i riferimenti a percorsi assoluti specifici del progetto
- Sostituiti con percorsi relativi e placeholder generici
- Esempio: `public_html/` invece di `/var/www/html/[nome-progetto]/public_html/`

### 2. Miglioramento Descrizione Moduli

- Aggiornata la descrizione della competenza di ciascun modulo
- Esempio: "conformità GDPR in Gdpr" invece di "GDPR in Gdpr"
- Aggiunta descrizione più precisa per ogni modulo specializzato

### 3. Dettagli XotBaseResource

- Aggiunta nomenclatura corretta per le proprietà ($navigationIcon, $navigationGroup, $navigationSort)
- Aggiunta nomenclatura corretta per i metodi (getNavigationLabel(), getPluralModelLabel(), getModelLabel())
- Corretto il nome del metodo da "Actions()" a "getActions()"

### 4. Aggiunta Convenzione Chiavi di Traduzione

- Aggiunta la convenzione di naming esplicita: `modulo::risorsa.fields.campo.label`

### 5. Miglioramento Configurazione Vite

- Aggiunte impostazioni critiche: `emptyOutDir: false, manifest: 'manifest.json'`
- Queste impostazioni prevengono problemi di build degli asset

### 6. Aggiunta Best Practice per UserContract

- Aggiunta indicazione di utilizzare `Modules\Xot\Contracts\UserContract` invece di riferimenti diretti a `Modules\User\Models\User`
- Aggiunto metodo per ottenere la classe User configurata: `XotData::make()->getUserClass()`

### 7. Rimozione Contenuti non Documentati

- Rimossi tutti i riferimenti a pattern e pratiche non documentati nel progetto
- Rimossi tutti i riferimenti a implementazioni API non presenti nella documentazione

### 8. Aggiunta Riferimenti a File di Configurazione degli Editor

- Aggiunta istruzione di aggiornare i file di configurazione degli editor quando si modificano le regole di documentazione
- Specificati i percorsi esatti: `.windsurf/rules/*.md`, `.cursor/rules/*.md`, `.cursor/memories/*.md`, `.vscode/settings.json`
- Sottolineata l'importanza di mantenere sincronizzate queste configurazioni per garantire coerenza tra tutti gli editor e assistenti AI

## Applicazione della Regola Universale

Il prompt rimane conforme alla [Regola Universale](/laravel/Modules/Xot/docs/prompt_rules.md) per i prompt condivisi:
- È una singola stringa continua
- Non contiene formattazione
- Non contiene a capo

## Utilizzo

Il prompt aggiornato può essere utilizzato in qualsiasi progetto modulare Laravel senza modifiche, rendendo il modulo `bashscripts` completamente riutilizzabile.
