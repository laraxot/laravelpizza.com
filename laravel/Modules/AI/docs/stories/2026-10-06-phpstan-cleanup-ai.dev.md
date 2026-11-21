---
title: "[DEV] PHPStan cleanup — AI"
type: dev
module: AI
story: "./2026-10-06-phpstan-cleanup-ai.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, ai]
---

# [DEV] PHPStan cleanup — AI

## Technical Plan

- Riusare l'enum esistente per `AiActionProposal`, crearne due solo per i domini non coperti (esito tool, ruolo messaggio)
- Persistenza invariata (colonne `string`; le migration non cambiano), conversione solo a livello di cast
- Etichette/colori/icone nei file lang tramite `EnumTrait`, niente `match` con stringhe

## Files to Modify

- `app/Enums/AiActionProposalStatusEnum.php` (esteso: HasLabel/HasColor/HasIcon, EnumTrait, `isPending/isFinal/canBeConfirmed/canBeCancelled`)
- `app/Enums/AiToolLogStatusEnum.php`, `app/Enums/AiMessageRoleEnum.php` (nuovi)
- `lang/it|en/ai_action_proposal_status_enum.php`, `ai_tool_log_status_enum.php`, `ai_message_role_enum.php` (nuovi)
- `app/Models/AiActionProposal.php`, `AiToolLog.php`, `AiMessage.php` (casts, `@property`, costanti rimosse)
- `app/Actions/{Cancel,Confirm,Create}AiActionProposalAction.php` (enum importato, niente FQCN ne' `->value`)
- `app/Filament/Resources/AiActionProposalResource/Tables/AiActionProposalsTable.php`, `Schemas/AiActionProposalForm.php`
- `database/factories/AiActionProposalFactory.php`, `AiToolLogFactory.php`, `AiMessageFactory.php`
- `tests/Unit/Models/AiActionProposalTest.php` (valori enum + cast di `status`)
- `app/Actions/Prompt/AIPromptTemplates.php`, `app/Datas/AIPromptTemplates.php`, `app/Services/AIServicePromptTemplates.php` (`const string`)
- `docs/bmad/domain-status-enum.md`, `docs/00-INDEX.md` (write-back)

## Implementation Steps

- [x] Letti model, action, Filament, factory, seeder e consumatori (grep `Modules`/`Themes`)
- [x] Esteso `AiActionProposalStatusEnum` (stessa API del vecchio `AiActionProposalStatus` orfano, senza toccarlo)
- [x] Creati `AiToolLogStatusEnum` e `AiMessageRoleEnum` + lang it/en
- [x] Aggiunti `casts()` e `@property`; rimosse le costanti
- [x] Aggiornati Action, tabella (badge senza `colors()`/`formatStateUsing`), form (`options(Enum::class)`), factory (`AiMessageFactory` usa `cases()` e `isUser()`), test
- [x] Ripristinato `public const string` sui template dei prompt
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (la suite usa connessioni dedicate al modulo e `.env.testing` punta a MySQL; non verificato che `APP_ENV=testing` forzi sqlite in-memory, quindi Pest non e' stato lanciato). `AiActionProposalTest` aggiornato: asserisce i valori dell'enum e il cast di `status`.

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- Un docblock `@var string` su una costante **non** soddisfa `constantTypeCoverage`: serve il tipo nativo (PHP >= 8.3).
- Convertire le costanti in enum richiede di aggiornare anche la lettura (`$record->status` diventa enum): confronti con stringhe e `->value` sparsi vanno sostituiti da metodi sull'enum.
- `Select::options(Enum::class)` e `TextColumn::badge()` leggono `HasLabel/HasColor/HasIcon`: si elimina la mappa colori duplicata nella tabella (la vecchia usava `secondary`, che non e' un colore standard di Filament: ora `gray`).
- `fake()->randomElement(Enum::cases())` restituisce `mixed`: scegliere con `numberBetween(0, count-1)` mantiene il tipo.
- Duplicati lasciati intatti (da decidere): le tre classi `AIPromptTemplates` hanno contenuto identico; `Modules/AI/Enums/` (cartella orfana fuori da PSR-4, untracked) contiene `AiActionProposalStatus` mai referenziato.
