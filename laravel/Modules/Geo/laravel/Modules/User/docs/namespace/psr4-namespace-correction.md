# Correzione Namespace PSR-4

## Problema

Il sistema rileva errori di autoloading PSR-4 in diversi file del progetto:

```
Class Modules\User\Enums\LanguageEnum located in ./Modules/User/app/Enums/Enums/LanguageEnum.php does not comply with psr-4 autoloading standard
Class App\Filament\Blocks\Page located in ./Modules/UI/app/Filament/Blocks/Page.php does not comply with psr-4 autoloading standard
```

## Cause dell'errore

Esistono due problemi principali:

1. **Directory duplicata**: Il file LanguageEnum.php è posizionato erroneamente in una directory `Enums/Enums` anziché in `Enums`
2. **Namespace errato**: I file Blocks in Modules/UI hanno namespace `App\Filament\Blocks` invece del corretto `Modules\UI\Filament\Blocks`

## Soluzione

### Per LanguageEnum

1. Verificare se esiste un file duplicato in `Modules/User/app/Enums/Enums/LanguageEnum.php`
2. Se esiste, rimuovere il file duplicato
3. Assicurarsi che il file in `Modules/User/app/Enums/LanguageEnum.php` abbia il namespace corretto `Modules\User\Enums`

### Per i file Block in Modules/UI

1. Correggere il namespace di ciascun file da `App\Filament\Blocks` a `Modules\UI\Filament\Blocks`
2. Eseguire un audit di tutte le classi che potrebbero referenziare questi blocchi e aggiornare i riferimenti

## Best Practice PSR-4

La regola PSR-4 richiede che:

1. Il namespace completo della classe corrisponda al percorso del file
2. La base del namespace sia mappata alla directory base nell'autoloader
3. Per i moduli Laravel, il namespace base è `Modules\NomeModulo\` mappato a `Modules/NomeModulo/app/`

### Esempio corretto:
- File: `Modules/UI/app/Filament/Blocks/Page.php`
- Namespace corretto: `Modules\UI\Filament\Blocks`
- Classe: `Page`

### Esempio errato:
- File: `Modules/UI/app/Filament/Blocks/Page.php`
- Namespace errato: `App\Filament\Blocks`
- Classe: `Page`
