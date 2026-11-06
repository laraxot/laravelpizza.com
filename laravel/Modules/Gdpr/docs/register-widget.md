---
title: "RegisterWidget: registrazione del cittadino con consensi"
type: note
tags: [documentation, registration, gdpr, consent]
created: 2026-09-26
updated: 2026-10-14
qmd: "register widget registrazione cittadino consensi informativa condizioni password rate limit treatments consents prova dcp-178"
issues: []
discussions: []
status: stable
related:
  - ./consents.md
  - ./terms-conditions.md
  - ./stories/dcp-178-registrazione-e-disiscrizione-a-norma.story.md
---

# RegisterWidget: registrazione del cittadino con consensi

Widget Livewire `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget`. La registrazione pubblica passa sempre da qui, perche' e' l'unico punto che lascia la prova di cio' che il cittadino ha accettato.

```blade
@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
```

## Vista
`getView()` risolve `filament.widgets.auth.register`: nel progetto e' `Themes/Sixteen/resources/views/filament/widgets/auth/register.blade.php` (il tema Meetup non ha piu' la sua copia). Le caselle sono proprieta' pubbliche Livewire e non componenti Filament, cosi' la vista puo' mettere i link ai documenti nella lingua corrente.

## Campi e regole (`rules()` e `messages()`)
| Campo | Regola |
|---|---|
| `first_name`, `last_name` | obbligatori, 2-255 caratteri |
| `email` | obbligatoria, valida, unica in `user.users` |
| `password` | `Password::defaults()` (configurata da `PasswordData` in `UserServiceProvider`: lunghezza minima 8, maiuscole e minuscole, lettere, numeri, simboli, non compromessa) |
| `password_confirmation` | uguale a `password` |
| `privacy_accepted`, `terms_accepted` | `accepted`: obbligatorie, non preselezionate, messaggi tradotti `gdpr::register.consents.*_required` |
| `marketing_consent` | facoltativa |

Le regole stanno in `rules()` e non in `#[Validate]`: gli attributi non accettano oggetti come `Password::defaults()` e il messaggio `message: ''` mostrava «privacy accepted deve essere accettato.» al posto del testo tradotto.

## Cosa fa `submit()`
1. Limite ai tentativi: 10 invii ogni 600 secondi per indirizzo IP (chiave `register|<ip>`), contati anche se non validi; oltre, errore sul campo email (`gdpr::register.throttle`). Il login ha un limite diverso (5 in 60 s per email+IP).
2. `validate()` sulle regole sopra, poi `ValidateGdprConsentAction` (controllo ripetuto lato server).
3. `ValidateUserDataAction`: email duplicata, password cifrata, `type = customer_user`, lingua corrente, **`email_verified_at = now()`** (vedi limiti).
4. Transazione sulla connessione `user`: `CreateUserAction`, `SaveGdprConsentsAction`, `LogRegistrationAction`.
5. `HandleSuccessfulRegistrationAction`: accesso immediato, notifica, ritorno alla pagina richiesta (`redirectIntended`) o home della lingua.

## Prova dei consensi (`SaveGdprConsentsAction`)
Scrive tre righe in `consents` (connessione `gdpr`), una per trattamento: `privacy_policy`, `terms_conditions`, `marketing_consent`. `accepted_at` e' valorizzato solo se la casella era spuntata. Ogni riga porta `ip_address`, `user_agent` e in `metadata`: `document_version`, `document_url`, `locale`.
I trattamenti si creano al volo (`firstOrCreate`) se mancano: prima `treatments` era vuota, il seeder non era chiamato da nessuno e la registrazione non lasciava nessuna prova. La versione `1.0` e' provvisoria: deve seguire la versione dell'informativa e delle condizioni pubblicate.
La transazione e' sulla connessione `user` e i consensi sono sulla connessione `gdpr`: le due scritture non sono atomiche (se i due database coincidono, in caso di errore i consensi gia' scritti restano senza utente).

## Limiti noti (non risolti)
- `email_verified_at` e' impostata alla registrazione e non c'e' nessuna verifica, ma il modulo dice «Ti invieremo un'email di conferma»; la rotta `verification.verify` non esiste.
- Nessuna eta' minima ne' dichiarazione.
- La casella `marketing_consent` e' registrata ma nessuna funzione la usa.
- Il controllo `uncompromised` della password interroga un servizio esterno (HaveIBeenPwned, solo i primi 5 caratteri dell'impronta): va citato nell'informativa o spento in `PasswordData`.
- Cancellazione e revoca del consenso in autonomia non esistono. Decisioni aperte: [DCP-178](./stories/dcp-178-registrazione-e-disiscrizione-a-norma.story.md).

## Test
`Modules/Fixcity/tests/Feature/Auth/RegistrationConsentTest.php`: consensi obbligatori con messaggio tradotto, password debole, prova con versione del documento, consenso facoltativo, link a informativa e condizioni in 4 lingue, limite ai tentativi. I test del modulo Gdpr non avviano l'applicazione: i test della registrazione stanno in Fixcity.

## Accessibilita
Bersagli di almeno 44 px di altezza, focus visibile, etichetta associata a ogni casella, link che si aprono in una nuova scheda con testo per lettore schermo.
