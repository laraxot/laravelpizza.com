# Approfondimento tecnico: Logo Footer e Coerenza Brand

Questo documento approfondisce le discrepanze tecniche del logo nel footer e fornisce la mappatura esatta dei file per l'allineamento.

## 1. Analisi Comparativa Logo Footer

### 1.1 Produzione (laravelpizza.com)
- **Icona**: Pizza slice rossa (piena).
- **Testo**: "Laravel Pizza Meetups" (singola riga).
- **Sezione**: Include un blocco "Made with <3 for the Laravel community".
- **Screenshot**: `docs/visual-analysis/footer/footer-laravelpizza-com.png`

### 1.2 Locale (Meetup Theme)
- **Icona**: SVG geometrico con cerchi e rombi (stile "layers").
- **Testo**: "Laravel Pizza Meetups" (singola riga).
- **Sezione**: Copyright standard.
- **Screenshot**: `docs/visual-analysis/footer/footer-locale-it.png`

## 2. Mappatura Codice e File

| Componente | File Sorgente (Locale) | Nodo di Codice |
| :--- | :--- | :--- |
| **Footer Implementation** | `resources/views/components/sections/footer.blade.php` | Righe 7-15 |
| **Logo Shared Component** | `resources/views/components/ui/logo.blade.php` | Intero file |
| **Header Integration** | `resources/views/components/sections/header.blade.php` | Righe 27-44 |

### 2.1 Incoerenza SVG (Footer)
Il file `sections/footer.blade.php` usa un SVG hardcoded (viewBox 0 0 24 24) che non corrisponde al logo ufficiale definito in `ui/logo.blade.php`.

```blade
<!-- ❌ Attuale in sections/footer.blade.php (riga 7) -->
<svg class="w-8 h-8 text-red-500" viewBox="0 0 24 24" ...>
    <path d="M12 2L2 7l10 5 ..."/>
</svg>
```

## 3. Roadmap di Allineamento (Technical Steps)

### Step 1: Unificazione Componente Logo
Sostituire l'SVG hardcoded nel footer con il componente `x-ui.logo`.
```diff
- <svg class="w-8 h-8 text-red-500" viewBox="0 0 24 24" ...>...</svg>
+ <x-ui.logo class="h-8 w-auto text-red-600" />
```

### Step 2: Parity Testuale Header
Allineare l'header alla singola riga di produzione.
- **File**: `sections/header.blade.php`
- **Modifica**: Rimuovere `flex-col` e unire i due span in uno solo: `<span class="...">Laravel Pizza Meetups</span>`.

### Step 3: Implementazione Parity Footer
Aggiungere la riga social/community credit.
- **File**: `sections/footer.blade.php`
- **Codice**:
```html
<div class="mt-8 pt-8 border-t border-slate-800 text-center text-gray-400 text-sm">
    <p>Made with <span class="text-red-500">❤️</span> for the Laravel community</p>
    <p class="mt-2">&copy; {{ date('Y') }} Laravel Pizza Meetups. All rights reserved.</p>
</div>
```

## 4. Checklist Tecnica Finale

- [ ] [Header] Logo SVG fill (viewBox 512x512) vs illustrato.
- [x] [Footer] Sostituzione SVG geometrico con Pizza Slice (**fatto**: `sections/footer.blade.php` usa `<x-ui.logo>`; vedi [footer-logo-confronto](footer-logo-confronto.md)).
- [ ] [Global] Allineamento URL `/chat` (Footer) vs `/community` (Header).
- [ ] [Docs] Aggiornare `Modules/Meetup/docs/logo-branding-guidelines.md`.

---
**Riferimenti**:
- [Footer logo confronto](footer-logo-confronto.md) – screenshot, differenze, roadmap
- [Grafica vs laravelpizza.com](grafica-confronto-laravelpizza.md)
- [Evidenzia differenze](evidenzia-differenze.md)
