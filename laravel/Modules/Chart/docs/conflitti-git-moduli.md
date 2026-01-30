# Documentazione sulla Risoluzione dei Conflitti Git nei Moduli

Questo documento fornisce collegamenti alla documentazione specifica sulla risoluzione dei conflitti Git in ciascun modulo del progetto.

## Linee Guida Generali

- [Linee Guida per la Risoluzione dei Conflitti Git](./risoluzione_conflitti_git.md)

## Documentazione per Modulo

### Modulo Xot

- [Risoluzione Conflitti di Merge](../laravel/Modules/Xot/docs/RISOLUZIONE_CONFLITTI_MERGE.md)
- [Risoluzione Conflitti Composer](../laravel/Modules/Xot/docs/composer_conflict_resolution.md)

### Modulo Gdpr

- [Conflitti Merge Risolti](../laravel/Modules/Gdpr/docs/CONFLITTI_MERGE_RISOLTI.md)

### Modulo Media

- [Risoluzione Conflitti SubtitleService](../laravel/Modules/Media/docs/risoluzione_conflitti_subtitleservice.md)
- [Correzioni PHPStan Livello 10](../laravel/Modules/Media/docs/PHPSTAN_LEVEL10_FIXES.md)

## Best Practice

1. **Risoluzione sistematica**: Affrontare un conflitto alla volta
2. **Documentazione**: Aggiornare la documentazione locale e root
3. **Test**: Verificare che la soluzione funzioni correttamente
4. **Collegamenti bidirezionali**: Mantenere aggiornati i collegamenti tra docs root e docs locali
5. **Percorsi relativi**: Utilizzare sempre percorsi relativi nei collegamenti

## Strumenti Utili

- Script per la verifica dei conflitti: `./bashscripts/check_git_conflicts.sh`
- Test automatici per verificare l'assenza di marker di conflitto

# Conflitti Git nei Moduli

> **Nota**: Per una versione più aggiornata e dettagliata di questa documentazione, consulta [Conflict Resolution Bash in Bashscripts](../bashscripts/docs/CONFLICT_RESOLUTION_BASH.md)

## Collegamenti tra versioni di conflitti_git_moduli.md
* [CONFLICT_RESOLUTION_BASH.md](../bashscripts/docs/CONFLICT_RESOLUTION_BASH.md)
* [conflitti_git_moduli.md](conflitti_git_moduli.md)
