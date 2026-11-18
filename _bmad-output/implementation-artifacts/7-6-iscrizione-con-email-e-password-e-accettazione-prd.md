# Story 7.6: Iscrizione con email e password dalla pagina evento e test di accettazione del PRD

Status: review

## Story

As a Visitatore,
I want iscrivermi a un evento direttamente dalla sua pagina con email e password,
so that non devo passare da una registrazione separata (PRD FR-9, "minimo attrito").

## Acceptance Criteria

1. Email nuova → account (consensi privacy e termini salvati come prova GDPR), iscrizione, email di conferma, login.
2. Email esistente con la password giusta → iscrizione; con un'altra password → errore chiaro, nessun salvataggio.
3. Email non valida, password debole, consenso mancante, evento pieno → errore prima di salvare (FR-11).
4. Tentativi limitati per indirizzo IP.
5. Ogni "Consequence (testable)" di FR-14, 15, 16, 18, 20 ha un test (`PrdAcceptanceTest`).
6. `/events` senza lingua → redirect a `/{lingua del browser o di default}/events`; `hreflang` su ogni pagina.

## Tasks / Subtasks

- [x] `SignUpAndJoinEventAction`, componente `EventRegistration::signUp()`, vista, traduzioni; test `EventSignUpTest` (9)
- [x] Messaggi di validazione Laravel in it/de/fr/es/ru (`lang/*`, da laravel-lang/lang): prima erano in inglese
- [x] `RedirectUnlocalizedPath` (middleware globale Cms) + `RedirectUnlocalizedPathAction`
- [x] `hreflang` nel layout del tema; testi legali e aria-label tradotti (FR-17)
- [x] Rimosse 53 viste inutilizzate portate da un tema Bootstrap Italia di un altro progetto
- [x] `PrdAcceptanceTest` (9 test)
