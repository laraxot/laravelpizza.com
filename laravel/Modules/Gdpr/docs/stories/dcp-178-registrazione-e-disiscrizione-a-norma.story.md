---
id: dcp-178
title: "DCP-178: registrazione del cittadino e disiscrizione a norma (consensi, prove, cancellazione)"
type: story
epic: dc-parity-v2
status: in-progress
priority: P0
owner: module:Gdpr
module: Gdpr
created: 2026-10-14
updated: 2026-10-14
qmd: "registrazione cittadino consenso informativa condizioni d'uso prova consenso treatments password email verificata cancellazione account revoca disiscrizione gdpr pa"
related: [dcp-140, dcp-141, dcp-153, dcp-154, dcp-165, dcp-130, dcp-162, 2026-10-14-dcp-164-registrazione-consenso-obbligatorio-PA]
---
# DCP-178: registrazione del cittadino e disiscrizione a norma

Fase BMAD: Analyze, Implement, Verify. Richiesta dell'utente (2026-10-14): controllare la registrazione, che deve far accettare le regole d'uso, e la possibilita' di disiscriversi; il progetto va consegnato alla PA.

## Esito della verifica (prove del 2026-10-14, DB di sviluppo e test su DB di prova)
| # | Punto | Esito | Prova |
|---|---|---|---|
| 1 | Informativa e condizioni obbligatorie, non preselezionate, controllate dal server | conforme | test `RegistrationConsentTest` |
| 2 | Prova di cio' che il cittadino ha accettato | **mancava**, corretto | `treatments` vuota, seeder mai chiamato, `SaveGdprConsentsAction` saltava in silenzio: dopo la registrazione 0 righe in `consents` |
| 3 | Versione del documento accettato | **mancava**, corretto | ora `consents.metadata.document_version`; il valore `1.0` e' provvisorio |
| 4 | Regole sulla password | **mancavano**, corretto | il widget accettava qualsiasi stringa; ora `Password::defaults()` (8 caratteri, maiuscole, numeri, simboli, non compromessa) |
| 5 | Messaggio se si dimentica una casella | **errato**, corretto | «privacy accepted deve essere accettato.» al posto del testo tradotto |
| 6 | Collegamento a informativa e condizioni dal modulo | **mancava**, corretto | nessun `<a>` nella sezione dei consensi; ora 2 link in 4 lingue, nuova scheda, testo accessibile |
| 7 | Esistenza dei testi che si fanno accettare | **bloccante, dati dell'ente** | `/it/terms` e `/it/privacy` mostrano «Testo non ancora completo»; nuovo controllo `LEG-04` del gate (12 pagine su 20) |
| 8 | Verifica dell'indirizzo email | **non conforme, da decidere** | `email_verified_at => now()` alla registrazione, accesso immediato, ma il modulo promette «Ti invieremo un'email di conferma». La rotta `verification.verify` non esiste |
| 9 | Disiscrizione e cancellazione in autonomia | **non disponibile** | l'area personale rinvia l'istanza all'ente (contatti ancora segnaposto); `DeleteAccountWidget` non e' raggiunto da nessuna pagina; `DeleteUserAction` cancella la riga utente (senza SoftDeletes) e lascia le segnalazioni con `owner_id` orfano (colonna NOT NULL, nessuna chiave esterna), e il widget ignora l'esito |
| 10 | Revoca del consenso | **non disponibile** | la tabella ha `revoked_at`, nessuna schermata la usa (GDPR art. 7 par. 3: revocare facile come dare) |
| 11 | Limite ai tentativi di registrazione | **mancava**, corretto | il login ha 5 tentativi in 60 s (G-07); la registrazione ora 10 invii ogni 600 s per IP (`RateLimiter`, chiave `register|<ip>`), messaggio tradotto, test |
| 12 | Maggiore eta' / eta' minima | **non gestita** | nessun campo ne' dichiarazione (DCP-165) |

## Corretto in questa story
- `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`: regole e messaggi in `rules()`/`messages()`; password con `Password::defaults()`.
- `Modules/Gdpr/app/Actions/SaveGdprConsentsAction.php`: i tre trattamenti si creano se mancano; ogni consenso porta versione, URL e lingua del documento.
- `Themes/Sixteen/resources/views/filament/widgets/auth/register.blade.php` e `Modules/Gdpr/lang/{it,en,de,es}/register.php`: link a informativa e condizioni; refuso «(facoltativo]».
- Test: `Modules/Fixcity/tests/Feature/Auth/RegistrationConsentTest.php` (9 casi, con i 4 per lingua): i primi 4 rossi prima della correzione, tutti verdi dopo; PHPStan a zero e Pint passato sui file toccati.
- Gate `go-live-gate.py`: `LEG-04` (testi legali senza avviso di testo incompleto).
- Docs: `Modules/Gdpr/docs/register-widget.md` riscritta sul codice reale (indicava `Themes/Meetup`, `saveAllGDPRConsents`, `gdpr_consents`), `terms-conditions.md` da stub a pagina vera, `INDEX.md` corretto (etichetta guasta, link), nota di verifica in DCP-164 (altra sessione) e in DCP-140.

## Da decidere con il DPO e l'ente (non e' una scelta tecnica)
1. **Base giuridica.** Per un ente pubblico il consenso non e' di norma la base adeguata per il servizio (squilibrio di posizione, considerando 43 GDPR; base tipica art. 6 par. 1 lett. e). Le etichette inglesi, tedesche e spagnole («accetto il trattamento dei miei dati») e il seeder `data_processing` («consenso al trattamento per la gestione dell'account») presentano il consenso come base. Proposta: una sola dichiarazione «ho letto l'informativa» (presa visione) piu' l'accettazione delle condizioni d'uso, senza consenso al trattamento del servizio.
2. **Marketing.** `marketing_consent` e' registrato ma nessuna funzione lo usa: non esiste alcun invio di aggiornamenti. Proposta: togliere la casella finche' non c'e' un servizio reale, con link di disiscrizione in ogni messaggio.
3. **Verifica dell'email** (punto 8). Proposta: `email_verified_at` nullo, rotta e pagina di verifica, e `verified` come requisito per creare una segnalazione; richiede posta in uscita funzionante (DCP-155). In alternativa, togliere la frase finche' la verifica non esiste.
4. **Cancellazione dell'account** (punto 9, DCP-140). Proposta di default da approvare: l'utente chiede la cancellazione dall'area personale con password; i dati personali dell'utente vengono resi anonimi (nome, cognome, email), le sessioni e i token si eliminano, le segnalazioni restano senza autore riconoscibile se di interesse pubblico, i consensi restano come prova pseudonimizzata per il periodo di conservazione (DCP-141). Non implementata: e' irreversibile e dipende dalla regola sui ticket.
5. **Versione dei testi.** `document_version` `1.0` deve diventare la data o il numero di versione dell'informativa e delle condizioni pubblicate; ad ogni nuova versione si chiede una nuova accettazione.
6. **Conservazione di IP e user agent** nel registro dei consensi: finalita' e durata da dichiarare nell'informativa (DCP-141); oppure non registrarli.
7. **Eta' minima** (DCP-165).
8. **Controllo password contro i dati noti compromessi**: `uncompromised` interroga HaveIBeenPwned (terza parte, solo i primi 5 caratteri dell'impronta). Da citare nell'informativa o disattivare in `PasswordData`.

## Criteri di accettazione
- [x] La registrazione senza informativa e condizioni e' rifiutata con un messaggio tradotto (test).
- [x] Dopo la registrazione esistono tre righe di consenso con versione del documento (test).
- [x] Password debole rifiutata (test).
- [x] Link a informativa e condizioni nel modulo, in 4 lingue (test).
- [x] Limite ai tentativi di registrazione (test).
- [ ] Verifica dell'email (decisione 3).
- [ ] Cancellazione e revoca del consenso in autonomia, con regola sui ticket (decisioni 1 e 4, DCP-140).
- [ ] Testi di informativa e condizioni pubblicati dall'ente (gate `LEG-04` verde).

## Non verificato
Invio reale della posta; comportamento su Firefox e Safari; lettore schermo sul modulo; l'effetto di `Password::defaults()` sulle password gia' esistenti (non si toccano: la regola vale solo alla creazione e al cambio).

## Verifica della cancellazione scritta da un'altra sessione (2026-10-14, sera)
Tra le 14:25 e le 14:36 un'altra sessione ha aggiunto, non committate, `Modules/Gdpr/app/Actions/Account/DeleteAccountAction.php` e `Modules/Gdpr/app/Actions/Consent/RevokeGdprConsentsAction.php`, con la rotta `GET|POST /{lang}/account/delete` (`Modules/Gdpr/routes/web.php`, nome `account.delete`, middleware `auth`). Provate con un test di prova su DB di scratch (poi eliminato; DB di sviluppo invariato: 11 utenti, 18 segnalazioni):
- **Non funziona sullo schema reale.** `DeleteAccountAction::execute()` lancia `QueryException: Unknown column 'revoked_user_agent' in 'SET'`: la tabella `consents` ha `revoked_at` e `revoked_ip_address`, non `revoked_user_agent`. La transazione sulla connessione `user` fa rollback; l'utente vedrebbe un errore 500. Sempre sullo schema, `consents` non ha nemmeno `subject_type`, usata da `recordDeletionConsent()` e dal filtro di revoca: fallirebbe subito dopo.
- **Anche corretti i nomi di colonna, non basta.** `users.deleted_at` e `deleted_by` esistono, ma il modello `User` NON usa `SoftDeletes` (`// use SoftDeletes;` in `BaseUser`): una query predefinita troverebbe ancora l'utente «cancellato» e il login funzionerebbe (da provare dopo la correzione; oggi bloccato dall'errore sopra). Il soft-delete non toglie nome ed email, quindi non e' una cancellazione ai sensi dell'art. 17 e non risolve le segnalazioni con `owner_id` NOT NULL.
- La revoca filtra per `subject_id`/`subject_type`, mentre la registrazione (`SaveGdprConsentsAction`) scrive `user_id`/`user_type` e `subject_id`: i consensi della registrazione non verrebbero trovati.
- Nessun test, nessuna pagina raggiunge la rotta, e la transazione sulla connessione `user` non copre le scritture su `gdpr`.
**Decisione presa da me: non l'ho corretta.** Farla «funzionare» cosi' com'e' darebbe all'utente un «account cancellato» che resta utilizzabile e con i dati in chiaro, peggio dell'errore di oggi. Serve la regola sui dati (anonimizzazione o cancellazione, destino delle segnalazioni, conservazione dei consensi come prova) approvata dal DPO; poi si riscrive l'azione sullo schema reale con test (un utente cancellato non entra piu', nessuna email in chiaro, l'altro utente non cambia). Se l'altra sessione la sta ancora scrivendo, questa nota le dice dove si rompe.

