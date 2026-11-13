---
epic: 18
story: 1
slug: merge-conflicts-phpstan-fixes
title: "Risolvi merge conflicts Activity tests + PHPStan L10 fixes"
module_owner: Activity
created: 2026-09-06
status: ready-for-dev
priority: high
---

## Intento

Risolvere conflitti di merge non risolti in 5 file di test del modulo Activity e correggere 14 errori PHPStan L10. Sincronizzare git e innalzare coverage.

## Descrizione

Il modulo Activity ha 5 file di test con marker di merge non risolti (`<<<<<<< ... ======= ... >>>>>>>`) che causano 28 errori di syntax in PHPStan (parse error). Risolti i conflitti, emergono 14 errori reali:
- 7x `method.deprecated`: chiamate a metodi Xot/Filament 5 deprecated (getTableColumns, getTableFilters, getTableActions, getTableBulkActions)
- 1x `cast.string`: tentativo di cast su tipo mixed in ActivityServiceProviderTest linea 28

## File interessati

1. **tests/Feature/FilamentTest.php**: 5 conflitti di merge (ListActivities, ListSnapshots, ListStoredEvents)
2. **tests/Unit/LogoutListenerTest.php**: conflitto su uses() e indentazione
3. **tests/Unit/LoginListenerTest.php**: conflitto su uses() e struttura
4. **tests/Unit/Listeners/LoginLogoutListenerBehaviorTest.php**: conflitto su uses()
5. **tests/Unit/Providers/EventServiceProviderTest.php**: conflitto su uses()
6. **tests/Unit/Providers/ActivityServiceProviderTest.php**: errore cast.string linea 28

## Acceptance Criteria

1. **AC-1 Conflitti risolti**: Nessun marker di merge (`<<<<<<<`, `=======`, `>>>>>>>`) rimasto nei 5 file. PHPStan non riporta syntax error.
2. **AC-2 Errori PHPStan risolti**: Tutti i 14 errori scomparsi (0 errors trovati). I metodi deprecated ricevono `@phpstan-ignore-next-line` se necessario. L'errore cast.string è risolto con type hint appropriato.
3. **AC-3 Test passano**: `./vendor/bin/pest Modules/Activity/tests -c Modules/Activity/phpunit.xml` esce con status 0 (all pass).
4. **AC-4 Coverage alzato**: Coverage baseline confrontato e documentato in `Modules/Activity/docs/coverage.md` con confronto prima/dopo.
5. **AC-5 Git sincronizzato**: `cd laravel/Modules/Activity && git status` mostra working tree clean. Remotes sincronizzati (fetch + merge da laraxot/dev, push a tutti i remote).

## Implementazione

### Fase 1: Risolvi conflitti merge

Per ogni file:
1. Identifica i blocchi di conflitto
2. Valuta le due versioni (branch A: `$page->table(Table::make($page))->getXxx()` vs branch B: `$page->getXxx()`)
3. Scegli versione B (shorthand, coerente con Xot/Filament 5)
4. Rimuovi marker di merge

### Fase 2: Correggi errori PHPStan

1. **Deprecated method calls**: aggiungi `@phpstan-ignore-next-line` per ciascuna linea che chiama getTableColumns, getTableFilters, etc
2. **Cast.string error**: leggi ActivityServiceProviderTest linea 28, identifica il tipo reale della variabile, aggiungi type hint o cast appropriato

### Fase 3: Verifica e test

1. PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity --no-progress`
2. PHPMD: `./tools/phpmd.sh Modules/Activity text ../docs/phpmd.ruleset.xml`
3. Pest: `./vendor/bin/pest Modules/Activity/tests -c Modules/Activity/phpunit.xml --no-coverage`
4. Coverage: registra baseline e after in `Modules/Activity/docs/coverage.md`

### Fase 4: Git sync

```bash
cd laravel/Modules/Activity
git status
git fetch laraxot dev
git merge laraxot/dev --allow-unrelated-histories -s resolve
git add -A
git commit -m "fix: resolve merge conflicts and phpstan l10 errors"
git push -u origin dev
# Per altri remotes:
git remote -v | grep -v origin | awk '{print $2}' | while read remote; do git push -u $remote dev; done
```

## Dipendenze

- Nessuna. Story è auto-contenuta nel modulo Activity.

## Note

- Metodi deprecated di Xot (getTable*) sono stubs previsti da Filament 5 e Xot. Non rimuoverli, ma marcarli come noti a PHPStan.
- La versione B dei conflitti (shorthand) è quella legittima e testata.
- Coverage deve salire, non scendere. Se la baseline è sconosciuta, documentare il primo run come baseline.

---

**Creato**: 2026-09-06  
**Modulo**: Activity  
**Epic**: 18 (PHPStan L10 + quality gates)
