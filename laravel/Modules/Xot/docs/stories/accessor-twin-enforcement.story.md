---
title: "Puntatore alla story canonica del contratto accessor gemello"
type: pointer
status: superseded
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, eloquent, accessor, archive]
qmd: "accessor twin enforcement story superseded legacy pointer"
related:
  - ../bmad/stories/accessor-twin-contract-audit.story.md
---
# Story superata

Questo documento era un piano di enforcement incompleto, privo di frontmatter e
con conteggi/stati che non riflettono più il codice corrente. Il lavoro è ora
tracciato nella story BMAD canonica
[Audit e applicazione del contratto accessor gemello](../bmad/stories/accessor-twin-contract-audit.story.md)
e nella story owner Sigma collegata da essa.

Conservare questo puntatore per i riferimenti storici; non usarlo per decidere lo
stato dell'audit o il numero delle violazioni.

## Esito batch rest (agente completato, parziale)
- Corretti 10 file su 14 (22 accessor su 25). Lista in scritture: Job (Job, Task), Lang Post, Media (Media, MediaConvert), Notify (NotificationTemplate, NotifyTheme), Tenant, User HasProfilePhotoContract.
- Scelta: Post::getGuid(?string $title) riceve il titolo come parametro, perche' l'accessor persisteva il titolo quando mancava: un gemello senza argomenti perderebbe quel side effect. Da rivedere: il gemello con parametro non e' un getter puro.
- Saltati per lock di `codex-root` (task `accessor-twin-contract-audit`, 2026-11-05 09:32): User BaseUser, BaseUserUniqueNameAttribute, HasTeams, IsProfileTrait.
- ATTENZIONE: `codex-root` sta facendo un audit accessor-gemello in parallelo. Va coordinato via questa story prima di toccare i suoi file.
- Pest --filter=User: 1 passato, 1 fallito (AuthenticationTest users can logout, 403 invece di redirect). Non verificato se preesistente: nessuna baseline. Da verificare.

## Stato 2026-11-05 ~09:40 (dopo batch ir-inc-perf-rating parziale)
- Violazioni stretta: 215 -> 56 (check.py su laravel/Modules).
- Batch ptv-xot: parziale (3/12). Batch rest: 10/14. Batch ir-inc-perf-rating: parziale, Pest in corso (task by4bsn1ex).
- Batch sigma-a, sigma-b, ilc: in corso al momento della scrittura.

## Coordinamento e conflitti aperti
- Sessioni concorrenti con la stessa audit: `codex-root` e `codex-accessor-leaf` (task `accessor-twin-contract-audit`), piu' `claude-sigma-b` (task `sigma-b-accessor-twins`). Prima di toccare un file, controllare il lock.
- PROTOCOLLO VIOLATO: l'agente ir-inc-perf-rating ha modificato Incentivi/Models/Activity.php ed Employee.php mentre erano bloccati da `codex-accessor-leaf` (09:30:22). La modifica resta; il proprietario del lock va avvisato e deve confermarla o annullarla.
- Lock con proprietario ignoto (`unknown`) alle 09:31:42 su IndennitaCondizioniLavoro (IndennitaTipoDettaglioAnno, ServizioEsternoIndennitaTipoDettaglioPivot, IndennitaTipo, RelationshipTrait): possibili lock orfani, da verificare prima di rimuoverli.
- Lock sporchi di `codex-root` su file docs (Xot/docs/wiki/index.md, Sigma/docs/bmad/accessor-twin-method.md, Ptv/docs/bmad/accessor-twin-method.md, Xot/docs/wiki/rules/accessor-twin-method.md): non sono file di codice, vanno rilasciati dal proprietario.
- Decisione aperta: ManageProjectEmployees::getTableRecordTitle. Il nome collide con HasRecords di Filament. Serve un nome di gemello diverso o un'eccezione documentata.
- Decisione aperta: IndividualePesi (Performance) saltato per lock, da rieseguire.

## Regola 2: mutator e relazioni nel trait (2026-11-05)
Accessor, metodi di appoggio e relazioni che stanno nel corpo della classe modello vanno in trait dedicati: `Traits/Mutators/<Model>Mutator.php` e `Traits/Relationships/<Model>Relationship.php`, composti dal trait del modello. Precedente: Ptv SchedaMutator / SchedaRelationship.
- Misura iniziale: 99 classi modello, 172 accessor, 188 relazioni nel corpo.
- I gemelli nati dalla regola 1 vanno nel trait del mutator, non nel modello.
- Batch dedicato da lanciare dopo che i batch di regola 1 chiudono (evita conflitti di lock).

## Misura verificata 2026-11-05 (perimetro completo)
- Il checker aveva perimetro ristretto a `app/Models/**` (modificato da un'altra sessione). Ripristinato a `*/app/**/*.php`. Con il perimetro completo (4213 file): **28 violazioni in 10 file**.
- Per modulo: Xot 16, Sigma 7, Ptv 2, User 1, IndennitaCondizioniLavoro 1, Incentivi 1.
- Batch chiusi: ilc (4 file corretti, altri bloccati da conflitti di nome o lock), sigma-b (1/3), ptv-xot (3/12), rest (10/14), ir-inc-perf-rating (parziale, Pest in corso). sigma-a: in attesa della notifica.
- Conflitti di nome da risolvere a livello di famiglia (non per file): getCognome, getNome, getReparTxt, getTot, getCodqua, getDisci1, getGgAssenzaAnno, getGgPresenzaAnno, getType. Stessi nomi in trait diversi (Sigma EnteMatr/EnteStabi, Ptv SchedaMutator) producono shadowing silenzioso. Decisione da applicare: una sola fonte per nome, nel trait del mutator, con gemello sullo stesso file.

## Stato finale del giro 2026-11-05 (dopo tutti i batch)
- Violazioni (perimetro completo, 4213 file): **28 in 10 file**. NON e' zero.
- Di queste, falsi positivi o non-modelli (da escludere nel checker, non da "fixare"): Filament hook `getTableRecordTitleAttribute` (Ptv BaseAssenzeScheda, BaseSigmaHistoryScheda, IndennitaTipoDettaglioRelationManager, HasXotTable); helper `SafeAttributeCastAction` / `SafeEloquentCastAction`; contratto `HasProfilePhotoContract` (interfaccia senza corpo).
- Decisioni reali aperte:
  1. `EnteMatrMutator::getCognome`: il gemello restituisce il valore con spazio finale, l'accessor persistiva il grezzo. Serve decidere quale valore va persistito.
  2. `ManageProjectEmployees::getTableRecordTitle`: collide con la firma di Filament `HasRecords::getTableRecordTitle(Model $record)`.
- Bug reale da correggere: `Xot/app/Traits/HasSchemalessAttributes::getExtraAttribute(string $key, mixed $default)` e' registrato da Eloquent come mutator della colonna `extra`, quindi riceve il valore della colonna come `$key`.
- Shadowing di nomi tra trait (Sigma EnteMatr / EnteStabi, Ptv SchedaMutator, modelli Incentivi / ICL): da risolvere per famiglia, con una sola fonte per nome.
- Qua03f: l'echo di debug HTML e' gia' stato rimosso da un'altra sessione.
- Pest non verificato o non pulito: ListRatingsPageTest (2 su 4 falliscono, non dimostrato preesistente); User AuthenticationTest users can logout (403); Sigma DownloadActionTest e ImportJsonActionTest; AccessorTwinMethodTest saltato per DB Sigma non disponibile. Nessuna baseline su HEAD.
- Lock: 289 file .lock presenti in laravel/Modules. Molti probabilmente orfani. Prima di qualsiasi pulizia: verifica del proprietario, non rimozione in massa.
- Regola 2 (mutator e relazioni nei trait): NON ancora iniziata.

## Lavoro senza lock, 2026-11-05 ~09:55
- DONE (senza lock altrui): Xot HasSchemalessAttributes. `getExtraAttribute` / `setExtraAttribute` rinominati in `getExtraValue` / `setExtraValue`. Erano accessor Eloquent della colonna `extra` e ricevevano null come `$key` (HasExtraTrait::getExtra/setExtra chiama `$this->extra`). Test HasSchemalessAttributesTest aggiornato ai nomi nuovi. php -l OK.
- BLOCCATO: test Pest non eseguibile. Fatal in `Modules/User/app/Models/BaseUser.php`: `BaseUserRelations::unreadNotifications` collide con `Illuminate\Notifications\Notifiable::unreadNotifications`. Il trait e' untracked, lock `codex-root` task `user-model-trait-extraction` (09:46). Chiedo a codex-root di risolvere la collisione (rimuovere il metodo duplicato o usare insteadof) nel suo batch. Non l'ho toccato.
- CONFLITTO check.py: il file `bashscripts/tools/accessor-twins/check.py` e' stato modificato da un'altra sessione alle 09:51 (glob ristretto a `app/Models/**`) subito dopo la mia correzione dei falsi positivi (commenti, interfacce, Filament, Actions/Cast). Non ribalto. Misura one-off su perimetro completo (4255 file): 20 segnalazioni, di cui molte sono falsi positivi gia' identificati (Filament hook getTableRecordTitleAttribute, helper SafeAttributeCastAction / SafeEloquentCastAction, interfaccia HasProfilePhotoContract). Chi modifica check.py deve dichiararlo qui.

## Blocco critico 2026-11-05 ~09:58: modulo User non si carica
- Fatal su `Modules/User/app/Models/BaseUser.php` (riga 130). Collisioni tra trait:
  1. `BaseUserRelations::unreadNotifications` vs `Notifiable::unreadNotifications` (Laravel).
  2. `BaseUserRelations::latestAuthentication` vs `HasAuthenticationLogTrait::latestAuthentication`.
- Causa: estrazione in corso del trait `BaseUserRelations` (untracked, lock `codex-root`, task `user-model-trait-extraction`). Finche' non si risolve, nessun test Pest che carica User gira, quindi nessuna verifica di Sigma, Ptv, Xot-auth, Xot-schemaless.
- Richiesta a codex-root: risolvere entrambe le collisioni prima di proseguire (insteadof, o rimuovere il duplicato). Non rimuoviamo il loro lock senza accordo.
- Richiesta all'utente: decidere se questa sessione puo' prendere il file `BaseUserRelations.php` per risolvere le collisioni, rompendo il lock di codex-root.
