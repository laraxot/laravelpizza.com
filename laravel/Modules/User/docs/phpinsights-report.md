# phpinsights report

## stato 2025-11-12 (sessione corrente)
- **scope analizzato**: `Modules/User/app`
- **esecuzione**: `./vendor/bin/phpinsights analyse Modules/User/app --no-interaction --format=json`
- **esito generale**: punteggi qualità/architettura/stile sotto soglia a causa di
  - classi non final / non abstract richieste dalla regola `ForbiddenNormalClasses`
  - funzioni con lunghezza e complessità oltre i limiti (es. `RetrieveSocialiteUserAction::execute`, `PasswordExpired::getFormSchema`)
  - formattazione: parentesi, ordine proprietà/metodi e importazioni in widget/risorse Filament
  - linee > 120 caratteri e uso di snake_case in proprietà/variabili punctual

## correlazione con phpmd
- comando: `./vendor/bin/phpmd Modules/User/app text phpmd.xml`
- warning tipici: `CamelCaseVariableName`, `UnusedFormalParameter`, `CyclomaticComplexity`, `BooleanArgumentFlag`
- focus prioritari:
  1. rinominare proprietà/parametri snake_case nelle `Data` e negli `Actions`
  2. rimuovere parametri inutilizzati nelle policy/command
  3. spezzare metodi ad alta complessità (stessa lista di phpinsights)
  4. rimuovere `exit` nei widget Filament (Logout/Password)

## correzioni applicate in questa sessione
- normalizzazione automatica (braces, ordered elements, ordered imports) su eventi, policy, modelli e comandi principali
- sistemazione istanziazioni senza parentesi (`new Class`) e config `.php-cs-fixer`
- aggiornamento `PasswordValidationRules` (`new Password()`) e `InteractsWithTenant` (`new TenantScope()`)

## attività ancora aperte
1. **architettura**
   - rendere `final` o `abstract` le classi semplici (modelli, provider, notifications, support)
2. **complessità**
   - rifattorizzare metodi con CC / NPath > soglia (`RetrieveSocialiteUserAction::execute`, `UserNameFieldsResolver::resolveNameFields`, `PasswordExpiredWidget::handleResetError`, ecc.)
3. **stile**
   - ridurre lunghezza linee > 120
   - portare proprietà/variabili a camelCase (es. `PasswordData`, `HasTeams`)
   - riordinare importazioni restanti segnalate da `AlphabeticallySortedUses`
4. **ri-esecuzioni**
   - ripetere `phpinsights` e `phpmd` dopo i fix
   - integrare controlli con `phpstan` livello 10

> Nota: mantenere l'analisi focalizzata sul codice di produzione (`Modules/User/app`). Estendere ai test solo dopo aver stabilizzato le convenzioni.