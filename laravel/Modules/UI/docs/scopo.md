---
title: "UI — scopo, confini e come servirlo meglio"
type: concept
module: UI
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, componenti, filament, blade, dipendenze]
qmd: "scopo ui libreria componenti condivisi filament forms components tables columns consumatori confini"
---

# UI — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

UI non ha modelli di dominio, non ha migrazioni proprie che il resto del progetto
consumi, non ha un utente finale. Ha componenti: 16 classi in
`app/Filament/Forms/Components/` (15 nella root più `Field/QrReader`), 11 in
`app/Filament/Tables/Columns/`, 11 in `app/View/Components/`, 243 file Blade in
`resources/views/components/`. È l'unico
modulo del monorepo la cui ragione d'essere è **essere importato**.

Tre fatti misurati il 2026-09-02 lo dimostrano:

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| Dipendenze uscenti: 73 file verso `Modules\Xot`, **1** verso `Modules\User` | `grep -rl 'Modules\\<M>\\' Modules/UI/app` | la regola di dipendenza dichiarata nel README regge: UI guarda solo la piattaforma base |
| 9 moduli la importano, 40 file in tutto | `grep -rl 'Modules\\UI\\' Modules/<M>` | è infrastruttura condivisa, non una foglia |
| L'export più usato è una **colonna**, non un campo: `GroupColumn` in 29 file | `grep -rho 'use Modules\\UI\\[A-Za-z\\]*'` | il valore reale che UI eroga oggi passa da `Tables/Columns`, non da `Forms/Components` |

Da qui la formulazione in una riga:

> **UI è il vocabolario condiviso dell'interfaccia: il posto dove un blocco di
> markup o di campi smette di essere copiato e diventa una parola che tutti i
> moduli pronunciano allo stesso modo.**

I consumatori, misurati su `app/` + `resources/` + `tests/` di ogni modulo:

| Modulo | File che importano `Modules\UI\` |
|---|---:|
| Ptv | 14 |
| Performance | 9 |
| Xot | 5 |
| Progressioni | 4 |
| Media | 2 |
| Incentivi | 2 |
| User, IndennitaResponsabilita, IndennitaCondizioniLavoro | 1 ciascuno |
| **Themes/One, Themes/Three, Themes/Zero** | **0** |

Gli import più frequenti dicono cosa il progetto compra davvero da UI:

```
29  Modules\UI\Filament\Tables\Columns\GroupColumn
16  Modules\UI\Enums\TableLayoutEnum
 7  Modules\UI\Models\Category
 6  Modules\UI\Actions\Icon\GetAllIconsAction
 5  Modules\UI\Filament\Traits\HasTableLayoutPage
 3  Modules\UI\Filament\Forms\Components\AddressField
```

## I confini, e dove oggi sono rotti

### 1. I componenti-vocabolario non stanno in UI

La regola del progetto
([filament-form-components-vocabulary](../../../../docs/wiki/rules/filament-form-components-vocabulary.md))
dice che un blocco di campi ripetuto in più form diventa un componente in
`app/Filament/Forms/Components/` che estende `XotBaseSection`/`XotBaseGroup`. Nel
monorepo 13 classi lo fanno. **Nessuna sta in UI.**

```
9  Modules/Ptv/app/Filament/Forms/Components/     (RepartoSection, PeriodoSection, …)
1  Modules/User/app/Filament/Forms/Components/UserSection.php
1  Modules/Notify/app/Filament/Forms/Components/ContactSection.php
2  Modules/Xot/tests/Fixtures/Stubs/                (XotAbsSection3, XotAbsGroup3)
```

I 16 componenti di UI estendono tutti classi di *campo* — `XotBaseField`,
`XotBaseSelect`, `XotBaseRadio`, `XotBaseTextInput`, `XotBaseDatePicker`,
`XotBaseViewField`. Non è di per sé un errore: `UserSection` e `ContactSection`
nominano concetti che appartengono ai loro moduli. È però il segno che il livello
"sezione" — quello dove la duplicazione fra form si paga davvero — vive oggi nelle
foglie, e che UI copre solo il livello sotto.

### 2. La parità Forms ↔ Columns è parziale, e questo è documentato

Misurato oggi confrontando i nomi normalizzati (tolti i suffissi `Field`, `Picker`,
`Select`, `Column`):

| | Stem |
|---|---|
| In entrambi (5) | `Address`, `Icon`, `OpeningHours`, `SelectState`, `Tree` |
| Solo form (10) | `Children`, `Enum`, `InlineDate`, `Parent`, `PasswordStrength`, `RadioBadge`, `RadioCollection`, `RadioIcon`, `RadioImage`, `Year` |
| Solo colonna (6) | `DummyActions`, `Group`, `IconState`, `IconStateGroup`, `IconStateSplit`, `ID` |

Il divario **non è debito**: [`form-column-parity.md`](form-column-parity.md) applica il
discriminante della SSoT in Ptv — gemello dovuto solo se il componente raccoglie un
fatto di dominio, non se è un modo di inserire un valore — e conclude che dei 13
allora senza gemello solo 2 erano legittimi (`AddressField`, `OpeningHoursField`), ed
entrambi sono stati creati. La verifica automatica va scritta perché il numero resti
spiegato quando cambierà, non perché il numero oggi sia sbagliato.

### 3. Tre cartelle per la stessa cosa

Un componente Filament in UI può stare in tre posti diversi, e ci sta:

| Percorso | File | Note |
|---|---:|---|
| `app/Filament/Forms/Components/` | 16 | la collocazione canonica |
| `app/Forms/Components/RadioCardSelector.php` | 1 | fuori da `Filament/` |
| `app/Filament/Components/SpatieDocumentUpload.php` | 1 | terzo livello, senza `Forms/` |

Stessa storia per i DTO: `app/Data/UserData.php` e `app/Datas/UserData.php`
coesistono, sono **diversi**, e il namespace `Modules\UI\Datas\` è referenziato in 5
punti contro 1 di `Modules\UI\Data\`. Una libreria di componenti che non sa dove
mettere i propri componenti insegna la stessa incertezza a chi la importa.

### 4. Il solo Blade component esportato non esiste

243 file Blade in `resources/views/components/`. Fuori da UI ne viene invocato **uno**,
in 6 file:

```
Modules/Rating/resources/views/rate_it.blade.php:2
Modules/Rating/resources/views/rate/multi.blade.php:3
Modules/Xot/resources/views/livewire/rate_it.blade.php:7
Modules/Xot/resources/views/livewire/rate/multi.blade.php:7
Modules/Xot/app/Resources/views/livewire/rate_it.blade.php:7
Modules/Xot/app/Resources/views/livewire/rate/multi.blade.php:7
    @component('ui::components.modal.simple', …)
```

`Modules/UI/resources/views/components/modal/` **non esiste**: c'è
`components/ui/modal.blade.php`, che è un altro percorso. Le sei chiamate risolvono su
una view assente. La sintassi `@component(...)` è per giunta la forma legacy: i 3 usi
interni di `<x-ui::nav-item>` mostrano che il namespace anonimo funziona.

Il numero da tenere a mente non è 243: è **1 componente Blade esportato, e rotto**.

### 5. Una colonna estende Filament direttamente

`app/Filament/Tables/Columns/OpeningHoursColumn.php:27` fa
`class OpeningHoursColumn extends TextColumn` importando
`Filament\Tables\Columns\TextColumn`. Le altre dieci colonne passano da `XotBase*`. La
scelta è argomentata nel PHPDoc della classe (28 `TimePicker` in una riga non sono
leggibili) ma la conseguenza resta: quella colonna non eredita i comportamenti che
`XotBaseTextColumn` garantisce a tutte le altre, e nessuno se ne accorgerà finché non
cambierà la base.

## Come servire meglio lo scopo

### 1. Riparare `ui::components.modal.simple` (6 file, 15 minuti)

O si crea `resources/views/components/modal/simple.blade.php`, o si riscrivono le sei
chiamate su `ui::components.ui.modal`. È l'unico contratto Blade che UI espone verso
l'esterno ed è l'unico rotto.

```bash
cd laravel
grep -rn "ui::components.modal.simple" Modules | wc -l   # 6 oggi, obiettivo 0 rotti
ls Modules/UI/resources/views/components/modal/simple.blade.php
```

### 2. Una sola cartella per i componenti, una sola per i DTO

Spostare `app/Forms/Components/RadioCardSelector.php` e
`app/Filament/Components/SpatieDocumentUpload.php` sotto
`app/Filament/Forms/Components/`; scegliere fra `app/Data/` e `app/Datas/` (il codice
ha già votato: 5 riferimenti contro 1) e rimuovere l'altra.

```bash
cd laravel
ls Modules/UI/app/Forms Modules/UI/app/Filament/Components 2>/dev/null   # obiettivo: assenti
ls -d Modules/UI/app/Data Modules/UI/app/Datas 2>/dev/null | wc -l       # obiettivo: 1
```

### 3. Cancellare `app/Services/UIService.php`

15 righe, un solo metodo (`public static function asset()`), **zero consumatori** in
tutto il monorepo. Viola la policy no-services
(`bashscripts/ai/wiki/rules/no-services-rule.md`) e non c'è nulla da convertire in
Action: non lo chiama nessuno. Si cancella.

```bash
cd laravel
grep -rl 'UIService\b' Modules Themes --include='*.php' | grep -v UIServiceProvider   # atteso: vuoto
```

### 4. Promuovere in UI la prima sezione davvero condivisa

`UserSection` (User) e `ContactSection` (Notify) sono singole: restano dove sono. Ma
appena una sezione compare in due moduli diversi, il posto è UI — e il modo per
accorgersene non è la memoria di chi rivede il codice, è un comando:

```bash
cd laravel
grep -rl 'extends XotBaseSection\|extends XotBaseGroup' Modules --include='*.php' \
  | sed 's|\(Modules/[^/]*\)/.*|\1|' | sort | uniq -c | sort -rn
```

Se lo stesso *heading* compare sotto due moduli, la sezione va estratta qui.

### 5. Ricondurre `OpeningHoursColumn` a `XotBase*`

La motivazione nel PHPDoc è buona; la deroga non lo è. La forma corretta della stessa
scelta è estendere `XotBaseTextColumn` — la variabilità resta nello stato della cella,
come vuole la regola, senza rompere la catena `XotBase`.

```bash
cd laravel
grep -rn 'extends TextColumn' Modules/UI/app --include='*.php'   # obiettivo: 0
```

## Cosa NON è compito di UI

- **Non** conosce il dominio: nessun modulo applicativo (Ptv, Performance,
  Progressioni, Incentivi, Indennità…) compare fra le dipendenze uscenti, e deve
  restare così. L'unico import verso una foglia oggi è
  `app/Actions/GetUserDataAction.php:10` (`Modules\User\Models\User`), ed è da
  tipizzare su contratto.
- **Non** è il tema. I tre temi non importano nulla da UI (0 file su 3): il markup di
  pagina vive in `Themes/<Tema>/resources/views/`, i componenti riusabili qui.
- **Non** è il posto delle mappe, dei media, del geocoding: componenti di dominio
  visivo appartengono ai loro moduli (`docs/dependency-rules.md`).
- **Non** decide la parità Forms ↔ Columns: la SSoT è
  [`Modules/Ptv/docs/form-column-parity.md`](../../Ptv/docs/form-column-parity.md), qui
  se ne registra solo l'applicazione.

## Verifica

```bash
cd laravel

# consumatori: UI resta infrastruttura condivisa (9 unità oggi)
for m in $(ls Modules); do
  [ "$m" = UI ] && continue
  n=$(grep -rl 'Modules\\UI\\' "Modules/$m" --include='*.php' --include='*.blade.php' 2>/dev/null | wc -l)
  [ "$n" -gt 0 ] && echo "$n $m"
done | sort -rn

# confine: UI non deve dipendere da moduli di dominio
for m in $(ls Modules); do
  [ "$m" = UI ] && continue
  n=$(grep -rl "Modules\\\\$m\\\\" Modules/UI/app --include='*.php' 2>/dev/null | wc -l)
  [ "$n" -gt 0 ] && echo "$n $m"
done | sort -rn                                   # atteso: solo Xot

# parità Forms <-> Columns
ls Modules/UI/app/Filament/Forms/Components/*.php | wc -l      # 15 (+1 in Field/)
ls Modules/UI/app/Filament/Tables/Columns/*.php   | wc -l      # 11

# igiene collocazioni
ls Modules/UI/app/Services 2>/dev/null | wc -l                 # obiettivo: 0
ls -d Modules/UI/app/Data Modules/UI/app/Datas 2>/dev/null | wc -l   # obiettivo: 1
grep -rn 'extends TextColumn' Modules/UI/app --include='*.php'       # obiettivo: 0

# il contratto Blade esportato
grep -rn "ui::components.modal.simple" Modules --include='*.blade.php'
ls Modules/UI/resources/views/components/modal/ 2>/dev/null    # oggi: non esiste

./vendor/bin/phpstan analyse Modules/UI
```

## Collegamenti

- [form-column-parity.md](form-column-parity.md) — la parità, misurata e argomentata
- [dependency-rules.md](dependency-rules.md) — la freccia `Xot ← UI ← moduli`
- [filament-form-components-vocabulary](../../../../docs/wiki/rules/filament-form-components-vocabulary.md) — quando un blocco di campi diventa componente
- [Modules/Ptv/docs/form-column-parity.md](../../Ptv/docs/form-column-parity.md) — SSoT della regola di parità
