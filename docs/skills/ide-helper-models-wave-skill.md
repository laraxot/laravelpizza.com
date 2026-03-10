# Skill: ide-helper models wave

## Trigger

Quando serve eseguire `php artisan ide-helper:models -W` o riallineare i PHPDoc dei modelli.

## Workflow

1. studiare docs dei modelli/moduli coinvolti;
2. aggiornare rule + memory + skill locali;
3. eseguire `php artisan ide-helper:models -W`;
4. se il comando fallisce su molte classi con errori di connessione, verificare il perimetro DB locale prima di cambiare `config/ide-helper.php`;
5. leggere il diff generato;
6. correggere eventuali regressioni di tipizzazione contract-first nei PHPDoc generati, in particolare `creator/updater/deleter -> \Modules\Xot\Contracts\ProfileContract|null`;
7. rilanciare `./vendor/bin/phpstan analyse Modules --no-progress`.

## Guardrail

- non usare ide-helper come generatore cieco;
- non nascondere blocchi ambientali dietro liste `ignored_models` non motivate;
- se il diff introduce rumore, correggere forward-only e documentare.
