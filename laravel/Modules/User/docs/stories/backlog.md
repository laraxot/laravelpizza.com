---
title: "Backlog delle story aperte del modulo User"
type: log
status: active
module: User
qmd: "backlog story aperte ready-for-dev blocked needs-decision user rbac phpstan gdpr"
---

# Backlog delle story aperte del modulo User

Una voce per story ancora aperta (backlog, ready-for-dev, bloccata, da decidere). Le story in corso restano file in questa cartella e in `../bmad/stories/`; le chiuse sono in [done-log.md](done-log.md). Quando una voce parte, crea il file `NNNN-<slug>.story.md` e rimuovi la voce da qui.

- **3.1.rbac-evaluator-role** — RBAC: Evaluator role (create/edit own Scheda) [backlog]
  As an evaluator, I want to create and edit Scheda evaluation records via a permission I hold (not ad-hoc admin access), so that I can complete evaluations for my PA without needing pa_admin privileges, and without being able to approve, delete, or manage users
- **3.2.rbac-staff-role** — RBAC: Staff role (read-only own Scheda) [backlog]
  As a staff member, I want to view only my own Scheda evaluation records in read-only mode, so that my personal evaluation data stays private from other staff and I cannot accidentally modify a record I do not own.
- **3.3.rbac-admin-role** — RBAC: Admin role (all CRUD, user mgmt) [backlog]
  As a PA admin, I want full CRUD access to Scheda records and the ability to manage users and role assignments, so that I can administer my PA's tenant end-to-end without needing database access.
- **3.4.rbac-senior-mgmt-role** — RBAC: Senior Mgmt role (approve Progressioni) [backlog]
  As a senior manager (director-level approver), I want a narrowly-scoped permission to approve Progressioni career-progression records, so that approval authority stays restricted to designated decision-makers without granting me full admin access.
- **3.9.verify-data-residency** — Data residency: verify EU-only deployment [backlog]
  As a compliance-responsible PA admin, I want an automated check confirming the application and its logging/storage dependencies are deployed only within the EU, so that personal data never leaves EU jurisdiction and the PA stays compliant with GDPR and Italian
- **3.10.login-audit** — Login audit: log all auth events [backlog]
  As a PA admin, I want every authentication event (login success, login failure, logout) recorded in the audit log, so that suspicious access patterns can be investigated and the PA can demonstrate GDPR-required audit coverage of access to personal data.
- **5.1.user-lang-phpstan-debt** — PHPStan Level 10: resolve remaining User/Lang type debt [backlog]
  As the tech lead accountable for the PHPStan Level 10 gate, I want the User and Lang modules to pass phpstan analyse at Level 10 with zero errors, so that these two modules stop being the largest blockers to the "0 errors across 35/35 modules" quality bar that
- **6.2.user-invite-workflow** — User invite workflow: admin creates staff + evaluators [backlog]
  As a PA admin or HR admin, I want to invite individual users or upload a CSV batch of staff and evaluators, so that new PA employees get pending accounts without me manually creating each one in Filament.
- **6.3.permission-seeding-invite-batch** — Permission seeding: auto-assign roles to invite batch [backlog]
  As a PA admin, I want the invite batch's requested roles automatically validated and assigned once I confirm them, so that invited staff and evaluators land in the system already permissioned, without a separate manual RBAC pass.
- **7.1.phpstan-application-contracts** — User: contratti applicativi PHPStan [ready-for-dev, 2026-08-24]
  Come maintainer User, voglio correggere i contratti applicativi PHPStan separatamente dai test, affinché API e modelli siano affidabili e il lavoro resti entro una giornata.
- **7.2.phpstan-test-harness-contracts** — User: harness e test PHPStan [backlog, 2026-08-24]
  Come maintainer User, voglio correggere alla fonte i test Team/User/2FA, affinché il gate analizzi test semanticamente validi senza coverage farming.
- **7.4.phpstan-paramtype-coverage** — USER-7.4: PHPStan — dichiarare i param type mancanti (gate typeCoverage 99 % full-tree) [ready-for-dev, 2026-09-03]
  Come maintainer del modulo User, voglio ogni parametro di metodo e closure tipizzato nativamente, così che il gate full-tree phpstan analyse Modules torni verde senza toccare i .neon.
- **8.1.module-remote-git-object-corruption** — Story 8.1: module_user_fila5 remote git object corruption — push blocked [blocked-on-owner, 2026-09-07]
  As a maintainer, I want the module_user_fila5 GitHub remote's missing commit object restored, so that local commits (already correct, already fixing today's PHPStan zero campaign work) can finally push to laraxot/dev.
- **9.2.admin-panel-provider-hook.dev** — Development record — AdminPanelProvider Filament widget hooks [in-progress, 2026-09-27]
- **10-scritture-dentro-accessor-nei-moduli-condivisi** — Sei accessor nei moduli condivisi scrivono a database quando vengono letti [ready-for-dev, 2026-11-10] (+1 variante duplicata)
  Un accessor Eloquent (get...Attribute) e' una lettura. Quando dentro ci sta una update(), leggere una proprieta' scrive a database: una query in piu' per ogni riga disegnata in una tabella, per ogni elemento di una collection, per ogni contatto dentro un job.
- **10.4.retire-gdpr-profile-livewire** — DeleteAccount widget + ritiro Privacy/Terms User [blocked]
  Come utente del profilo, voglio cancellare l’account da UI Filament e non vedere testi legali in Livewire User, così che Gdpr possieda Privacy/Terms e User non ospiti dddx.
- **11.1-fix-userpolicy-authorization-bypass** — Fix: UserPolicy bypassa completamente l'autorizzazione (account takeover) [backlog]
  laravel/Modules/User/app/Models/Policies/UserPolicy.php estende UserBasePolicy (pass-through vuoto verso XotBasePolicy), non BaseUserPolicy.php (classe sorella quasi omonima, gia' scritta correttamente con controllo ruolo hasRole(['super-admin','admin','hr-man
- **11.2-login-rate-limiting** — Fix: nessun rate limiting sul login Filament (brute-force/credential-stuffing) [backlog]
  grep -rn "throttle" in tutto Modules/User restituisce un solo risultato, dentro laravel/Modules/User/routes/auth.php — il cui intero contenuto (righe dentro laravel/Modules/User/routes/auth.php: il cui intero contenuto (righe 4-26) e' avvolto in un blocco di c
- **11.3-gdpr-cascade-delete-user** — Fix: cancellazione account non fa cascade, lascia PII orfane [backlog]
  Nessun modulo Gdpr esiste in questo repo (find laravel/Modules -iname "*gdpr*" → vuoto). L'unico punto di cancellazione e' laravel/Modules/User/app/Actions/User/DeleteUserAction.php: `php $this->authGuard->logout(); // solo il guard/sessione corrente $user->de
- **11.4-encrypt-socialite-token** — Fix: token OAuth Socialite salvati in chiaro nel database [backlog]
  laravel/Modules/User/app/Models/SocialiteUser.php: la proprieta' token e' fillable ma nessun cast (grep -n "casts\|token\|encrypted" → solo docblock e fillable, nessun 'token' => 'encrypted'). La colonna socialite_user.token (TEXT) contiene quindi il token OAu
- **11.5-guard-privileged-fields-createuserdata** — Fix: mass assignment strutturale dormiente in CreateUserData/CreateUserAction [backlog]
  laravel/Modules/User/app/Actions/CreateUserAction.php (top-level) fa User::create([...$attributes, ...($this->data ?? [])]). Modules\User\Datas\ CreateUserData espone come proprieta' settabili is_active, email_verified_at, password_expires_at, is_otp, type, st
- **12.1.filament-xotbase-inheritance** — BaseEditUser e UserColumn conformi a XotBase [backlog]
  Come sviluppatore/modulo User, voglio che le classi Filament di app/Filament estendano le basi Xot come da regola progetto, così che i fix/patch Xot vengano raccolti ovunque, senza eccezioni ad hoc.
- **12.1.phpstan-docs-corruption-cleanup** — Consolidare cluster docs/*phpstan*.md corrotto [backlog]
  Come manutentore della documentazione del modulo, voglio un unico file di stato PHPStan invece di 270 varianti corrotte, cosi' che chi cerca lo stato PHPStan trovi un solo file affidabile.
- **12.2.gitignore-archive-legacy-bug-fix** — Fix pattern bare archive/legacy in docs/.gitignore [backlog]
  Come sviluppatore che scrive nuovi file in docs/archive/ o docs/legacy/, voglio che git non li ignori silenziosamente, cosi' che il lavoro futuro non scompaia senza errore.
- **12.2.hardcoded-labels-translation** — Label e testi hardcoded → lang user:: [backlog]
  Come utente/amministratore multiplo, voglio vedere la UI in italiano coerente anche su resource OAuth/team/tenant, così che nessuna stringa inglese o hardcoded compaia nel panel.
- **12.3.archive-folders-consolidation** — Unificare le cartelle archive/fixes/bug-* sovrapposte [backlog]
  Come chi cerca un bugfix storico nel modulo, voglio una sola cartella convenzionale per gli archivi, cosi' che non debba controllare 6+ posti diversi.
- **12.3.remove-dddx-debug** — Rimozione dddx() dal codice di produzione [backlog]
  Come utente del panel, voglio non incappare mai in un dump di debug (dd/dddx) navigando il panel, così che la UI non si blocchi mai per un residuo di sviluppo. > Nota 2026-10-20: la AC #2 ("erano dead code accanto alla chiamata utile") era falsa per le pagine 
- **12.4.docs-index-curated-map** — Sostituire docs/index.md con mappa curata a 6 voci [backlog]
  Come sviluppatore nuovo sul modulo User, voglio una mappa a 6 voci invece di un elenco piatto con il 30% di link rotti, cosi' che possa orientarmi senza incontrare link morti.
- **12.4.oauth-dup-resources-ssot** — Resource Passport SSoT nel cluster (fine doppioni radice) [backlog]
  Come sviluppatore User, voglio una sola resource Filament per ogni entità Passport (OAuth), così che non esistano più tre copie divergenti dello stesso schema/table col rischio di una UI che non valida davvero.
- **12.5.filament-artifacts-cleanup** — Igiene fs del modulo: no junk committato [backlog]
  Come maintainer del repo, voglio che il modulo non contenga dipendenze node, backup e file tooling/spazzatura dentro i namespace applicativi, così che clone, scan di sicurezza e code search restino leggibili e la taglia del repo non cresca di decine di MB.
- **12.5.permissions-doc-wrong-module-content** — Sostituire docs/permissions.md (contenuto del modulo sbagliato) [backlog]
  Come chi audita permessi/policy del modulo User, voglio che docs/permissions.md parli di User e non di Patient/Gdpr, cosi' che la matrice permessi sia affidabile.
- **12.6.policies-resources-linking** — Policy collegate ai Resource Filament [backlog]
  Come amministratore del sistema, voglio che ogni Resource Filament dichiari la propria policy, così che le autorizzazioni siano applicate dalla UI (hidden/disabled) e non solo da un Gate centrale nel provider.
- **12.6.purpose-scopo-duplicate-and-stale** — Unificare purpose.md/scopo.md e correggere i claim stale [backlog]
  Come chi legge purpose.md per capire lo scopo del modulo, voglio un solo file aggiornato invece di due duplicati, uno dei quali stale, cosi' che non mi fidi di informazioni gia' superate.
- **12.7.readme-frontmatter-qmd-and-issue-consolidation** — Consolidare le issue duplicate PHPStan/coverage [backlog]
  Come maintainer che triagia le issue GitHub del modulo, voglio un'unica issue viva per PHPStan e una per coverage invece di cluster duplicati, cosi' che il backlog sia leggibile.
- **13-dcp-138-limite-di-tentativi-su-login-registrazione-e-azioni-costose** — DCP-138: limite di tentativi che funzioni davvero su login, registrazione e azioni costose [ready-for-dev, 2026-10-13] (+1 variante duplicata)
- **13-dcp-144-accesso-del-cittadino-con-spid-cie-o-decisione-motivata** — DCP-144: accesso del cittadino con SPID/CIE, o decisione motivata di non applicabilita [needs-decision, 2026-10-13] (+1 variante duplicata)
- **13-dcp-53-area-personale-pagine-con-scopo** — Area personale: ogni pagina ha uno scopo e una funzione [in-progress, 2026-10-13] (+1 variante duplicata)
  Riferimenti: sito/segnalazione-area-personale, servizi/graduatoria-area-personale, graduatoria-messaggio, permessi-area-personale, vantaggi-area-personale, pagamenti-multa-area-personale, pagamenti-imu-area-personale (https://italia.github.io/design-comuni-pag
- **13.1.xotbaseresourcetable-model-audit-verification** — Riaudit reale $model su 30 classi Table (contraddice #91) [backlog]
  Come maintainer che si fida di issue #91 ("audit gia' fatto"), voglio una riverifica puntuale contro il codice attuale, cosi' che non si assuma vera una dichiarazione di audit che il grep diretto contraddice.
- **13.2.oauthclientresource-wrong-model** — Allineare OauthClientResource al modello custom del modulo [backlog]
  Come operatore che gestisce OAuth client dal panel, voglio che OauthClientResource usi il modello custom del modulo, non quello Passport vanilla, cosi' che le colonne/relazioni custom siano visibili.
- **13.3.retire-gdpr-profile-livewire-completion** — Completare la story bloccata 10.4 (ritiro Livewire GDPR/ToS/Privacy) [backlog]
  Come maintainer della campagna Livewire->widget, voglio sapere cosa blocca 10.4 e cosa serve per sbloccarla, cosi' che la rimozione di DeleteAccount/TermsOfService/PrivacyPolicy Livewire possa procedere.
- **13.4.login-logout-widget-duplication** — Chiarire la duplicazione LoginWidget/LogoutWidget vs Auth/* [backlog]
  Come sviluppatore che modifica il flusso di login, voglio sapere se LoginWidget/LogoutWidget e i loro equivalenti in Auth/ sono duplicati vivi o dead code, cosi' che non modifichi la copia sbagliata.
- **13.5.pest-coverage-resources-widgets-gap** — Copertura test Resource/Widget scoperti + causa bootstrap lento [backlog]
  Come maintainer della qualita' del modulo, voglio sapere esattamente quali Resource/Widget non hanno test e perche' la suite e' troppo lenta da eseguire per intero, cosi' che una futura story di test parta da una diagnosi, non da un sintomo.
- **13.6.playwright-e2e-plan** — Piano suite E2E Playwright oltre la registrazione [backlog]
  Come QA del modulo User, voglio un piano di suite E2E sui flussi critici, cosi' che login, cambio team e gestione OAuth client abbiano una rete di sicurezza end-to-end.
- **13.7.fortify-jetstream-contract-audit** — Audit contratti Fortify/Jetstream e policy stub [backlog]
  Come maintainer del provider di autenticazione, voglio sapere quali dei ~25 contratti Fortify/Jetstream sono davvero bindati e quali policy sono stub vuoti, cosi' che il comportamento di auth sia prevedibile.
- **13.8.socialite-buttons-renderhook-dead-code** — Risolvere o rimuovere il RenderHook socialite.buttons morto [backlog]
  Come maintainer del login social, voglio che il RenderHook socialite.buttons funzioni o venga rimosso, cosi' che non resti codice morto nel chrome del panel.
- **13.9.baseuser-trait-consolidation** — Decisione di design: consolidamento trait su BaseUser [backlog]
  Come architetto del modulo identita', voglio una decisione esplicita sulla proliferazione di trait su BaseUser, cosi' che auth log, team, shield, passport non si accumulino senza criterio.
- **14.1.permissions-matrix-silent-deny-gap** — Matrice permessi reale: coprire le ~30 Policy scoperte [backlog]
  Come chi audita sicurezza/autorizzazioni del modulo, voglio che ogni Policy abbia un permesso corrispondente nel seeder, cosi' che can()/authorize() non neghino sempre in silenzio.
- **14.2.team-vs-tenant-boundary-doc** — Documentare il confine Team vs Tenant [backlog]
  Come sviluppatore che deve capire dove finisce Team e inizia Tenant, voglio un documento esplicito con il confine gia' verificato nel codice, cosi' che non debba rileggere TenantScope.php ogni volta.
- **14.3.auth-log-device-anomaly-view** — Euristica di anomalia su AuthenticationLog/Device [backlog]
  Come operatore che monitora accessi sospetti, voglio un'euristica che segnali dispositivo nuovo o orario inusuale, cosi' che la UI gia' esistente (AuthenticationLogResource, RecentLoginsWidget, DeviceResource) diventi utile per il rilevamento anomalie, non sol
- **14.4.passport-dashboard-missing-buttons** — Ripristinare i bottoni Passport dashboard regrediti [backlog]
  Come operatore che gestisce credenziali/client OAuth dal panel, voglio che i bottoni "Nuove credenziali" e "Nuovo cliente OAuth" tornino visibili, cosi' che non serva SSH per operazioni di routine.
- **14.5.oauth-client-user-association-incomplete** — Completare l'associazione OAuth client <-> user [backlog]
  Come maintainer della gestione OAuth client, voglio che owner_id/type siano coerenti e ci sia un'azione di rimozione strutturata, cosi' che la gestione manuale incompleta (issue #97) diventi un flusso affidabile.
- **14.6.google-oauth-fo-routing-decision** — Decisione di design: routing login Google per cittadini FO [backlog]
  Come architetto del login social lato Front Office, voglio una decisione esplicita sul routing Google per i cittadini, cosi' che discussion #42 abbia un esito documentato.
- **14.7.lang-stub-corruption-audit-scope** — Verificare l'ampiezza reale del commit che ha svuotato i lang stub [backlog]
  Come maintainer delle traduzioni del modulo, voglio sapere se il commit sospetto ha colpito altri file lang oltre ai 4 gia' noti, cosi' che non restino altri file svuotati non scoperti.
- **14.8.il tracker remoto-remote-issue-tracker-divergence** — Decisione di governance: remote laraxot vs il tracker remoto [backlog]
  Come maintainer del tracciamento GitHub del modulo, voglio una decisione esplicita su quale remote e' canone, cosi' che le story non si dividano tra due tracker che non si parlano.
- **continuazione-domani** — Continuazione BMAD — Domani (User) [backlog/in-progress] (+1 variante duplicata)
- **dcp-290-pagine-di-accesso-e-reset-password-a-tema-e-accessibili** — DCP-290: pagine di accesso e reset password a tema, in 4 lingue e accessibili [in-progress, 2026-10-26]
- **docs-md-filename-date-debt** — Docs md filename date debt — User module wave [in_progress]
  Allineare laravel/Modules/User/docs//*.md alla regola nomi kebab senza date/timestamp. I duplicati di un canonico restano come alias superseded.
- **livewire-residual-conversion-cluster-c** — Story — conversione residui Livewire Cluster C a Filament [blocked]
  Epic 9 done (SuperAdmin widget ecc.), ma restano componenti HTTP Livewire da convertire/eliminare verso il target "solo Filament widget" — vantaggi da convertire/eliminare verso il target "solo Filament widget": vantaggi documentati in advantages-filament-only
- **module-bmad-audit-user-baseline-analisi-completa** — User — baseline BMAD e analisi completa [ready-for-dev, 2026-09-28]
- **permissions-tables-fix** — Story: Create permissions tables in trade_user database [in-progress, 2026-10-05]
  Spatie Laravel Permission tables (roles, permissions, etc.) are missing from the trade_user (connection user) database, causing Table 'trade_data.permissions' doesn't exist (it tries to access them in default trade_data).
- **phpstan-l10-user-phase2** — PHPStan L10 User Module — Phase 2 (Resource constraints) [in_progress, 2026-10-06T14:30Z]
- **phpstan-merge-bootstrap** — User: PHP merge-marker bootstrap (app/tests/lang/migrations) [in_progress]
  Rimuovere tutti i marker <<<<<<< / ======= / >>>>>>> dai file PHP del modulo User (~150), preservando la business logic di auth, teams, permissions e il confine UserContract (non User concreto). Preferire pattern XotBase / Filament moderni e strict_types.
- **phpstan-zero-errors-user** — [STORY] PHPStan zero errori: modulo User [in-progress, 2026-11-17]
- **roles-teams-scoping-disabled-by-override** — Story: il team scoping dei ruoli e' disattivato da un override di roles() [ready-for-dev]
  Come responsabile della sicurezza di una piattaforma multi-tenant, voglio che un ruolo assegnato a un utente dentro un tenant valga solo dentro quel tenant, cosi' che l'isolamento fra clienti non dipenda da quale schermata si sta guardando.
- **story-501-personal-ticket-detail-link** — STORY-501 — Aprire il dettaglio delle proprie segnalazioni [in_progress, 2026-09-26]
  Come cittadino autenticato voglio aprire il dettaglio di una mia segnalazione dall'area personale, anche se lo stato non è ancora pubblico, così posso consultare i dati e seguire gli aggiornamenti senza cercare un link esterno.
- **tenant-key-string** — User: chiave stringa del tenant coerente fra tenants e tenant_user [in-progress, 2026-11-05]
  Come sviluppatore che usa la tenancy di Filament con Modules\User\Models\Tenant voglio che un tenant creato senza id abbia una chiave valida e che la tabella ponte la possa contenere così da poter associare gli utenti ai tenant ($user->tenants()) e far funzion
- **user-hash-password-solo-nelle-actions** — Password hashate solo in un'Action [ready-for-dev, 2026-10-20]
  Come maintainer del modulo User voglio che l'hash della password si calcoli in un solo posto (una Action piu' il mutator del model come rete di sicurezza), cosi' che widget, pagine e form Filament non decidano da soli come si cambia una password. Il brief teme
- **user-orphan-basetable-dedup-clustering** — User: dedup BaseUsersTable orfano, colonne unificate, audit clustering [in-progress, 2026-09-29]
  Sessione avviata da un compito esterno che segnalava divergenza tra UserResource/Pages/{ListUsers,BaseListUsers}.php e UserResource/Tables/BaseUsersTable.php. Verifica sul codice reale (non sulla sola documentazione) ha confermato che quella parte era già stat
- **user-pagine-appearance-salvataggio-o-nascondi** — Pagine Appearance di User: implementare il salvataggio o nasconderle [ready-for-dev, 2026-10-20]
  Come maintainer del pannello user::admin voglio che ogni voce di menu faccia qualcosa di vero, cosi' che chi preme "Salva" non trovi un errore. Oggi sei pagine del cluster Appearance sono nel menu e "Salva" lancia LogicException: il salvataggio non e' mai stat
- **user-passport-new-credentials-button-lost-in-large-commit** — STORY — Il bottone 'Nuove credenziali' della Passport Dashboard è scomparso, cancellato da un commit di un gio [ready-for-dev]
  L'utente ha chiesto l'URL della Passport Dashboard per usare il bottone "Nuove credenziali" (story user-passport-create-client-credentials-button.md, module_user_fila5#85, implementato e verificato dal vivo il 2026-09-03). Aperta la pagina, il bottone non c'er
- **user-stringhe-ui-tradotte** — Stringhe UI del Filament User tradotte [ready-for-dev, 2026-10-20]
  Come utente o amministratore che usa il pannello in italiano, inglese o tedesco voglio che ogni etichetta, segnaposto, suggerimento e titolo di notifica del modulo User venga da lang/, cosi' che non compaiano testi in una lingua sola o inglese dentro un'interf
- **user-tenant-fillable-cast-e-colonne** — Tenant User: fillable, cast e colonne allineati alla migration [ready-for-dev, 2026-10-20]
  Come maintainer del modulo User voglio che Modules\User\Models\Tenant dichiari $fillable, casts() e @property coerenti con le colonne che la migration crea davvero, cosi' che form, tabelle e test leggano e scrivano domain, is_active, trial_ends_at e settings c
- **user-test-igiene-phpunit-testcase-e-svuotati** — Igiene dei test User: file non eseguiti, tautologie, stile PHPUnit [ready-for-dev, 2026-10-20]
  Come maintainer del modulo User voglio che ogni test scritto giri davvero e possa fallire, cosi' che il verde significhi qualcosa. Oggi due file con test veri non sono mai caricati, 26 test non possono fallire e 7 classi sono in stile PHPUnit mentre il progett
- **user-test-senza-refresh-database** — Test User senza RefreshDatabase [ready-for-dev, 2026-10-20]
  Come maintainer del modulo User voglio che nessun test del modulo possa lanciare migrate:fresh, cosi' che un agente o un CI che esegue Pest non possa mai cancellare lo schema di un database. Il 2026-10-20 un agente ha eseguito Pest su file User con RefreshData
- **xot-base-resource-navigation-icon-translation** — Resource User con navigazione tradotta [ready-for-dev]
