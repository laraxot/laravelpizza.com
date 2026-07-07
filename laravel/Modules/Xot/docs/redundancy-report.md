# Redundancy Report — Modulo Xot

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 ColumnBuilder — 2 copie nello stesso modulo

| File | Namespace | Note |
|------|-----------|------|
| `app/Filament/Support/ColumnBuilder.php` | `Modules\Xot\Filament\Support` | Vecchia, usa `BooleanColumn`, `ImageColumn` |
| `app/Filament/Builders/ColumnBuilder.php` | `Modules\Xot\Filament\Builders` | Nuova, usa `IconColumn` |

**Azione suggerita**: Unificare in una sola versione. Scegliere il namespace canonico (`Builders/` è il pattern Filament v5 standard) e eliminare l'altro.

### 2. 🔴 AutoLabelAction — Duplicato con modulo Lang

| File | Namespace | Note |
|------|-----------|------|
| `app/Actions/Filament/AutoLabelAction.php` | `Modules\Xot\Actions\Filament` | Versione base con `QueueableAction` |
| `Modules/Lang/app/Actions/Filament/AutoLabelAction.php` | `Modules\Lang\Actions\Filament` | Versione completa con SVG, trans, HtmlString |

La versione Lang è più completa e gestisce traduzioni, che è la responsabilità naturale del modulo Lang. Xot non dovrebbe avere la propria copia.

**Azione suggerita**: Eliminare `Xot/Actions/Filament/AutoLabelAction.php`. Usare sempre `Modules\Lang\Actions\Filament\AutoLabelAction`.

### 3. 🟠 ArticleData — Copia non necessaria

**File**: `app/Datas/ArticleData.php`

Questo DTO esiste come copia minimale in Xot, ma la versione canonica è in `Modules/Blog/app/Datas/ArticleData.php` (completa, con Carbon, Collection, GetBloodline).

Inoltre Blog ha anche una seconda copia in `Modules/Blog/app/DataObjects/ArticleData.php` con logica diversa (ArticleStatus enum).

**Azione suggerita**: Eliminare la copia in Xot. Il modulo Blog è l'owner naturale del modello Article.

### 4. 🟠 BaseRating — Copia non necessaria

**File**: `app/Models/BaseRating.php`

Duplicato di `Modules/Rating/app/Models/BaseRating.php`. Rating è il modulo canonico.

**Azione suggerita**: Eliminare la copia in Xot. Aggiornare eventuali import a `Modules\Rating\Models\BaseRating`.

### 5. 🟠 XotBaseRelationManager — 2 path diversi

| File | Namespace |
|------|-----------|
| `app/Filament/Resources/RelationManagers/XotBaseRelationManager.php` | `Modules\Xot\Filament\Resources\RelationManagers` |
| `app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php` | `Modules\Xot\Filament\Resources\XotBaseResource\RelationManager` |

Due versioni dello stesso concetto con namespace diversi. Causa confusione su quale usare.

**Azione suggerita**: Stabilire quale è la versione canonica e deprecare/eliminare l'altra.

### 6. 🟠 XotBasePage — 2 path diversi

| File | Namespace |
|------|-----------|
| `app/Filament/Pages/XotBasePage.php` | `Modules\Xot\Filament\Pages` |
| `app/Filament/Resources/Pages/XotBasePage.php` | `Modules\Xot\Filament\Resources\Pages` |

Servono scopi diversi (Page standalone vs Resource Page), ma il naming identico crea confusione.

### 7. 🟠 XotBaseManageRelatedRecords — 2 path diversi

| File | Namespace |
|------|-----------|
| `app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php` | `Modules\Xot\Filament\Resources\Pages` |
| `app/Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php` | `Modules\Xot\Filament\Resources\XotBaseResource\Pages` |

Stesso pattern del punto 5 — due versioni con namespace diversi.

### 8. 🟡 EventServiceProvider — Non usa XotBaseEventServiceProvider

**File**: `app/Providers/EventServiceProvider.php`

Xot stesso estende `BaseEventServiceProvider` (Laravel) invece di `XotBaseEventServiceProvider`. Dato che Xot definisce la base class, è accettabile, ma dovrebbe usarla per coerenza.

### 9. 🟡 HasXotTable trait — Molteplici contesti con errori PHPStan

Il trait `HasXotTable` genera errori PHPStan ripetuti quando usato in contesti diversi (XotBaseListRecords, XotBaseManageRelatedRecords, XotBaseRelationManager, ecc.). Ogni contesto produce gli stessi errori, moltiplicando il conteggio.

**Nota**: 82 errori PHPStan nel modulo Xot, molti dei quali derivano dalla duplicazione dei contesti di `HasXotTable`.

## Struttura Interna — Pattern da Rivedere

Xot ha due sotto-strutture per i componenti Filament base:

```
app/Filament/Resources/
├── Pages/
│   ├── XotBasePage.php
│   ├── XotBaseListRecords.php
│   └── XotBaseManageRelatedRecords.php
├── RelationManagers/
│   └── XotBaseRelationManager.php
└── XotBaseResource/
    ├── Pages/
    │   ├── XotBaseManageRelatedRecords.php  ← DUPLICATO
    │   └── ...
    └── RelationManager/
        └── XotBaseRelationManager.php       ← DUPLICATO
```

**Azione suggerita**: Scegliere una sola struttura. Il pattern `XotBaseResource/` sembra una evoluzione che dovrebbe sostituire la struttura flat.

## Riepilogo

| Priorità | Problema | File interessati |
|----------|----------|-----------------|
| 🔴 | ColumnBuilder 2 copie | 2 file |
| 🔴 | AutoLabelAction duplicato con Lang | 1 file da eliminare |
| 🟠 | ArticleData copia non necessaria | 1 file da eliminare |
| 🟠 | BaseRating copia non necessaria | 1 file da eliminare |
| 🟠 | XotBaseRelationManager 2 path | 2 file da unificare |
| 🟠 | XotBasePage 2 path (accettabile) | 2 file (scopi diversi) |
| 🟠 | XotBaseManageRelatedRecords 2 path | 2 file da unificare |
| 🟡 | EventServiceProvider non usa XotBase | Accettabile |
| 🟡 | HasXotTable errori PHPStan multipli | 1 trait, ~30 errori ripetuti |
