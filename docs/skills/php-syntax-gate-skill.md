# PHP Syntax Gate Skill

## Goal

Bloccare regressioni e perdite di tempo nei test eseguendo prima la validazione sintattica PHP.

## Steps

1. Eseguire `bashscripts/scripts/quality/php-lint-gate.sh`.
2. Registrare il numero di parse error.
3. Aprire/aggiornare issue blocker con evidenza.
4. Solo a errori zero avviare Pest coverage per modulo.
