---
tags: [documentation]
updated: 2026-09-26
qmd: "ai phpstan getformschema fix 2026 09 10.story"
issues: []
discussions: []
title: "PHPStan fix - AiActionProposal getFormSchema/getInfolistSchema override illegale + typo TestCase"
status: done
type: story
created: 2026-09-10
agente: claude-sonnet5-qgates-swarm-AI
---

# PHPStan fix - AiActionProposal getFormSchema/getInfolistSchema override illegale + typo TestCase

**Fase BMAD**: Build + Measure.

## Contesto

4 errori PHPStan segnalati su `Modules/AI` (config `laravel/phpstan.neon`, livello invariato,
nessuna modifica al file):

1. `AiActionProposalResource.php:23` — `method.parentMethodFinal`: `getFormSchema()`
   sovrascrive un metodo ormai `final` su `Modules\Xot\Filament\Resources\XotBaseResource`.
2. `AiActionProposalResource.php:25` — `method.staticCall`: chiamata statica a un metodo
   di istanza `AiActionProposalForm::getFormSchema()`.
3. `AiActionProposalResource/Pages/ViewAiActionProposal.php:25` — `method.staticCall`:
   chiamata statica a un metodo di istanza `AiActionProposalInfolist::getInfolistSchema()`.
4. `Modules/AI/tests/TestCase.php` — `method.notFound`: `$this->prepareSharedFixcitySqliteForTesting()`
   non esiste.

Root cause #1/#2: stessa regressione documentata in `Modules/Xot/docs/stories/18.19.xotbaseresource-final-getformschema-table-illegal-override-repo-wide-fix.story.md`
e `18.21.getformschema-ownership-regressione-e-guardia.story.md` — `XotBaseResourceForm::getFormSchema()`
e' l'unica sede legittima (istanza, `abstract`), la Resource non deve piu' dichiararlo:
`XotBaseResource::getFormClass()` risolve automaticamente `{Resource}\Schemas\{Model}Form`
per convenzione, quindi l'override nella Resource e' solo codice morto duplicato.

Root cause #3: stessa famiglia — `AiActionProposalInfolist::getInfolistSchema()` e' un
metodo di istanza (estende `XotBaseResourceInfolist`), la Page lo chiamava come statico.

Root cause #4: typo/drift di naming. Il metodo reale e' `prepareSharedSqliteForTesting()`
(senza "Fixcity"), definito in `Modules/Xot/tests/XotBaseTestCase.php:288` e gia' usato
correttamente da Geo/UI/Activity/Notify/User.

## Cosa ho corretto

### 1+2. `Modules/AI/app/Filament/Resources/AiActionProposalResource.php`
Rimosso interamente l'override `public function getFormSchema(): array { return
AiActionProposalForm::getFormSchema(); }` (era codice morto duplicato: `AiActionProposalForm`
gia' dichiara correttamente la propria `getFormSchema()` di istanza, ereditata da
`XotBaseResourceForm`). Rimossi anche gli `use` non piu' necessari (`Filament\Schemas\Components\Component`,
`AiActionProposalForm`).

### 3. `Modules/AI/app/Filament/Resources/AiActionProposalResource/Pages/ViewAiActionProposal.php`
```php
// prima
return AiActionProposalInfolist::getInfolistSchema();
// dopo
return app(AiActionProposalInfolist::class)->getInfolistSchema();
```
Idioma gia' in uso altrove nel repo (es. `Modules/Activity/tests/...`) per risolvere
l'istanza dal container invece di una chiamata statica illegale su metodo di istanza.

### 4. `Modules/AI/tests/TestCase.php`
```php
// prima
$this->prepareSharedFixcitySqliteForTesting();
// dopo
$this->prepareSharedSqliteForTesting();
```
Solo rinomina del call site per allinearlo al metodo reale ereditato da `XotBaseTestCase`.
Nessun nuovo metodo creato.

## Verifica

- `php -l` sui 3 file toccati: nessun errore di sintassi.
- `vendor/bin/pint --test` sui 3 file toccati: `{"tool":"pint","result":"passed"}`.
- `./vendor/bin/phpstan analyse <3 file> --no-progress --memory-limit=-1`: **[OK] No errors**.
- `./vendor/bin/phpstan analyse Modules/AI --no-progress --memory-limit=-1`: **[OK] No errors**
  (nessuna regressione sul resto del modulo dopo la rimozione degli `use` non piu' necessari).

Non eseguito Pest: fix puramente di analisi statica + rename di call site, nessun
comportamento runtime nuovo da coprire (il metodo `prepareSharedSqliteForTesting()` gia'
testato altrove; `getFormSchema`/`getInfolistSchema` restano identici nel contenuto,
cambia solo chi li possiede/come vengono invocati).

## File toccati

- `app/Filament/Resources/AiActionProposalResource.php` — rimosso override illegale `getFormSchema()`.
- `app/Filament/Resources/AiActionProposalResource/Pages/ViewAiActionProposal.php` — static call -> `app(...)->getInfolistSchema()`.
- `tests/TestCase.php` — rinominata chiamata a `prepareSharedSqliteForTesting()`.

## Protocollo lock

Tutti e 3 i file: `check.sh` (FREE) -> `lock.sh "phpstan-ai-fix" "claude-sonnet5-qgates-swarm-AI"`
-> edit -> verifica -> `unlock.sh`. Nessun lock rubato, nessun conflitto rilevato.

## DoD

- [x] Errore 1 (`method.parentMethodFinal`) risolto.
- [x] Errore 2 (`method.staticCall` su `AiActionProposalForm`) risolto.
- [x] Errore 3 (`method.staticCall` su `AiActionProposalInfolist`) risolto.
- [x] Errore 4 (`method.notFound` typo Fixcity) risolto.
- [x] `phpstan.neon` non toccato.
- [x] Nessun altro modulo toccato.
- [x] Nessun commit/push (fuori scope, non richiesto).
- [x] Story BMAD scritta in `Modules/AI/docs/stories/`.
