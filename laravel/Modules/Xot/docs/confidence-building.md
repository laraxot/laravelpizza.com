# Come Aumentare il Livello di Confidenza — Second Brain Framework

**Autore:** Claude Code  
**Data:** 2026-05-26

## Principio Fondamentale

> **"La confidenza cresce documentando non quello che sai, ma quello che scopri."**

La confidenza non è certezza—è **pattern recognition + coraggio di agire**. Questo documento forma il tuo "secondo cervello" tecnico.

---

## 1️⃣ Pattern Recognition: Leggere il Codebase

### Fase 1: Esplorare per Similitudini
```bash
# Cerca pattern ripetuti
grep -r "public function get" laravel/Modules --include="*.php" | wc -l

# Identifica violazioni DRY
find . -name "*.php" -exec grep -l "TODO\|FIXME\|XXX" {} \;
```

**Confidenza aumenta quando:** Vedi 50 file simili e riconosci il pattern comune.

### Fase 2: Documentare le Scoperte
Per ogni pattern scoperto, crea un file `.md`:
```
docs/patterns/
├── column-definition-pattern.md
├── service-command-pattern.md
└── filament-resource-trait-pattern.md
```

**Confidenza aumenta quando:** Riesci a spiegare il pattern a voce alta.

---

## 2️⃣ Coraggio: Proporre Miglioramenti

### Anatomia di una Proposta Sicura

```markdown
## Miglioramento Proposto: Trait HasSearchableColumns

### Problema
- Ripetizione: `->sortable()->searchable()` in 300+ file
- Rischio: Bug nella colonna → rischia di rompersi in 300 posti

### Soluzione
```php
trait HasSearchableColumns {
    protected function searchable(string $name): TextColumn {
        return TextColumn::make($name)->sortable()->searchable();
    }
}
```

### Impatto
- ✅ 300 righe eliminate
- ✅ 1 punto di manutenzione
- ⚠️ Require trait import in 50 file
```

**Confidenza aumenta quando:** Ricevi feedback positivo. Impara da quello negativo.

---

## 3️⃣ Iterazione: Loop Feedback → Documentazione

```
Scoperta    →  Documentazione  →  Proposta  →  Feedback  →  Iterazione
  ↑                                                          ↓
  └──────────────── Ripeti (sempre più sicuro) ────────────┘
```

**Dopo 5 iterazioni:** Sei esperto del pattern.  
**Dopo 20 iterazioni:** Sei owner intellettuale del sistema.

---

## 4️⃣ Framework di Confidenza: La Piramide

```
          ★ Esperto (70+ iterazioni)
       ★ ★ ★ Padrone (40+ iterazioni)
     ★ ★ ★ ★ ★ Proficiente (20+ iterazioni)
   ★ ★ ★ ★ ★ ★ ★ Competente (10+ iterazioni)
 ★ ★ ★ ★ ★ ★ ★ ★ ★ Novizio (5+ iterazioni)
★ ★ ★ ★ ★ ★ ★ ★ ★ ★ Curioso (primo incontro)
```

**Livello Attuale:** Analizza quante iterazioni hai fatto su pattern chiave.

---

## 5️⃣ Checklist Quotidiana: Aumentare Confidenza

Ogni giorno, aggiungi un +1 in questi ambiti:

- [ ] **Lettura:** Leggi 1 file sconosciuto, scrivi 3 righe di note
- [ ] **Modifica:** Cambia 1 file, spiega il perché in un commento
- [ ] **Test:** Rompi qualcosa volontariamente, riparalo, documenta
- [ ] **Insegnamento:** Spiega 1 pattern a un collega o in doc
- [ ] **Ricerca:** Usa grep/find per scoprire un pattern nuovo

**Dopo 30 giorni:** +150 punti confidenza.

---

## 6️⃣ Zen della Confidenza

> **"Non cercare certezza—cerca coherenza."**

Un'architettura coerente è più importante di una perfetta. Quando tutto segue lo stesso pattern:
- ✅ Le eccezioni diventano ovvie
- ✅ I bug si vedono subito
- ✅ La confidenza cresce naturalmente

> **"Il vero nemico è la sorpresa."**

Documentare un pattern non è solo educazione—è **safety net**. Quando vedi un file che non segue il pattern, immediatamente:
1. Noti l'anomalia
2. Indaghi il perché
3. Risolvi o documenti

---

## 7️⃣ Metriche di Confidenza

Misura la tua crescita:

| Metrica | Basso | Medio | Alto |
|---------|--------|--------|------|
| **Patterns Identificati** | <5 | 5-20 | >20 |
| **Documentazione Prodotta** | <10 file | 10-50 file | >50 file |
| **Iterazioni Completate** | <5 | 5-20 | >20 |
| **Feedback Ricevuti** | <3 | 3-10 | >10 |
| **Miglioramenti Proposti** | <1 | 1-5 | >5 |
| **Tempo per Soluzione** | >2h | 1-2h | <1h |

---

## 🎯 Prossimi Passi

1. **Oggi:** Identifica 3 pattern nel tuo codebase
2. **Domani:** Documenta ognuno in 1 pagina
3. **Questa Settimana:** Proponi 1 miglioramento
4. **Questo Mese:** Implementa l'iterazione feedback

---

**Ricorda:** Confidenza non è arroganza—è competenza + umiltà di imparare sempre.
