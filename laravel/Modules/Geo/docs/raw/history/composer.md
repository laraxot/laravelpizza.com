# Gestione Dipendenze Composer

## Descrizione
Il modulo Composer permette di gestire le dipendenze PHP del progetto Laravel.

## Comandi Disponibili
- `require`: Aggiunge una dipendenza
- `remove`: Rimuove una dipendenza
- `install`: Installa tutte le dipendenze
- `update`: Aggiorna le dipendenze
- `dump-autoload`: Rigenera l'autoloader
- `show`: Mostra le dipendenze installate
- `check`: Verifica lo stato delle dipendenze
- `geoip:update`: Aggiorna il database GeoIP
- `fund`: Mostra informazioni sui finanziamenti

## Utilizzo
1. Inserire il nome del pacchetto nel campo di input
2. Selezionare il comando desiderato
3. Cliccare sul pulsante del comando

## Note
- Verificare la compatibilità delle versioni
- Backup del `composer.json` prima di aggiornamenti
- Monitorare lo spazio su disco
- Verificare i permessi delle cartelle 

## Compatibilità Filament v5
- Filament v5 richiede `livewire/livewire` `^4.0`.
- Il plugin `pestphp/pest-plugin-livewire` in versione 4.x richiede PHP `^8.3` e Livewire `^4.0.1`.
- Se il progetto resta su PHP `^8.2`, rimuovere il plugin livewire di Pest per evitare conflitti di dipendenze.
- Dettagli modulo Xot: [Risoluzione conflitti Composer (Xot)](../laravel/Modules/Xot/docs/composer-conflict-resolution.md)

## Analisi Errori
### Conflitto dipendenze pacchetto locale
- **Errore**: `lara-zeus/spatie-translatable` richiede `filament/filament ^4.0`, in conflitto con il root `filament/filament ^5.0`.
- **Contesto**: pacchetto locale incluso via merge di `composer.json` del modulo Lang.
- **Impatto**: `composer update -W` fallisce durante la risoluzione.
- **Mitigazione**: allineare i vincoli di versione del pacchetto locale ai vincoli root o sostituire il pacchetto con alternativa compatibile.
- **Dettagli modulo**: [Composer merge plugin (Lang)](../laravel/Modules/Lang/docs/composer-merge-plugin.md)