# Composer Merge Plugin nel Modulo Lang

## Scopo
Permettere al modulo di includere pacchetti locali senza duplicare dipendenze nel `composer.json` root, mantenendo il processo semplice (DRY + KISS) e coerente con l'architettura modulare.

## Business logic e motivazione
Il modulo Lang gestisce localizzazione e traduzioni; i pacchetti locali consentono di estendere funzionalità senza pubblicare repository esterni. Il merge dei `composer.json` permette di trattare questi pacchetti come dipendenze interne, riducendo la frammentazione delle configurazioni.

## Flusso di integrazione
1. Il `composer.json` root include il plugin di merge e la configurazione `extra.merge-plugin`.
2. I `composer.json` dei pacchetti locali vengono inclusi via `include`.
3. Le dipendenze vengono risolte come se fossero dichiarate nel root.
4. Gli autoload dei pacchetti locali vengono registrati insieme al resto del progetto.

## Struttura attesa
- Pacchetti locali in `Modules/Lang/packages/<vendor>/<package>/composer.json`
- Nome pacchetto coerente con il `require` (campo `name`)
- Autoload dichiarato (PSR-4 o equivalente)
 - Repository `path` nel `composer.json` root per usare il pacchetto locale
 - Versione locale esplicita (es. `dev-local`) per vincoli chiari

## Regole operative
- Un solo punto di verità per le versioni: il root governa le versioni globali.
- Evitare pacchetti interni che richiedono versioni incompatibili con il root.
- Tenere le dipendenze del pacchetto interne al modulo, senza introdurre conflitti trasversali.
 - Usare `path` repository per forzare l'uso del pacchetto locale rispetto a Packagist.
 - Allineare i vincoli di `filament/filament` del pacchetto locale con quelli del root.

## Configurazione locale consigliata
- `composer.json` root:
  - `repositories` con `type: path` verso `Modules/Lang/packages/<vendor>/<package>`.
  - `extra.merge-plugin.include` per i `composer.json` dei moduli (se il plugin è attivo).
- `composer.json` del modulo:
  - `require` con versione locale esplicita (es. `dev-local`).
  - `repositories` con `type: path` verso il pacchetto locale (utile anche fuori dal root).

## Verifiche minime
- `composer validate` sul root.
- `composer dump-autoload` dopo ogni variazione ai pacchetti locali.
- `composer update` con focus sulle dipendenze coinvolte.

## Checklist
- Plugin di merge presente nel root.
- `extra.merge-plugin.include` contiene il percorso dei pacchetti locali.
- `name` del pacchetto locale coerente con il `require`.
- Autoload configurato e allineato alla struttura del pacchetto.
- Compatibilità di versioni verificata prima di aggiornare lockfile.

## Collegamenti correlati
- [Pacchetti del modulo](packages.md)
- [Installazione](installation.md)
- [Regole architetturali](architecture-rules.md)
- [Convenzioni link documentazione](documentation-link-conventions.md)
- [Modulo Lang](module-lang.md)
