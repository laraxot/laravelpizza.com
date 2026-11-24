---
title: "User: cosa manca per completare"
type: status
module: User
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# User: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 676 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 156 (0) |
| File di test (`*Test.php`) | 172 |
| TODO/FIXME nel codice | 6 |
| Traduzioni it / en (solo in it) | 227 / 90 (138) |
| Story/epic BMAD (aperte) | 155 (101) |

## Problemi noti e prossimi passi

Nessun problema bloccante emerso dai controlli del 2026-10-28 oltre agli indicatori sopra e alle story aperte.

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in-progress | [User: dedup BaseUsersTable orfano, colonne unificate, audit clustering](bmad/stories/user-orphan-basetable-dedup-clustering.story.md) |
| in-progress | [DCP-290: pagine di accesso e reset password a tema, in 4 lingue e accessibili](stories/dcp-290-pagine-di-accesso-e-reset-password-a-tema-e-accessibili.story.md) |
| in-progress | [Area personale: ogni pagina ha uno scopo e una funzione](stories/dcp-53-area-personale-pagine-con-scopo.story.md) |
| review | [Story: Ripristino migrazione e traduzioni User dopo conflitto](bmad/stories/committed-conflict-markers.story.md) |
| review | [User: Application/ in root è duplicato morto](bmad/stories/uppercase-application-dir.story.md) |
| review | [UserResource: clustering RelationManager, widget reali, audit action riusabili](bmad/stories/user-clustering-widgets-actions-audit.story.md) |
| review | [User: confine Table, i18n e riuso Filament](bmad/stories/user-filament-boundary-i18n.story.md) |
| review | [STORY: Assert::isInstanceOf contro Model concreto invece di UserContract, audit repo-wide](stories/assert-isinstanceof-usercontract-audit.story.md) |
| review | [Flusso di accesso FO: redirect dopo login, reset password, ritorno alla pagina](stories/auth-flow-redirects-reset-token.story.md) |
| review | [[STORY] ForgotPasswordWidget e ResetPasswordWidget dichiaravano una vista che non esiste](stories/auth-password-widgets-view-not-found.story.md) |
| ready-for-dev | [User: baseline BMAD e analisi completa](bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [Resource User con navigazione tradotta](bmad/stories/xot-base-resource-navigation-icon-translation.story.md) |
| ready-for-dev | [User: contratti applicativi PHPStan](stories/7.1.phpstan-application-contracts.story.md) |
| ready-for-dev | [USER-7.4: PHPStan: dichiarare i param type mancanti (gate typeCoverage 99 % full-tree)](stories/7.4.phpstan-paramtype-coverage.story.md) |
| ready-for-dev | [DCP-138: limite di tentativi che funzioni davvero su login, registrazione e azioni costose](stories/dcp-138-limite-di-tentativi-su-login-registrazione-e-azioni-costose.story.md) |
| ready-for-dev | [Password hashate solo in un'Action](stories/user-hash-password-solo-nelle-actions.story.md) |
| ready-for-dev | [Pagine Appearance di User: implementare il salvataggio o nasconderle](stories/user-pagine-appearance-salvataggio-o-nascondi.story.md) |
| ready-for-dev | [Stringhe UI del Filament User tradotte](stories/user-stringhe-ui-tradotte.story.md) |
| ready-for-dev | [Tenant User: fillable, cast e colonne allineati alla migration](stories/user-tenant-fillable-cast-e-colonne.story.md) |
| ready-for-dev | [Igiene dei test User: file non eseguiti, tautologie, stile PHPUnit](stories/user-test-igiene-phpunit-testcase-e-svuotati.story.md) |
| ready-for-dev | [Test User senza RefreshDatabase](stories/user-test-senza-refresh-database.story.md) |
| open | [Rimuovere nomi di progetti ospiti dal codice e dalle lingue di User](stories/user-guest-project-names-removal.story.md) |
| backlog | [Continuazione domani](bmad/stories/continuazione-domani.story.md) |
| backlog | [DCP-369: login Google, collegamento per email, consenso e sessione prima di aprirlo ai cit](bmad/stories/dcp-369-google-login-collegamento-email-consenso-e-sessione.story.md) |
| backlog | [Fix: UserPolicy bypassa completamente l'autorizzazione (account takeover)](stories/11.1-fix-userpolicy-authorization-bypass.story.md) |
| backlog | [Fix: nessun rate limiting sul login Filament (brute-force/credential-stuffing)](stories/11.2-login-rate-limiting.story.md) |
| backlog | [Fix: cancellazione account non fa cascade, lascia PII orfane](stories/11.3-gdpr-cascade-delete-user.story.md) |
| backlog | [Fix: token OAuth Socialite salvati in chiaro nel database](stories/11.4-encrypt-socialite-token.story.md) |
| backlog | [Fix: mass assignment strutturale dormiente in CreateUserData/CreateUserAction](stories/11.5-guard-privileged-fields-createuserdata.story.md) |
| backlog | [BaseEditUser e UserColumn conformi a XotBase](stories/12.1.filament-xotbase-inheritance.story.md) |
| backlog | [Consolidare cluster docs/*phpstan*.md corrotto](stories/12.1.phpstan-docs-corruption-cleanup.story.md) |
| backlog | [Fix pattern bare archive/legacy in docs/.gitignore](stories/12.2.gitignore-archive-legacy-bug-fix.story.md) |
| backlog | [Label e testi hardcoded → lang user::](stories/12.2.hardcoded-labels-translation.story.md) |
| backlog | [Unificare le cartelle archive/fixes/bug-* sovrapposte](stories/12.3.archive-folders-consolidation.story.md) |
| backlog | [Rimozione dddx() dal codice di produzione](stories/12.3.remove-dddx-debug.story.md) |
| backlog | [Sostituire docs/index.md con mappa curata a 6 voci](stories/12.4.docs-index-curated-map.story.md) |
| backlog | [Resource Passport SSoT nel cluster (fine doppioni radice)](stories/12.4.oauth-dup-resources-ssot.story.md) |
| backlog | [Igiene fs del modulo: no junk committato](stories/12.5.filament-artifacts-cleanup.story.md) |
| backlog | [Sostituire docs/permissions.md (contenuto del modulo sbagliato)](stories/12.5.permissions-doc-wrong-module-content.story.md) |
| backlog | [Policy collegate ai Resource Filament](stories/12.6.policies-resources-linking.story.md) |
| backlog | [Unificare purpose.md/scopo.md e correggere i claim stale](stories/12.6.purpose-scopo-duplicate-and-stale.story.md) |
| backlog | [Consolidare le issue duplicate PHPStan/coverage](stories/12.7.readme-frontmatter-qmd-and-issue-consolidation.story.md) |
| backlog | [Riaudit reale $model su 30 classi Table (contraddice #91)](stories/13.1.xotbaseresourcetable-model-audit-verification.story.md) |
| backlog | [Allineare OauthClientResource al modello custom del modulo](stories/13.2.oauthclientresource-wrong-model.story.md) |
| backlog | [Completare la story bloccata 10.4 (ritiro Livewire GDPR/ToS/Privacy)](stories/13.3.retire-gdpr-profile-livewire-completion.story.md) |
| backlog | [Chiarire la duplicazione LoginWidget/LogoutWidget vs Auth/*](stories/13.4.login-logout-widget-duplication.story.md) |
| backlog | [Copertura test Resource/Widget scoperti + causa bootstrap lento](stories/13.5.pest-coverage-resources-widgets-gap.story.md) |
| backlog | [Piano suite E2E Playwright oltre la registrazione](stories/13.6.playwright-e2e-plan.story.md) |
| backlog | [Audit contratti Fortify/Jetstream e policy stub](stories/13.7.fortify-jetstream-contract-audit.story.md) |
| backlog | [Risolvere o rimuovere il RenderHook socialite.buttons morto](stories/13.8.socialite-buttons-renderhook-dead-code.story.md) |
| backlog | [Decisione di design: consolidamento trait su BaseUser](stories/13.9.baseuser-trait-consolidation.story.md) |
| backlog | [Matrice permessi reale: coprire le ~30 Policy scoperte](stories/14.1.permissions-matrix-silent-deny-gap.story.md) |
| backlog | [Documentare il confine Team vs Tenant](stories/14.2.team-vs-tenant-boundary-doc.story.md) |
| backlog | [Euristica di anomalia su AuthenticationLog/Device](stories/14.3.auth-log-device-anomaly-view.story.md) |
| backlog | [Ripristinare i bottoni Passport dashboard regrediti](stories/14.4.passport-dashboard-missing-buttons.story.md) |
| backlog | [Completare l'associazione OAuth client <-> user](stories/14.5.oauth-client-user-association-incomplete.story.md) |
| backlog | [Decisione di design: routing login Google per cittadini FO](stories/14.6.google-oauth-fo-routing-decision.story.md) |
| backlog | [Verificare l'ampiezza reale del commit che ha svuotato i lang stub](stories/14.7.lang-stub-corruption-audit-scope.story.md) |
| backlog | [Decisione di governance: remote laraxot vs provtv](stories/14.8.provtv-remote-issue-tracker-divergence.story.md) |
| backlog | ['RBAC: Evaluator role (create/edit own Scheda)'](stories/3.1.rbac-evaluator-role.story.md) |

... e altre 41 (cercare `status:` diverso da done in `docs/**/*.story.md`).

21 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
