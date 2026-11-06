---
title: "Stringhe UI del Filament User tradotte"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: User
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: []
related: ["12.2.hardcoded-labels-translation.story.md (questa la continua, non la sostituisce)", "lang-files-empty-stub-corruption.story.md", "14.7.lang-stub-corruption-audit-scope.story.md", "auth-i18n-all-locales.story.md", "5.1.user-lang-phpstan-debt.story.md", "user-pagine-appearance-salvataggio-o-nascondi.story.md (porta le 6 righe di Clusters/Appearance/Pages)"]
tags: [bmad, i18n, lang, filament, ui]
---

# Stringhe UI del Filament User tradotte

Fase BMAD: Dev (inventario completo, lavoro diviso in 5 tranche con PHPStan).

## Richiesta

Come utente o amministratore che usa il pannello in italiano, inglese o tedesco voglio che ogni etichetta, segnaposto, suggerimento e titolo di notifica del modulo User venga da `lang/`, cosi' che non compaiano testi in una lingua sola o inglese dentro un'interfaccia italiana.

La story 12.2 ha fatto l'inventario di 23 etichette in 8 file ed e' ancora in backlog. Questa ne misura l'intero perimetro (83 righe, 19 file) e lo spezza in tranche eseguibili.

## Scopo

Le stringhe scritte nel codice (`->label('Nome')`) scavalcano il sistema di chiavi di Xot: la chiave attesa e' `user::<classe_in_snake>.fields.<campo>.label` (regola in `Modules/Xot/app/Actions/GetTransKeyAction.php`, usata da `AutoLabelAction`). Chi cambia lingua vede comunque il testo fisso, e i file lang restano segnaposto.

## Stato misurato

Misure del 2026-10-20 alle 13:48 UTC (conteggi) e alle 13:59 UTC (lang), dalla cartella `laravel/Modules/User`. Pattern A (stringa che inizia con una lettera):

```
PA="->(label|title|heading|subheading|placeholder|helperText|hint|tooltip|description|body|modalHeading|modalDescription|modalSubmitActionLabel|emptyStateHeading|emptyStateDescription)\(\s*['\"][A-Za-z]"
rg -c -P -e "$PA" app/Filament --glob '*.php'
```

- Pattern A: 83 righe in 19 file (con `awk -F: '{s+=$2;n++}'` sull'output). Solo `->label(` letterale: 23 righe in 7 file, lo stesso 23 della 12.2 del 2026-09-22: nessuna riga e' stata sistemata da allora.
- Riconciliazione con le 154 riportate dall'altra sessione: non riproducibile. Varianti provate: A in multilinea (`rg -U -o`) 87; qualunque apice dopo la parentesi (`\(\s*['\"]`, include `''`, simboli e numeri) 160 righe in 52 file; con altri metodi (`navigationLabel`, `prefix`, `suffix`, `legend`, notifiche) 90. Il 160 e' il piu' vicino; il 154 resta non classificato.
- Fuori misura (pattern A non li vede): `::make('Titolo con spazi')` 15, proprieta' statiche `$navigationLabel`/`$title`/`$navigationGroup` 28, getter che restituiscono una stringa 12. Conteggi indicativi, non rimisurati con un secondo metodo.
- Delta rispetto alla 12.2: 43 righe sono nei suoi file, 40 no: `TenantForm` 14, `CustomerForm` 14, `MyProfilePage` 3, `PassportDashboard` 3 e le 6 pagine `Clusters/Appearance/Pages/*` (1 ciascuna, assegnate all'altra sessione).
- `TenantForm.php` e `CustomerForm.php` sono identici salvo il nome della classe (`diff` di `sed -n 12,200p` sui due file: una sola riga).

Top 10 file (righe, file lang attesi con la regola di `GetTransKeyAction`, chiavi e valori segnaposto misurati con lo script di sola lettura sotto):

| # | File sotto `app/Filament` | Righe | Lang | it (chiavi / segnaposto) | en | de |
|---|---|---|---|---|---|---|
| 1 | `Resources/TenantResource/Schemas/TenantForm.php` | 14 | `tenant_form` | 38 / 38 | assente | assente |
| 2 | `Resources/TenantResource/Schemas/CustomerForm.php` | 14 | `customer_form` | 38 / 38 | assente | assente |
| 3 | `Pages/SocialiteProviderSettingsPage.php` | 10 | `socialite_provider_settings` | 67 / 66 | 7 / 0 | 7 / 0 |
| 4 | `Resources/UserResource/RelationManagers/ClientsRelationManager.php` | 9 | `client` | 133 / 71 | 8 / 0 | 9 / 1 |
| 5 | `Clusters/Passport/Resources/OauthClientResource/RelationManagers/TokensRelationManager.php` | 6 | `token` | 35 / 8 | 33 / 6 | 1 / 0 |
| 6 | `Clusters/Passport/Resources/OauthPersonalAccessClientResource.php` | 5 | `oauth_personal_access_client` | 51 / 0 | assente | assente |
| 7 | `Resources/TenantUserResource/Schemas/TenantUserForm.php` | 4 | `tenant_user_form` | 14 / 14 | assente | assente |
| 8 | `Resources/TeamUserResource/Schemas/TeamUserForm.php` | 4 | `team_user_form` | 14 / 14 | assente | assente |
| 9 | `Pages/MyProfilePage.php` | 3 | `my_profile` | 9 / 0 | assente | assente |
| 10 | `Clusters/Passport/Pages/PassportDashboard.php` | 3 | `passport_dashboard` | 77 / 34 | 37 / 0 | assente |

I 10 file valgono 72 delle 83 righe. Restano 11: i due `OauthPersonalAccessClientForm` (2 + 2), `SingleRoleSelect` (1), le 6 di Appearance. Cio' che dice il valore segnaposto: un file come `it/tenant_form.php` contiene `'name' => ['label' => 'name', ...]`, cioe' la chiave stessa al posto del testo; per questo qualcuno ha scritto la stringa nel codice.

Script di sola lettura (non scrive nulla; esegue solo l'`include` del file lang), da `laravel`:

```
php -r '$n=$argv[1];$f=function($a,$p="")use(&$f){$o=[];foreach($a as $k=>$v)is_array($v)?$o+=$f($v,"$p$k."):$o["$p$k"]=$v;return $o;};foreach(["it","en","de"] as $l){$x="Modules/User/lang/$l/$n.php";if(!is_file($x)){echo "$l: assente\n";continue;}$a=$f(require $x);$s=0;foreach($a as $p=>$v){$q=explode(".",$p);array_pop($q);if($v===end($q)||$v===implode(".",array_slice($q,1))||$v===implode(".",$q))$s++;}echo "$l: chiavi=".count($a)." stub=$s\n";}' tenant_form
```

## Lavoro

Convenzione chiavi (verificata sul codice esistente, es. `user::password.actions.change_password.modal.heading` e `user::notifications.password_changed_successfully.title`): `fields.<campo>.{label,placeholder,helper_text,description}`, `sections.<nome>.{label,heading}`, `actions.<nome>.{label,tooltip,modal.heading,modal.description}`, `notifications.<nome>.{title,message}`. Nel codice: `__('user::<file>.<chiave>')`, esplicito e cercabile (la `AutoLabelAction` porta l'intestazione `-WIP`, non ci si affida). I segnaposto tecnici (`xxx.apps.googleusercontent.com`, `GOCSPX-xxx`, `openid, email, profile`) vanno in lang con lo stesso valore nelle tre lingue: cosi' il conteggio finale e' 0 senza eccezioni. Testi inglesi esistenti (`Select a role`, `Profile updated!`) diventano italiani in `it` e restano inglesi in `en`.

Tranche (ognuna: edit del PHP, tre file lang, `php -l`, PHPStan con il gate a gruppi di max 8 file):

1. T1, 28 righe: `TenantForm` e `CustomerForm` (8 file toccati). Prima decidere se `CustomerForm` diventa un'estensione di `TenantForm` (decisione 2). Atteso dopo: 55 righe.
2. T2, 13 righe: `SocialiteProviderSettingsPage` e `PassportDashboard` (8 file, il tedesco di `passport_dashboard` va creato). Atteso: 42.
3. T3, 15 righe: `ClientsRelationManager` e `TokensRelationManager` (8 file). Il `client` it ha 133 chiavi: aggiungere solo quelle usate. Atteso: 27.
4. T4, 9 righe: `OauthPersonalAccessClientResource` e i due `OauthPersonalAccessClientForm` (due invocazioni PHPStan). Atteso: 18.
5. T5, 12 righe: `TenantUserForm`, `TeamUserForm`, `MyProfilePage`, `SingleRoleSelect`. Atteso: 6 (le 6 di Appearance sono dell'altra sessione).

Rischio: i test che asseriscono le stringhe inglesi vanno aggiornati (lo dice gia' la 12.2); cercarli prima con `rg -n "Select a role|Profile updated" Modules/User/tests`. Rischio lang: un file lang vuotato da un'operazione precedente (story `lang-files-empty-stub-corruption`): prima di scrivere un lang, `git -C Modules/User log -1 --format=%h -- lang/it/<file>.php` e controllare che il file non sia stato troncato.

## Acceptance criteria

- [ ] A fine tranche il conteggio del pattern A scende al valore atteso della tranche (83, 55, 42, 27, 18, 6); a fine lavoro piu' Appearance: `rg -c -P -e "$PA" app/Filament --glob '*.php'` non stampa nulla. Controprova: prima della tranche T1 stampa 19 file.
- [ ] Per ogni file lang toccato lo script mostra `stub=0` e lo stesso numero di `chiavi` in it, en e de.
- [ ] Nessun PHP toccato usa piu' un letterale: `rg -n -P -e "$PA" <file toccati>` vuoto.
- [ ] `php -l` pulito e PHPStan (gate condiviso) exit 0 su ogni gruppo di file.
- [ ] La 12.2 viene aggiornata dal coordinatore con un rinvio a questa story (non da questa).

## Verifica

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel/Modules/User && rg -c -P -e "$PA" app/Filament --glob '*.php' | awk -F: '{s+=$2;n++} END{print n" file, "s" righe"}'` dopo ogni tranche.
2. Lo script lang sui file della tranche, nelle tre lingue.
3. Test del pannello solo dopo guardia e verdetto utente; fino ad allora nessuno (Pest fermo).

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: solo `it`, `en`, `de` (le altre cartelle locale sono fuori perimetro); additivo, nessuna rinomina di chiavi gia' usate altrove; nessun testo scritto in lang con valore uguale alla chiave.

## Decisioni aperte

1. Chi rivede il tedesco: le stringhe `de` le scrive un agente e restano "da rivedere". Raccomandato: si, con una nota nella tranche; revisione madrelingua prima di una release.
2. `CustomerForm` e `TenantForm` sono copie: unificarle (una estende l'altra) prima di tradurre, cosi' si traduce una volta. Raccomandato: si, ma e' un cambio di struttura; in alternativa tradurre entrambe con le stesse chiavi.
3. Estendere il ratchet ai 55 casi fuori misura (`Section::make('...')`, proprieta' statiche, getter) in una story successiva. Raccomandato: si, dopo il zero sul pattern A.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel/Modules/User && rg -c -P -e "$PA" app/Filament --glob '*.php'` (definire `$PA` come sopra): confermare 83 righe e 19 file.
2. `sed -n 15,80p app/Filament/Resources/TenantResource/Schemas/TenantForm.php` e `sed -n 1,60p lang/it/tenant_form.php`: partire dalla tranche T1 (decisione 2 prima).
3. Scrivere le chiavi in `lang/{it,en,de}/tenant_form.php`, sostituire le 14 stringhe con `__('user::tenant_form.fields.<campo>.<tipo>')`, poi `php -l`, lo script lang e PHPStan.
