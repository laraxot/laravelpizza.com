---
title: "Decision log: SuperAdmin widget"
type: decision-log
module: User
status: active
related:
  - ./project-context.md
  - ./livewire-widget-project-context.md
  - ./brainstorming.md
  - ./livewire-widget-brainstorming.md
  - ./architecture.md
  - ./livewire-inventory.md
  - ./epics.md
  - ./filament-blueprint.md
updated: 2026-10-26
tags: [docs, user, bmad]
qmd: "decision log   superadmin livewire → filament widget user"
---

# Decision log: User

**Scopo:** User e' il confine di identita' del cittadino e dell'operatore (auth, OAuth localizzato, profilo, RBAC/tenant): i temi vestono le pagine, Fixcity/Gdpr possiedono dominio e consensi, User possiede login/registrazione e i contratti Filament/Socialite.

## Hub (solo link)

- Standing PHPStan: [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md)
- `graphify-out/`: [graphify-out-gitignore](../../../Xot/docs/bmad/graphify-out-gitignore.md)
- UI admin/FO auth: [filament-blueprint.md](./filament-blueprint.md)

## [2026-10-20] Gate PHPStan Modules zero; Filament blueprint SSoT UI admin

- **Decisione:** gate `analyse Modules` a zero; auth/OAuth/widget e Resource User si progettano solo via [filament-blueprint.md](./filament-blueprint.md) (XotBase, chiavi Lang, PHPStan alla sorgente).
- **Track:** hub sopra.

## [2026-10-20] Google OAuth FO = route con `lang` + binding controller corretto

- **Perché:** da `/it/auth/login` il cittadino deve andare a
  `/it/auth/login/google` (stesso contesto lingua; callback
  `GOOGLE_REDIRECT_URI` con `/it/`).
- **Cosa:** `oauth.redirect` = `{lang}/auth/login/{provider}`. Bottone Sixteen e
  widget usano `route(..., ['lang' => $locale])`. I fallback Folio sono stati
  rimossi (DCP-269, vedi sotto). I controller dichiarano
  `string $lang, string $provider` e tipizzano `Illuminate\Http\Request`
  (non la Facade): altrimenti `$provider` riceve `it`.
- **Non fare:** `route('oauth.redirect')` senza `lang`; OAuth in new tab;
  stub Folio che abortisce 404 sul callback localizzato; Facade `Request`
  negli `__invoke` OAuth.
- **Piano:** [oauth-login-locale-fix](../../../../Themes/Sixteen/docs/bmad/plans/oauth-login-locale-fix.md);
  [google-auth-login.md](./google-auth-login.md).

## [2026-10-20] Google: giro completo nella lingua del cittadino (DCP-269)

- **Perché:** `GOOGLE_REDIRECT_URI` è unico (`/it/…/callback`): chi parte da `/en/` rientrava in italiano; un provider o una lingua inventati davano 500
  o una lingua fantasma; un `abort(404)` nei fallback Folio rompeva `route('login')` in tutta l'app.
- **Cosa:** vincoli su `{lang}` e `{provider}` in `routes/socialite.php`; lingua d'ingresso in sessione (`SESSION_LANG_KEY`) ripristinata dal callback;
  `RedirectToLoginAction` rimanda a `/{lang}/auth/login`; chiavi `login-failed`/`user-not-allowed`/`registration-not-enabled` anche in en/es;
  rimossi i 4 fallback Folio.
- **Non fare:** `abort()`/`redirect` al livello superiore di una vista Folio; ridefinire `GOOGLE_REDIRECT_URI` per lingua senza registrare ogni URI in Google Cloud Console.
- **Aperto fuori dal codice:** credenziali Google reali in produzione (oggi `client_id` segnaposto). Story:
  [dcp-269](./stories/dcp-269-login-google-localizzato-e-rientro-nella-lingua.story.md).

## [2026-10-20] Password login rivelabile = Filament `revealable()`

- **Perché:** su `/it/auth/login` il cittadino deve poter mostrare/nascondere la
  password senza un toggle Alpine del tema.
- **Cosa:** `UserForm::getLoginFormSchema()` tiene
  `TextInput::make('password')->password()->revealable()`. Suffix action
  Filament (`showPassword` / `hidePassword`). Il tema Sixteen veste solo il
  flex dell'occhio nello shell `.auth-login-card` (lo sheet FO non dipinge
  `.fi-input-wrp` in `data-dc`).
- **Non fare:** toggle custom, `type` Alpine a mano, Resource nel tema.
- **Guardrail:** `LoginPasswordRevealableTest`; blueprint
  [filament-blueprint.md](./filament-blueprint.md); docs Filament
  [revealable password inputs](https://filamentphp.com/docs/5.x/forms/text-input#revealable-password-inputs).

## [2026-10-19] Schema `users` in UserData, connessione `user`

- **Perché:** la registrazione inserisce `type` (Parental, `customer_user`).
  Su `fixcity.eu` la connessione `user` puntava a `fixcity_data`, la cui
  tabella `users` non ha `type`. Gli utenti stanno su `fixcity_user`.
- **Senso:** `UserData` è la tabella `users` che si può leggere.
  `createColumns` la crea intera. `updateColumns` è lo stesso elenco e
  aggiunge una colonna solo se manca. Non è un secondo DTO di creazione
  e non è un catalogo di closure.
- **Cosa:** `UserData` dichiara le colonne. La migration
  `create_users_table` non ha `$model_class`: dal nome file
  `XotBaseMigration` risolve `Modules\Fixcity\Models\User`.
  L'alias host `config/eu/fixcity` si risolve nel tenant canonico
  `local/fixcity`, l'unica config che Laravel carica.
- **Non fare:** aggiungere `type` alla tabella legacy di `fixcity_data`.
  Non creare una migration per un campo. `2026_10_18_133309_create_users_is_active_column`
  faceva `Schema::table` su `fixcity_data` e si fermava perché `is_active` c'era già.
  Il campo vive in `UserData::updateColumns`. Il file è `.php.old`: Laravel non lo carica, la storia resta.

## [2026-10-18] UserContract boundary nei consumer Auth

- **Perché:** confrontare / tipizzare `BaseUser` lega il consumer all'astratta
  interna; Fixcity (e altri tenant) possono fornire un `User` concreto che
  implementa `UserContract` senza che il consumer conosca la gerarchia.
- **Cosa:** `RecordAuthenticationLogAction` tipizza
  `UserContract&HasAuthentications`; listener Login/Failed/OtherDevice usano
  `instanceof UserContract` (+ `HasAuthentications`), mai `instanceof BaseUser`.
- **Docs:** [`../wiki/concepts/usercontract-boundary.md`](../wiki/concepts/usercontract-boundary.md),
  [`../bmad-second-brain.md`](../bmad-second-brain.md), Xot
  `user-contract-boundary`, Sixteen D18.
- **Guardrail:** `RecordAuthenticationLogActionTest` (source contract).

## [2026-10-18] Login i18n: chiavi mancanti su FO

- **Sintomo prod:** `user::auth.login.google.button.text` e
  `pub_theme::accessibility.title.text` grezzi su `/it/auth/login`.
- **Fix:** contratto `.text` per accessibilità (it/en/de/es); DE non deve
  riscrivere `login.google` senza `button`; `login.php` senza placeholder
  inglesi (`Missing…`, `authenticate`); login FO senza helper_text di
  `user_form` (solo label).
- **Guardrail:** `AuthLoginTranslationContractTest` include
  `login.google.button.text`.

## [2026-10-18] Login i18n: catalogo unico per il contratto della vista

**Decision:** la vista Sixteen `components/pages/auth-login.blade.php` e il
widget Filament condividono il contratto `user::auth.login.*`. Ogni lingua
servita (`it`, `en`, `de`, `es`) deve fornire i nodi `.text` per titolo,
intro, social, submit, password dimenticata, registrazione e stato loading,
oltre a `auth.actions.login.success/error`.

**Rationale:** i cataloghi contenevano forme incompatibili (stringa semplice,
array con `.text`, chiavi duplicate e catalogo `login_widget` incompleto).
Laravel risolve l'ultima chiave PHP duplicata: una traduzione presente solo
nella prima definizione è quindi assente a runtime. Il test di contratto copre
tutte e quattro le lingue e 80 asserzioni.

**Filament Blueprint:** `LoginWidget` resta thin; schema/etichette restano
nella SSoT `user_form`, mentre `login_widget` contiene solo il contratto dei
campi ausiliari. Nessuna label hardcoded: anche il pulsante Google usa il
catalogo `auth`.

# Decision log: SuperAdmin Livewire → Filament widget

## [2026-09-21] Superman / Clark Kent, gli altri SVG restano

**Decision:** il toggle usa `user-superman` (`superman.svg`) e `user-clark-kent` (`clark-kent.svg`). Non si cancellano `superadmin.svg`, `negate-superadmin.svg`, `user-super-admin.svg`, `user-negate-super-admin.svg`, `user-superman.svg`, `user-clark-kent.svg`.

**Rationale:** super-admin è l’identità svelata; negate-super-admin è lo stesso privilegio sotto mentite spoglie. Occhiali vs cappa si leggono a 16px. Filename con `user-` nel modulo `user` diventano `user-user-*` e non si usano nel `icon=`. Nessuno scudo/logo registrato: outline originale.

## [2026-09-21] Vista convenzionale, niente pin `$view`

**Decision:** una sola blade `super-admin.blade.php`. `XotBaseWidget::resolveView()` + `GetViewByClassAction` la trovano da sole. Rimossa `super-admin-toggle`.

**Rationale:** DRY. Il pin esisteva solo perché la vista convenzionale aveva perso il prefisso `user-`. Sistemata quella, il secondo file era rumore. Test: asserire il path dello scudo (`M12 3l7 3v5c0…`), non un generico `<svg>` (il loading indicator di `icon-button` è già un SVG).

## [2026-09-21] Icone Filament = set auto-registrato `user-`

**Decision:** `x-filament::icon-button` con `user-superadmin` / `user-negate-superadmin`. I nomi senza prefisso (`super-admin`) cercano il set default: `blade-icons.fallback` è `''`, quindi bottone vuoto senza errore.

**Rationale:** [Filament 5 icons](https://filamentphp.com/docs/5.x/styling/icons) + [icon-button](https://filamentphp.com/docs/5.x/components/icon-button). Custom SVG = `{prefix}-{filename}`. Qui prefix = `user`. Stroke `currentColor` sul root, come Heroicon: il panel non ha `viteTheme()`, solo classi `fi-*`.

## [2026-09-21] Emblema hero outline, non corona ruotata

**Decision:** il toggle SuperAdmin usa due SVG originali outline (`user-super-admin` / `user-negate-super-admin`): scudo a goccia, anello-nucleo, fulmine. Attivo = nucleo acceso + flare; negato = stesso scudo spento + barra. Animazione CSS dentro la SVG, spenta con `prefers-reduced-motion`. Vista `super-admin-hero` perché i nomi `@svg('user::svg…')` non esistono nel set Blade Icons (`prefix-filename`).

**Rationale:** privilegio elevato = emblema da supereroe, non un pezzo degli scacchi né un logo registrato. Outline + `currentColor` resta chrome Filament. Il moto è ambientale (respiro), non un loader.

## [2026-09-21] Due icone distinte, non re ruotato

**Decision:** il toggle SuperAdmin nel user menu usa due SVG di dominio già nel modulo (`user-superadmin` corona / `user-negate-superadmin` corona barrata), colori Filament `warning` / `danger`. Si abbandona `fas-chess-king` + `rotate-180`.

**Rationale:** lo stesso glifo ruotato è un rebus, non uno stato. Il re degli scacchi è un pezzo di gioco; il ruolo è privilegio elevato vs privilegio revocato. La corona è il metaforo giusto; la barra è il “no” universale. Le SVG esistevano già inutilizzate: DRY. Il marcatore di test passa da `rotate-180` a `data-super-admin-state`. FR-001 e [ux-design.md](./ux-design.md) aggiornati; trait e hook invariati.

## [2026-09-21] Track Quick Flow

**Decision:** questo slice è Quick Flow (4 story, un epic). Si producono comunque brief, PRD, architecture, UX, tech-spec perché l’utente ha chiesto il pacchetto BMAD completo, restando su scope piccolo.

**Rationale:** requisiti chiari, un modulo, nessun DB nuovo. Un PRD Enterprise sarebbe rumore.

## [2026-09-21] Widget via render hook, non dashboard

**Decision:** il widget si monta solo su `PanelsRenderHook::USER_MENU_BEFORE` (oggi `panels::user-menu.before`). Non entra in `$panel->widgets()` / griglia dashboard.

**Rationale:** è un controllo di identità nel chrome del panel, non un KPI. `discoverWidgets` su `Modules/User/app/Filament/Widgets` lo troverebbe: `static $isDiscovered = false`.

## [2026-09-21] XotBaseWidget, non XotBaseSchemaWidget

**Decision:** niente form. Un click sull’icona chiama `toggleSuperAdmin()` e redirect 303 sulla URL corrente.

**Rationale:** oggi il Livewire non ha schema. `XotBaseSchemaWidget` è per form/auth. DRY: non inventare un form per un toggle.

## [2026-09-21] Business logic resta sul profilo

**Decision:** nessuna Action nuova. Si continua a chiamare `XotData::make()->getProfileModel()->toggleSuperAdmin()`.

**Rationale:** il trait `IsProfileTrait` è già la SSoT (scambio `super-admin` ↔ `negate-super-admin`). Duplicare in una Action sarebbe teatro.

## [2026-09-21] AdminPanelProvider è l’unico punto di montaggio

**Decision:** la story 9.2 tocca **solo** `AdminPanelProvider.php`. Si sostituisce `Blade::render("@livewire('profile.super-admin')")` con il FQCN del widget. L’hook `team.change` non si tocca.

**Rationale:** due hook distinti sullo stesso `USER_MENU_BEFORE`. Mescolarli in una story crea conflitti di lock.

## [2026-09-21] GitHub issue/discussion

**Decision:** tracciamento reale su `laraxot/module_user_fila5`: issue [#100](https://github.com/laraxot/module_user_fila5/issues/100), discussion [#101](https://github.com/laraxot/module_user_fila5/discussions/101). Ogni story 9.x e 10.x punta a questi due URL.

**Rationale:** [016-github-issue-discussion-in-every-story.md](../../../../../docs/wiki/rules/016-github-issue-discussion-in-every-story.md). `gh` autenticato il 2026-09-21.

## [2026-09-21] Campagna widget-only (14 Livewire)

**Decision:** inventario completo in [livewire-inventory.md](./livewire-inventory.md). Epic 9 resta SuperAdmin; Epic 10 chiude team, social (widget esistente), gemelli auth, DeleteAccount, Privacy/Terms. Nessun PHP in questa sessione.

**Rationale:** il 500 `filament-jet` è un fallimento di **contenitore**, non di un solo componente. Due stack UI sullo stesso chrome sono un rischio di identità.

## [2026-09-21] Gemello esistente batte classe nuova

**Decision:** `SocialLoginWidget` e i widget Auth coprono Cluster B. 10.2/10.3 ritirano HTTP, non riscrivono login.

**Rationale:** ADR-C002. Un terzo login è un bug di sicurezza.

## [2026-09-21] ViewCopyAction vietata in render

**Decision:** nessun `ViewCopyAction` nei componenti UI User dopo Epic 10.

**Rationale:** mutazione disco a request. Theming = deploy, non `render()`.

## [2026-09-21] Riconciliazione analisi parallele

**Decision:** un canone [livewire-inventory.md](./livewire-inventory.md). Epic 9+10. Niente Epic 11. Niente `ButtonsWidget`. I file `conversion-inventory`, `advantages-*`, `consolidation-*` e le story `10.1.socialite` / `11.1` sono stub.

**Tenuto:** categoria chrome vs pagina; grep Notify vendor; 403 post-click vs `canView`; Buttons/Change non 500 oggi; security delete; ritiro HTTP dopo smoke; gap route FO vs panel su SocialLoginWidget.

**Scartato:** widget senza round-trip Livewire; `/admin` ancora rotto; UI/Lang in questa campagna; Socialite P3; nuova classe social 1:1; 303 team come epic proprio.

## [2026-09-21] Icone SuperAdminWidget invisibili: root cause morph map

**Sintomo:** `SuperAdminWidget` renderizzava `<div>` vuota per utenti super-admin: le icone `@svg('user-super-admin')`/`user-negate-super-admin` non apparivano mai nel chrome `USER_MENU_BEFORE`.

**Root cause (verificata, non ipotizzata):** `IsProfileTrait::isSuperAdmin()` chiama `$this->user->hasRole('super-admin')`, dove `Profile::user` risolve `Modules\Quaeris\Models\User` (la user class canonica, `XotData::getUserClass()`). La morph map registrata da `TenantServiceProvider::buildMorphMap()` leggeva `config('morph_map')` con `'user' => Modules\User\Models\User` (classe padre): Quaeris\ServiceProvider la mappava correttamente a `Quaeris\Models\User` in `boot()`, ma il provider Tenant sovrascriveva dopo. Risultato: `Quaeris\User::getMorphClass()` = FQCN, mentre `model_has_role.model_type` contiene `'user'` → query `roles()` filtrava il morph sbagliato → ruoli invisibili → widget vuoto.

**Decision:** in `buildMorphMap()` forzare `$typedMap['user'] = XotData::make()->getUserClass()` dopo il loop config: la chiave 'user' è sempre la classe canonica dell'install, mai la voce stantia. Allineato `config/localhost/morph_map.php`.

**Data debt:** `model_has_role` contiene ancora 40 righe con `model_type='Modules\Quaeris\Models\User'` (scritte prima del fix): richiedono `UPDATE model_has_role SET model_type='user' WHERE model_type='Modules\Quaeris\Models\User'`. Non eseguita: scrittura DB da approvare.

**Verifica:** tinker: `getMorphClass()='user'`, `isSuperAdmin()=true`, widget renderizza `data-super-admin-state` (LEN 2293).

**Rationale:** regola contract-pattern: i morph alias devono puntare alla classe canonica, non a superclassi. Il fix è nel punto singolo di costruzione della mappa, non per-callsite.

## [2026-09-22] Campagna "module-excellence" additiva, non sovrascrittura

**Decision:** aperta una nuova campagna BMAD in `docs/bmad/` con prefisso
`module-excellence-*` (product-brief, prd, architecture, brainstorming) e
Epic 12/13/14 aggiunti in coda a [epics.md](./epics.md), invece di
riscrivere `prd.md`/`architecture.md`/`product-brief.md`/`brainstorming.md`
esistenti (che restano scoped a Epic 9 SuperAdmin, come da
[README.md](./README.md)).

**Rationale:** i file senza prefisso sono gia' la SSoT di una campagna in
corso (9.8 in-progress, 10.4 blocked) con lock attivi di altre sessioni.
Sovrascriverli avrebbe cancellato requisiti in uso. La richiesta utente
("studia a fondo il modulo User... perfezione assoluta") ha uno scope
whole-module, non Epic-9-scoped: merita artefatti propri, collegati ma
distinti, sullo stesso pattern gia' visto in questo file per la campagna
Livewire (`livewire-widget-*` prefix accanto ai file scoped Epic 9).

**Perche' Epic 12 e non 11:** l'epic 11 esiste gia' come story singola
(`11.1.team-change-widget.story.md`, correttamente `superseded_by:
10.1`): numero occupato anche se la story e' superseded. 9 e 10 sono
attivi. Il primo numero libero verificato e' 12.

**Quali doc sono canone vs candidati a pulizia futura (non eseguita in
questa sessione):**
- Canone: tutto cio' che e' citato da `module-excellence-prd.md` con
  fonte esplicita (grep, comando eseguito, lettura diretta).
- Candidati a una futura story di pulizia (Epic 12, non eseguita qui):
  i 270 file `*phpstan*.md` corrotti (originali vanno tenuti, i
  duplicati rigenerati da script rotto vanno elencati per cancellazione
  manuale futura), `docs/permissions.md` attuale (contenuto di un altro
  modulo, va sostituito non semplicemente cancellato), `docs/scopo.md`
  (duplicato di `purpose.md`).

**Scope esplicito:** solo documentazione. Nessun file di codice toccato,
nessuna story esistente (9.x/10.x/11.1) rinumerata o cancellata, nessuna
azione DB. Le 24 nuove story sono tutte `status: backlog`.

**Fonte:** 5 ricerche parallele in sola lettura (`Agent
subagent_type: fork`), 2026-09-22: dettaglio completo in
[module-excellence-brainstorming.md](./module-excellence-brainstorming.md).

## [2026-09-22] Riconciliazione numerazione con campagna gemella perfection

**Decision:** scoperta a posteriori una seconda campagna whole-module
(`perfection-*`, stesso scope di `module-excellence`, prodotta in parallelo
senza coordinamento: verosimilmente un fork Agent della stessa richiesta
utente). Nessun file di `module-excellence` toccato: Epic 12-14 restano suoi.
La campagna `perfection` ha rinumerato il proprio draft (Epic 12-16 →
15-19, mai promosso a file story individuali) per evitare collisione,
mantenendo Epic 11 (sicurezza) invariata. Dettaglio completo in
[perfection-decision-log.md](./perfection-decision-log.md).

**Rationale:** stesso principio gia' applicato sopra per Epic 12 vs 11 -
primo numero libero verificato sul filesystem, non assunto dall'indice
`epics.md`. Le due campagne restano additive fra loro come lo sono verso
Epic 9/10.

## [2026-09-22] Riconciliazione con la campagna concorrente "perfection-" (sessione parallela)

**Sintomo:** verifica finale (Fase C del piano) ha trovato, oltre ai 24 file
`12.x`-`14.x` di questa campagna, un secondo set di file non tracciato in git
scritto da un'altra sessione concorrente sullo stesso working tree: doc
`bmad/perfection-{plan,brainstorming,architecture,prd,epics,decision-log}.md`
e `bmad/filament-ux-{brainstorming,architecture}.md`, piu' story file
`docs/stories/11.[1-5]-*.story.md` (formato id con trattino, sicurezza) e un
secondo gruppo di file **`12.1`-`12.6`** con prefisso `filament-ux-*`
(`12.1.filament-xotbase-inheritance.story.md` ... `12.6.policies-resources-
linking.story.md`) che collidono numericamente con i nostri `12.1`-`12.6`.

**Origine:** quella sessione ha rilevato per prima questo lavoro (i suoi
timestamp per `perfection-epics.md`/`decision-log.md` sono successivi ai
nostri di alcuni minuti) e ha gia' documentato la riconciliazione nella sua
`perfection-decision-log.md` (entry "Riconciliazione numerazione con
campagna module-excellence"): ha lasciato **intatti** tutti i file di questa
campagna, e ha rinumerato la propria prosa `perfection-epics.md` da Epic
12-16 a **Epic 15-19**, mantenendo solo Epic 11 (sicurezza) con file story
individuali gia' scritti prima della scoperta.

**Gap residuo non causato da noi:** i 6 file `12.1`-`12.6` prefissati
`filament-ux-*` sono un artefatto orfano della fase *precedente* alla
rinumerazione di quella sessione (scritti insieme ai file
`bmad/filament-ux-*.md`, prima che la campagna adottasse il prefisso
`perfection-` ed Epic 15): la sua stessa nota di verifica li dichiara
implicitamente superati ("le altre story Epic 12-16 non hanno file
dedicato"), ma non li ha rinominati/rimossi fisicamente.

**Decision:** nessuna azione su quei 6 file da questa sessione: non sono di
nostra proprieta', potrebbero essere ancora in scrittura, e la regola
progetto vieta di cancellare/rinominare documentazione di un'altra sessione
senza conferma. I nostri 24 file (`12.1.phpstan-docs-corruption-cleanup.md`
... `14.8.provtv-remote-issue-tracker-divergence.story.md`) restano invariati
e sono gia' l'unico set con tracciamento GitHub reale (issue #103, #105-116,
discussion #104) per l'epic 12-14: nessuna rinumerazione necessaria da parte
nostra, confermato anche dalla verifica indipendente dell'altra sessione.
Segnalato qui solo come nota di igiene per una futura story di pulizia
(candidato naturale: story 12.3 "archive-folders-consolidation" o una nuova
story dedicata, non aperta ora).

**Verifica:** `ls ../stories/ | grep -oE '^1[1-4]\.[0-9]+'` mostra le uniche
collisioni residue essere quei 6 file orfani `12.x` + il file dash `11.1-*`
contro il gia'-superseded `11.1.team-change-widget.story.md`: entrambe
generate e di competenza della sessione "perfection-", non di questa.
Fonte: `bmad/perfection-decision-log.md` (letto integralmente prima di
scrivere questa entry, per [[le-story-del-modulo-si-leggono-prima]]).

## [2026-10-18] LaravelLocalization: firma dei metodi URL

- **Sintomo:** il login su `/it/auth/login` generava `UnsupportedLocaleException`
  con locale `/it` (auth già riuscita; falliva il redirect Livewire).
- **Causa:** `getLocalizedURL($locale, $url)` riceve il **locale** per primo;
  `getLocalizedURL('/' . app()->getLocale())` passava `'/it'` come locale.
  `localizeURL($url, $locale)` è il wrapper corretto (URL per primo).
- **Decisione:** per localizzare un URL usare `localizeURL($url[, $locale])`;
  usare `getLocalizedURL($locale, $url)` solo con locale esplicito supportato.
- **Fix:** `LoginWidget` usa `localizeURL(..., $locale)` con locale trim/validato
  (submit Livewire su `/livewire-*` senza segmento lingua).
- **Fonte API:** [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

## [2026-10-18] authentication_logs su connessione `user`

- **Decisione:** `authentication_logs` vive su `DB_DATABASE_USER` (`fixcity_user`),
  non su `fixcity_data`.
- **Motivo:** model `AuthenticationLog` → `BaseModel::$connection = 'user'`;
  audit auth accanto a `users` / devices / OAuth.
- **Sintomo prod:** connection name `user` ma database `fixcity_data` + tabella
  assente → 500 su failed login.
- **Fix:** migration owner esplicita; duplicato `.php.old`;
  `RecordAuthenticationLogAction` non fa crashare il login se la tabella manca.
- **Artefatto:** [authentication-logs-connection-ownership.md](authentication-logs-connection-ownership.md)

## [2026-10-18] permissions su connessione `user`

- **Decisione:** `permissions` (+ cluster Spatie roles/pivots) vive su
  `DB_DATABASE_USER` (`fixcity_user`), non su `fixcity_data`.
- **Motivo:** identity/authorization è dominio User; model `Permission` /
  `Role` → `$connection = 'user'`; Spatie carica la tabella a ogni `can()`.
- **Sintomo prod:** `GET /it/tickets/1` → Connection `user` ma database
  `fixcity_data` + tabella assente → 500 in `BuildTicketTimelineAction`.
- **Fix:** migration canoniche `create_*`; soft-guard timeline;
  fail-safe `DB_DATABASE_USER`; `config:clear` in deploy.
- **Artefatto:** [permissions-connection-ownership.md](permissions-connection-ownership.md)

## [2026-10-20] PHPStan swarm: ordine permanente e helper test

- **Decisione:** ogni turn non banale con qualita' in scope esegue la catena PHPStan → fix sorgente → docs/prompt senza conferma; helper Pest solo su `Modules/User/tests/TestCase.php` (FQCN nei test), mai `scanFiles` sul neon.
- **Perche:** User e' hub auth/OAuth/Livewire→Widget; errori qui moltiplicano falsi verdi su Lang/Cms se si zittisce. Vittoria = `totals` 0 + `[OK] No errors` sul run del coordinatore.
- **Track:** [filament-blueprint](./filament-blueprint.md), memoria [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md), story [12.1.phpstan-docs-corruption-cleanup](../stories/12.1.phpstan-docs-corruption-cleanup.story.md).

## [2026-10-20] Gate PHPStan Modules: rieseguito OK (audit docs)

- **Verifica:** `cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/User Modules/Comment Modules/Notify Modules/Activity` → exit 0, `[OK] No errors` (config unica `laravel/phpstan.neon`).
- **Docs:** `md-filenames.py check` su `docs/` → 0 violazioni date/suffissi; legacy maiuscole in radice segnalate, nessuna rinomina (tool `name` non propone alias sicuri).
- **Track:** [phpstan-fixes.md](../phpstan-fixes.md), [00-INDEX.md](../00-index.md) (misura modulo), hub [phpstan-modules-zero-gate](../../../Xot/docs/stories/phpstan-modules-zero-gate.story.md).

## [2026-10-26] DCP-285 policy utenti, mail di reset, verify, revoca consensi

- **Policy utenti:** amministra gli utenti solo chi ha `super-admin` (via `before()`), `admin` o `user::admin`; gli altri vedono e aggiornano solo se stessi; nessuno si cancella da solo, super-admin compreso; un amministratore di modulo non modifica ne' cancella un super-admin. Registrata con `Gate::policy(BaseUser::class, UserPolicy::class)` perche' la classe di autenticazione reale (`Modules\Fixcity\Models\User`) non aveva nessuna policy e Filament, senza policy, consente tutto. Le abilita' collettive e secondarie sono definite perche' Filament le concede quando il metodo manca. Story [dcp-285](../stories/dcp-285-correttezza-di-policy-utenti-reset-password-e-revoca-consensi.story.md).
- **Auto-cancellazione cittadino:** `DeleteAccountAction` (Gdpr) fa `Gate::authorize('delete', $user)` sul proprio utente e ora e' negata per costruzione: serve una capacita' dedicata (`deleteOwnAccount`) quando il titolare decide DEC-10/D-01.
- **Mail di reset:** il testo di default lo possiede User (`EnsureResetPasswordMailTemplateAction`, `user::reset_password_email.*` in it/en/de/es), non Notify; mai sovrascrivere un testo personalizzato.
- **Reinvio verifica email:** l'evento `Verified` si lancia solo dopo aver controllato id e hash, mai su un reinvio (`ResendEmailVerificationAction`).
- **Revoca consensi:** si riconosce l'utente da `user_id` + `user_type` (classe e alias morph), mai da `subject_type`. Lo user agent della revoca richiede la colonna `revoked_user_agent`: SCHEMA-DA-CHIEDERE, nessuna migrazione creata.
