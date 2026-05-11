# Theme Composer Lessons Learned

## Data: 2026-04-23

Lezioni apprese dal fix dei View Composer del modulo CMS.

---

## 1. Blocks Component Constructor — Syntax Error Critico

### Problema

In `ThemeComposer.php`, le chiamate a `showPageContent`, `showPageSidebarContent` e `showContent` usavano una sintassi errata per istanziare il componente `Blocks`:

```php
// SBAGLIATO — syntax error
$blocksComponent = new Blocks()
    view: 'ui::components.render.blocks.v1',
    blocks: $blocks,
    model: $page,
);
```

```php
// CORRETTO
$blocksComponent = new Blocks(
    view: 'ui::components.render.blocks.v1',
    blocks: $blocks,
    model: $page,
);
```

### Perché accadrà di nuovo

La sintassi sbagliata sembra un pattern Filament-style chaining, dove i metodi fluent sono chiamati sul costruttore. Ma qui non è chaining — è un errore di parsing PHP.

### Impatto

12 errori PHPStan parse su un singolo file. Tutte le pagine CMS-driven avrebbero errore 500.

---

## 2. View Composer = Single Point of Failure

### Problema

`ThemeComposer` è iniettato in OGNI view del tema. Un singolo errore di parse in questo composer blocca TUTTE le pagine, non solo quelle CMS-driven.

### Lezione

I View Composer sono il layer più critico per affidabilità nel CMS — un errore qui è un outage totale.

### Regola

Ogni modifica a ThemeComposer richiede:
1. PHP lint del file immediatamente dopo la modifica
2. PHPStan sul singolo file prima del commit
3. Test visuale su una pagina CMS-driven

---

## 3. `Page::firstOrCreate` nei Composer

### Pattern ossservato

```php
$page = Page::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]);
```

Questo pattern crea una pagina vuota se non esiste. È intenzionale per il CMS — le pagine vengono create al primo accesso.

### Anti-pattern

Non controllare se `content_blocks` è array prima di passarlo a `Blocks`:

```php
// PROTEGGIAMO il passaggio
if (! is_array($blocks)) {
    $blocks = [];
}
```

Questo guard esiste già nel codice — è la protezione corretta contro la corruzione dei dati.

---

## False Friends

| False Friend | Realtà |
|---|---|
| `new Class()` con named args su newline | Syntax error immediato — `()` chiude il costruttore |
| View Composer rotto = pagina singola | View Composer rotto = TUTTO il tema down |
| `firstOrCreate` senza guard | Può restituire un modello con campi null/non-array |
