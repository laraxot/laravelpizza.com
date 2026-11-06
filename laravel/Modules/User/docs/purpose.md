---
title: "User: scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [user, purpose, identita, autorizzazione, profilo, oauth, team]
qmd: "user scopo modulo identita autorizzazione profilo oauth passport team ruoli permessi contract"
updated: 2026-09-02
issues:
  # DA CREARE: `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_user_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_user_fila5/issues/"
discussions:
  # DA CREARE: vedi sopra.
  - "https://github.com/provtv/module_user_fila5/discussions/"
---

# User: perche' esiste

## Lo scopo in una frase

**User risponde a tre domande e non ad altre: chi sei, cosa puoi fare, per conto di
chi. Tutto il resto che si sa di una persona appartiene al dominio, non a User.**

## L'evidenza

- 666 file PHP, 57 Action, **20 Widget**: il numero di widget dice che qui l'interfaccia
  conta: login, profilo, gestione team sono superfici che l'utente tocca davvero.
- OAuth completo (`OauthClient`, `OauthAccessToken`, `OauthRefreshToken`,
  `OauthAuthCode`, `OauthPersonalAccessClient`): non solo login web, anche accesso
  programmatico.
- `AuthenticationLog`, `Device`: chi e' entrato, da dove. In una pubblica
  amministrazione non e' un lusso, e' un requisito.
- `Feature` (Pennant): funzionalita' attivabili per utente o per contesto.
- `BaseUser`, `BaseProfile`: classi base, quindi punti di estensione previsti.

## La distinzione che regge tutto: utente ≠ profilo ≠ dipendente

Sono tre cose diverse e confonderle e' l'errore piu' costoso in questo dominio:

| Concetto | Cos'e' | Dove vive |
|---|---|---|
| **User** | credenziali e permessi | User |
| **Profile** | i dati della persona come utente della piattaforma | User |
| **Dipendente** | la persona nell'organico dell'ente, con matricola e storia | Sigma |

Un utente puo' non essere un dipendente (un consulente, un revisore). Un dipendente
puo' non avere un utente. Il collegamento e' una relazione, non un'identita'.

**Corollario operativo verificato:** nei PHPDoc, i riferimenti a creatore/aggiornatore
vanno tipizzati su `Modules\Xot\Contracts\ProfileContract`, **mai** sulla classe
concreta di un modulo verticale. Tipizzare sul concreto lega Xot al dominio e inverte
la dipendenza.

## Come raggiungerlo **meglio**

### 1. Il README dichiara cose false, e questa e' la prima cosa da sistemare

Oggi `README.md` mostra badge "Laravel 12", "PHP 8.4+", "PHPStan Level 10" e contiene
il placeholder mai sostituito `<nome progetto>`. La verita' misurata:
Laravel `^13.0`, PHP `^8.3`, PHPStan `level: max` (il progetto vieta esplicitamente di
passare `--level`).

Un badge che mente e' peggio di un badge assente: fa saltare la verifica a chi legge.

### 2. 666 file PHP e un README di 56 righe

E' il rapporto peggiore del progetto fra codice e spiegazione. Chi entra in User non ha
un punto di partenza proporzionato a cio' che trovera'.

**Azione:** oltre a questo documento, una mappa in `docs/index.md` che dica dove
guardare per: login, ruoli e permessi, team, profilo, OAuth, feature flag. Sei voci.

### 3. I permessi vanno documentati come contratto, non dedotti dal seeder

Con Spatie Permission il rischio e' che il vero elenco dei permessi viva solo nel
seeder. Chi deve capire "chi puo' approvare una scheda" finisce a leggere codice.

**Azione:** `docs/permissions.md` con la matrice ruolo → permessi → cosa consente in
concreto, e un test che verifichi che i permessi usati nelle Policy esistano davvero.
Un `can('x')` con permesso inesistente **nega in silenzio**: sembra una scelta di
sicurezza, e' un bug.

### 4. Team e multi-tenancy non devono sovrapporsi

`Team` (qui) e `Tenant` (modulo Tenant) sono due meccanismi di separazione. Se
entrambi decidono "cosa vedo", la regola effettiva diventa la loro intersezione: e
nessuno dei due documenti la descrive.

**Azione:** dichiarare qui quale dei due e' il confine dei dati e quale
l'organizzazione interna. Una frase, ma va scritta.

### 5. Il log di accesso va usato, non solo scritto

`AuthenticationLog` e `Device` raccolgono dati preziosi che oggi nessuna schermata
interroga.

**Azione:** una vista "accessi anomali" (nuovo dispositivo, orario inusuale). Il dato
c'e' gia': manca la domanda.

## Confini: cosa **non** appartiene a User

- I **dati di servizio** del dipendente (matricola, categoria, struttura): Sigma.
- Le **valutazioni**: moduli di dominio.
- L'**infrastruttura Filament**: Xot.
- Le **notifiche**: Notify. User decide *chi* puo' ricevere, non *come* si spedisce.

## Collegamenti

- `laravel/Modules/Tenant/docs/purpose.md`: l'altro asse di separazione
- `laravel/Modules/Xot/docs/purpose.md`: `ProfileContract` e le classi base
