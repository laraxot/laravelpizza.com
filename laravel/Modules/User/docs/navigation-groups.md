---
title: "Gruppi di navigazione del modulo User"
type: reference
tags: [navigation, translations, filament]
created: 2026-08-06
updated: 2026-08-06
qmd: "navigation-groups gruppi di navigazione modulo user filament"
---

# Gruppi di navigazione del modulo User

## Perché esiste questa pagina

Il modulo User espone molte risorse e pagine Filament. Il gruppo di navigazione di ognuna
arriva da `navigation.group` nel file di traduzione corrispondente. Prima della
normalizzazione i valori erano incoerenti: `Missing Group` (133 occorrenze), `General` (41),
stringa vuota (22), più una decina di varianti sinonime tra italiano e inglese nello stesso
menu. Il risultato erano gruppi duplicati e voci sparse senza criterio.

## Come Filament legge il gruppo

`Modules\Xot\Filament\Traits\NavigationLabelTrait::getNavigationGroup()` delega a
`TransFuncTrait::transFunc()`, che risolve la chiave `<modulo>::<file>.navigation.group`.
Se il valore è un array, `formatTransFuncResult()` restituisce il **primo elemento**. Per
questo la chiave `name` deve stare per prima:

```php
'navigation' => [
    'group' => [
        'name' => 'Utenti',
        'description' => 'Anagrafiche utenti, profili e dispositivi',
    ],
],
```

La forma a stringa (`'group' => 'Utenti'`) funziona ancora, ma non porta la descrizione:
usare sempre la forma ad array.

Se la chiave manca, `persistGeneratedTransFuncLabel()` scrive a runtime un valore derivato
dal nome del file. È l'origine dei valori spazzatura tipo `pdf style.navigation`: un gruppo
mancante non resta vuoto, si auto-popola con testo privo di senso.

## Tassonomia: sette gruppi

| Gruppo | Contenuto | File di traduzione |
|---|---|---|
| Autenticazione | Accesso, registrazione, credenziali, provider social | `auth`, `login*`, `register*`, `password*`, `reset_password`, `change_password*`, `otp`, `authentication_log*`, `socialite*`, `social_provider*`, `sso_provider*`, `recent_logins`, `email` |
| Utenti | Anagrafiche, profili, dispositivi, notifiche | `user*`, `base_*_user`, `create_user`, `edit_user`, `view_user`, `profile*`, `base_profile*`, `my_profile`, `device*`, `notifications*`, `messages` |
| Ruoli e permessi | Controllo degli accessi | `role*`, `permission*`, `attach_role`, `filament-shield`, `team_permission*` |
| Team e tenant | Organizzazioni, inviti, appartenenze | `team*`, `tenant*`, `tenancy`, `register_tenant`, `customers` |
| OAuth | Client, token, API Passport | `oauth_*`, `passport*`, `client*`, `token*`, `personal_access_token*` |
| Aspetto | Temi, colori, personalizzazioni | `appearance`, `colors`, `background`, `alignment`, `custom_css`, `logo`, `favicon`, `widgets`, `layouts` |
| Impostazioni | Configurazione del modulo | `socialite_provider_settings`, `feature*`, `default`, `fields`, `filters`, `errors`, `validation`, `actions`, `timex` |

Criterio di assegnazione: **cosa fa la voce per chi usa il pannello**, non da quale classe
tecnica discende. `authentication_log` sta in Autenticazione anche se è una risorsa CRUD;
`filament-shield` sta in Ruoli e permessi anche se è un pacchetto di terze parti.

## Regole

1. Ogni file di traduzione con un blocco `navigation` deve avere `group` nella forma ad
   array, con `name` come prima chiave.
2. Il nome del gruppo va tradotto in ogni lingua presente in `Modules/User/lang/`. Un gruppo
   lasciato in inglese dentro un menu italiano crea una seconda voce di menu.
3. Non inventare gruppi nuovi: se una risorsa non rientra nei sette, la discussione è se il
   gruppo serve davvero, non se aggiungerlo di corsa.
4. Mai lasciare `group` assente o vuoto: il trait lo riempie da solo con testo generato.
5. `Missing Group`, `General`, `User` e simili sono segnali di traduzione mai scritta, non
   valori legittimi.

## Verifica

```bash
# nessun gruppo segnaposto residuo
grep -rn "Missing Group\|'group' => ''" laravel/Modules/User/lang/

# elenco dei valori effettivi per lingua
grep -rn "'group' => \[" -A 1 laravel/Modules/User/lang/it/ | grep "'name'" | sort -u
```

## Correlati

- [translation-key-prototype.md](./translation-key-prototype.md)
- [translation-best-practices.md](./translation-best-practices.md)
- [navigation-structure.md](./navigation-structure.md)
- Regola condivisa: `docs/wiki/rules/translation-standards.md`
