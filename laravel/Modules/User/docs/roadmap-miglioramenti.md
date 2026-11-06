---
title: "User: cosa migliorerei se questo modulo fosse mio per un mese"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user]
qmd: "user   cosa migliorerei se questo modulo fosse mio per un mese user"
---
# User: cosa migliorerei se questo modulo fosse mio per un mese

> I numeri misurati sono in [`docs/cosa-migliorare.md`](cosa-migliorare.md),
> rilevati da un'altra sessione il 2026-09-01: PHPStan 0, PHPMD `app/` **471**,
> Code 90.6, Arch 78.6, **1137 casi test: il più alto dei cinque moduli qui
> analizzati**, coverage 70,1%. Questo file non rimisura: legge quei numeri e
> ci mette sopra la lente.

666 file in `app/`, secondo modulo più grande del monorepo dopo Xot: e con
`require-dev` ridotto a due righe: `phpstan/phpstan` e
`phpstan/phpstan-deprecation-rules`. Niente `larastan`. Un modulo che gestisce
autenticazione (`laravel/passport`), 2FA, social login (Auth0, Microsoft) e
export di dati personali (`spatie/laravel-personal-data-export`: GDPR, non
un dettaglio) sta girando PHPStan SENZA le regole specifiche di Laravel/Eloquent
che larastan aggiunge. È come fare un controllo antincendio guardando solo se
la porta è chiusa, ignorando se ci sono estintori.

## 1. Larastan mancante non è un dettaglio, è un buco nella superficie di controllo

Xot ha `larastan/larastan` in `require-dev`; User no. Significa che tutte le
regole Eloquent-specifiche (relazioni non tipizzate, `$fillable` incoerente
coi cast, query builder generics) su un modulo che tocca `Auth::user()`,
password reset e 2FA passano SENZA controllo aggiuntivo oltre il PHPStan
generico. Prima cosa da fare, letteralmente un comando: allineare
`require-dev` a quello di Xot (la stessa lista di 21 pacchetti che ho già
misurato lì) e rilanciare `phpstan analyse Modules/User` per vedere cosa
emerge: probabilmente non zero.

## 2. Solo 3 `dd()`/`dddx()` e 1 `@phpstan-ignore`: questo è il modulo pulito

In controtendenza rispetto a Xot: pochissimo debug residuo, pochissime
soppressioni. Non è un caso: è la prova che quando il modulo è più piccolo
e più recente il debito non fa in tempo ad accumularsi. Vale la pena
CAPIRE perché questo modulo è così pulito (data recente? un solo autore
principale? meno agenti concorrenti sopra?) e replicare quella condizione,
non solo il risultato.

## 3. `docs/`: 1479 file, 205 famiglie di doppioni, e il caso più assurdo:
`actions-path-convention.md` in QUATTRO varianti

`actions-path-convention.md`, `actions-path-convention.md`,
`actions-path-convention.md`, `actions-path-convention-convenzione-percorsi.md`,
`actions-path-convention.md`, `actions_path_convention.md`: stesso
contenuto concettuale (probabilmente), quattro file, tre convenzioni di
naming diverse (trattino, trattino basso, suffisso numerico) per lo STESSO
argomento. Se un agente futuro cerca "action path convention" con `qmd`,
prende in pancia quattro risultati che si contraddicono a vicenda su quale
sia la fonte di verità. Il fix strutturale (uno script di raggruppamento +
revisione umana per gruppo, come proposto per Xot) vale doppio qui perché il
dominio: autenticazione: è quello dove un doc obsoleto letto per sbaglio
da un agente ha conseguenze di sicurezza, non solo di stile.

## La visione, in una riga

User è il modulo che dimostra che si può stare puliti nel codice (3 dd, 1
ignore) pur avendo un buco di configurazione invisibile (larastan assente) -
la lezione per tutto il monorepo è che "pochi warning" non vuol dire "ben
controllato", vuol dire anche "controllato con lo strumento giusto". 1137
casi test sono il numero più alto tra i cinque moduli di oggi, ma il
coverage si ferma al 70,1%: significa che si scrivono TANTI test, non
necessariamente sui rami giusti. Prima di festeggiare zero errori PHPStan
su un modulo, controllare SEMPRE quali regole sono effettivamente attive E
cosa il coverage sta davvero coprendo.

---
*Analisi generata il 2026-09-01, dati verificati sul codice (grep/find), non
sulla documentazione esistente.*
