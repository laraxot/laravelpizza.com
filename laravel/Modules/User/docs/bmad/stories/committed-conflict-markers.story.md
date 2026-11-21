---
title: "Story: Ripristino migrazione e traduzioni User dopo conflitto"
type: story
module: User
status: review
created: 2026-10-06
updated: 2026-10-06
---

# Claim ed esito

## Claim

Verificare la migrazione dei permessi e le traduzioni italiane User interessate dai marker,
ricostruendo solo contenuto dimostrabile dalla cronologia e mantenendo le modifiche presenti.
Controllare sintassi PHP su tutto il modulo.

## Esito

- Scan `python3 bashscripts/tools/resolve_merge_blocks.py --help`: zero file con marker in
  `HEAD`, zero file scritti (`apply=False`), zero restore da blob. I marker segnalati
  dall'aggiornamento erano quindi modifiche di worktree, non contenuto di `HEAD`.
- Non è stato ripristinato alcun file dal blob `HEAD` né sovrascritto lavoro preesistente.
  Prima delle verifiche, il contenuto marker-free di migrazione e traduzione è stato confrontato
  con gli ultimi 80 commit per path: entrambi risultavano sottosequenza completa del blob pulito
  più recente `432dd7230d90` (45/45 e 267/267 righe). Ciò documenta provenienza/semantica,
  non autorizza a sostituire file worktree.
- Migrazione: conserva invalidazione condizionale della cache Spatie e ignora errori cache
  durante package discovery; non introduce operazioni schema. Traduzione: preserva le azioni
  `submit` e `cancel`, incluse label, icone e tooltip.
- La scansione PHP del worktree non rileva marker Git in User; nessun file applicativo è stato
  modificato in questo intervento.

## Criteri di accettazione

- [x] Scansione `php -l` completata su 1.778 file PHP del modulo: nessun errore.
- [x] `php -l` positivo sui due file noti.
- [x] Comportamento cache migrazione e azioni traduzione `submit`/`cancel` preservati.
- [ ] Pest mirato: non eseguibile; `Pest\TestSuite` manca nel vendor. Comando:
  `cd laravel && ./vendor/bin/pest Modules/User/tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php`
  (exit 255).
- [x] Nessun PHPStan globale né commit.

## Riferimenti

- Regola: `bashscripts/ai/wiki/rules/committed-conflict-markers.md`
- Migrazione: `laravel/Modules/User/database/migrations/2023_01_01_093340_create_permission_table.php`
- Traduzioni: `laravel/Modules/User/lang/it/profile.php`
