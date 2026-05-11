# Da Nested Set ad Adjacency List: Filosofia, Logica, Politica, Religione e Zen

> **Data migrazione**: 2025 → completata marzo 2026
> **Pacchetto rimosso**: `kalnoy/nestedset` (^6.0)
> **Pacchetto adottato**: `staudenmeir/laravel-adjacency-list` (^1.22)
> **Stato**: ✅ Migrazione completata — nessun codice PHP attivo usa più kalnoy

---

## 1. La Filosofia: Perché Cambiare

### Il Problema del Nested Set

Il modello **Nested Set** (`_lft`, `_rgt`, `parent_id`) è stato progettato negli anni '90 per
ottimizzare le letture su alberi gerarchici in database relazionali. In cambio di letture veloci,
impone un costo strutturale enorme:

- **Ogni inserimento/spostamento ricalcola `_lft`/`_rgt`** di potenzialmente tutti i nodi
- **Lock esclusivi sulla tabella** durante le operazioni di scrittura
- **Migrazioni complesse**: tre colonne speciali + indici dedicati
- **Integrità fragile**: un singolo `_lft`/`_rgt` corrotto invalida l'intero albero
- **Debugging opaco**: i valori `_lft`/`_rgt` non hanno significato semantico leggibile

### La Soluzione: Adjacency List con CTE Ricorsive

Il modello **Adjacency List** usa solo `parent_id` (che già esisteva!) e sfrutta le
**Common Table Expressions (CTE) ricorsive** — supportate nativamente da PostgreSQL, MySQL 8+,
SQLite 3.8.3+ e MariaDB 10.2+ — per risolvere ancestors, descendants, depth e path
**al momento della query**, senza colonne precalcolate.

```
Nested Set:  id | _lft | _rgt | parent_id  ← 4 colonne, integrità fragile
Adjacency:   id | parent_id               ← 2 colonne, integrità nativa FK
```

---

## 2. La Logica: Vantaggi Tecnici Concreti

| Aspetto | kalnoy/nestedset | staudenmeir/adjacency-list |
|---------|-----------------|---------------------------|
| **Colonne richieste** | `_lft`, `_rgt`, `parent_id` | Solo `parent_id` |
| **Scritture** | O(n) — ricalcolo globale | O(1) — modifica singolo record |
| **Letture discendenti** | O(1) range scan | O(log n) CTE ricorsiva |
| **Integrità dati** | Fragile (lft/rgt corruttibili) | Robusta (FK standard) |
| **Concorrenza** | Scarsa (lock tabella) | Eccellente (lock riga) |
| **Migrazioni** | Complesse (`NestedSet::columns()`) | Semplici (`$table->parent_id`) |
| **Debugging** | Opaco (numeri senza senso) | Trasparente (parent_id leggibile) |
| **Type safety** | Limitata | PHPStan Level 10 con trait tipizzato |
| **Laravel moderno** | Trait monolitico | Relazioni Eloquent native |

### Performance reali

Per alberi fino a ~10.000 nodi (il caso d'uso del 99% delle applicazioni web):
- Le CTE ricorsive sono **equivalenti o più veloci** del nested set
- Il nested set vince solo su alberi enormi (100k+ nodi) con letture pure
- Le scritture sono **ordini di grandezza più veloci** con adjacency list

---

## 3. La Politica: Allineamento con l'Ecosistema

### Laravel Framework

- `staudenmeir/laravel-adjacency-list` è mantenuto attivamente (2024-2026)
- Supporta Laravel 10, 11 e 12 nativamente
- Si integra con `staudenmeir/eloquent-has-many-deep` (già nel progetto)
- `kalnoy/nestedset` ha sviluppo rallentato, ultima release significativa 2022

### Laraxot Architecture

- **`laravel/framework: "*"`** in `Modules/Xot/composer.json` garantisce compatibilità forward
- `BaseTreeModel` e `XotBaseTreeModel` forniscono la base astratta tipizzata
- `TypedHasRecursiveRelationships` wrappa il vendor con type safety PHPStan Level 10
- `HasRecursiveRelationshipsContract` definisce il contratto per tutti i moduli

### Dipendenza critica

```json
// Modules/Xot/composer.json
{
  "require": {
    "laravel/framework": "*",
    "staudenmeir/laravel-adjacency-list": "^1.22",
    "staudenmeir/eloquent-has-many-deep": "*"
  }
}
```

La dipendenza `"laravel/framework": "*"` è **essenziale** perché:
1. Xot è il cuore del sistema modulare — deve accettare qualsiasi versione di Laravel
2. Evita conflitti di versione quando altri moduli specificano versioni precise
3. Permette upgrade incrementali di Laravel senza blocchi su Xot

---

## 4. La Religione: Principi Inviolabili

### Comandamento 1: Un Solo Punto di Verità
> La gerarchia vive in `parent_id`. Non servono colonne ridondanti.

### Comandamento 2: Forward-Only
> Non si torna indietro a nested set. La migrazione è irreversibile per design.

### Comandamento 3: Type Safety Assoluta
> Ogni relazione ricorsiva passa per `TypedHasRecursiveRelationships` o
> `HasRecursiveRelationships` — mai implementazioni custom sparse.

### Comandamento 4: Estendi BaseTreeModel
> Per nuovi modelli ad albero: `extends BaseTreeModel` (o `XotBaseTreeModel`).
> Mai `use NodeTrait` da kalnoy. Mai implementazioni manuali parent/child.

### Comandamento 5: Documenta la Conversione
> Ogni modulo che aveva nested set deve avere documentazione della migrazione
> nel proprio `docs/`.

---

## 5. Lo Zen: Semplicità come Virtù

```
Prima (Nested Set):
  - 1210 righe di trait HasParent.kalnoy
  - 3 colonne speciali per tabella
  - Ricalcolo globale a ogni modifica
  - Debugging con numeri incomprensibili

Dopo (Adjacency List):
  - 14 righe di BaseTreeModel.php
  - 1 colonna: parent_id
  - Modifica chirurgica del singolo record
  - parent_id leggibile da chiunque
```

**Lo zen del codice è la semplicità che non sacrifica potenza.**

L'adjacency list con CTE ricorsive è la dimostrazione che la soluzione più semplice
è spesso la più potente — quando il database engine la supporta nativamente.

---

## 6. Architettura Implementata

### Classi Base (Modules/Xot)

```
Modules/Xot/app/
├── Contracts/
│   └── HasRecursiveRelationshipsContract.php    ← Contratto tipizzato
├── Models/
│   ├── BaseTreeModel.php                        ← extends BaseModel + HasRecursiveRelationships
│   ├── XotBaseTreeModel.php                     ← extends XotBaseModel + HasRecursiveRelationships
│   └── Traits/
│       └── TypedHasRecursiveRelationships.php   ← Wrapper PHPStan Level 10
```

### Come Usare nei Moduli

```php
<?php
declare(strict_types=1);

namespace Modules\MioModulo\Models;

use Modules\Xot\Models\BaseTreeModel;

class Category extends BaseTreeModel
{
    protected $connection = 'mio_modulo';
    protected $table = 'categories';

    // Tutto il tree functionality è ereditato automaticamente:
    // ->parent, ->children, ->ancestors(), ->descendants(),
    // ->siblings(), ->rootAncestor(), ->bloodline(), etc.
}
```

### Migrazione Database

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            // Solo parent_id — niente _lft, _rgt
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->timestamps();
        });
    }
    // Niente down() — regola Laraxot
};
```

---

## 7. Cronologia della Migrazione

| Data | Azione |
|------|--------|
| Pre-2025 | Progetto usa `kalnoy/nestedset` con `NodeTrait` |
| 2025 | Creazione `BaseTreeModel`, `XotBaseTreeModel`, `TypedHasRecursiveRelationships` |
| 2025 | Aggiunta `staudenmeir/laravel-adjacency-list` a `Xot/composer.json` |
| 2025 | Migrazione progressiva dei modelli da `NodeTrait` a `BaseTreeModel` |
| 2026-03 | Rimozione `kalnoy/nestedset` da `Blog/composer.json` (ultimo riferimento) |
| 2026-03 | Pulizia file legacy `.kalnoy` da `Xot/app/Models/Traits/` |
| 2026-03 | Composer update — pacchetto rimosso da vendor e lock |
| 2026-03 | Documentazione completa in tutti i moduli |

---

## 8. Riferimenti

- [staudenmeir/laravel-adjacency-list](https://github.com/staudenmeir/laravel-adjacency-list)
- [BaseTreeModel](../app/Models/BaseTreeModel.php)
- [XotBaseTreeModel](../app/Models/XotBaseTreeModel.php)
- [TypedHasRecursiveRelationships](../app/Models/Traits/TypedHasRecursiveRelationships.php)
- [HasRecursiveRelationshipsContract](../app/Contracts/HasRecursiveRelationshipsContract.php)
- [base-tree-model.md](models/base-tree-model.md)

---

*Ultimo aggiornamento: marzo 2026*
