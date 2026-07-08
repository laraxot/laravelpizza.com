# Script Validazione HTML per View PDF - Prevenzione Errori Critici

**Data**: 16 Gennaio 2025  
**Stato**: 🛡️ Script di Prevenzione Completo

## 🎯 Script di Validazione HTML

### Script Bash Completo
```bash
#!/bin/bash
# File: validate_pdf_html.sh
# Scopo: Validare HTML nelle view PDF per prevenire errori HtmlParsingException

echo "🔍 VALIDAZIONE HTML VIEW PDF - Framework Laraxot"
echo "================================================"

# Contatori errori
total_errors=0
total_files=0

# Trova tutte le view PDF
echo "📄 Ricerca view PDF..."
pdf_views=$(find laravel/Modules/*/resources/views -name "*pdf*.blade.php" 2>/dev/null)

if [ -z "$pdf_views" ]; then
    echo "❌ Nessuna view PDF trovata"
    exit 1
fi

echo "📋 View PDF trovate:"
echo "$pdf_views"
echo ""

# Validazione per ogni file
for file in $pdf_views; do
    echo "🔍 Validando: $file"
    total_files=$((total_files + 1))
    file_errors=0
    
    # 1. Controlla tag style malformati
    if grep -q "^[^<]*type=\"text/css\">" "$file"; then
        echo "❌ ERRORE: Tag <style> malformato (manca inizio tag)"
        file_errors=$((file_errors + 1))
    fi
    
    # 2. Controlla bilanciamento tag style
    open_style=$(grep -c "<style" "$file" 2>/dev/null || echo "0")
    close_style=$(grep -c "</style>" "$file" 2>/dev/null || echo "0")
    
    if [ "$open_style" -ne "$close_style" ]; then
        echo "❌ ERRORE: Tag <style> non bilanciati (aperti: $open_style, chiusi: $close_style)"
        file_errors=$((file_errors + 1))
    fi
    
    # 3. Controlla bilanciamento tag table
    open_table=$(grep -c "<table" "$file" 2>/dev/null || echo "0")
    close_table=$(grep -c "</table>" "$file" 2>/dev/null || echo "0")
    
    if [ "$open_table" -ne "$close_table" ]; then
        echo "❌ ERRORE: Tag <table> non bilanciati (aperti: $open_table, chiusi: $close_table)"
        file_errors=$((file_errors + 1))
    fi
    
    # 4. Controlla include di view inesistenti
    if grep -q "@include(\$view\." "$file"; then
        echo "⚠️  WARNING: Include dinamico trovato - verificare esistenza file"
        # Non conto come errore ma come warning
    fi
    
    # 5. Controlla struttura tabella (thead senza tbody)
    if grep -q "<thead>" "$file" && ! grep -q "<tbody>" "$file"; then
        echo "⚠️  WARNING: <thead> senza <tbody> - struttura incompleta"
    fi
    
    # 6. Controlla tag non chiusi comuni
    for tag in "div" "span" "p" "h1" "h2" "h3" "tr" "td" "th"; do
        open_count=$(grep -c "<$tag" "$file" 2>/dev/null || echo "0")
        close_count=$(grep -c "</$tag>" "$file" 2>/dev/null || echo "0")
        
        if [ "$open_count" -ne "$close_count" ] && [ "$open_count" -gt 0 ]; then
            echo "❌ ERRORE: Tag <$tag> non bilanciati (aperti: $open_count, chiusi: $close_count)"
            file_errors=$((file_errors + 1))
        fi
    done
    
    # Riepilogo file
    if [ "$file_errors" -eq 0 ]; then
        echo "✅ File validato correttamente"
    else
        echo "❌ File con $file_errors errori"
        total_errors=$((total_errors + file_errors))
    fi
    
    echo ""
done

# Riepilogo finale
echo "📊 RIEPILOGO VALIDAZIONE"
echo "======================="
echo "📄 File validati: $total_files"
echo "❌ Errori totali: $total_errors"

if [ "$total_errors" -eq 0 ]; then
    echo "🎉 Tutti i file HTML sono validi!"
    exit 0
else
    echo "🚨 Trovati $total_errors errori HTML da correggere"
    exit 1
fi
```

### Utilizzo Script
```bash
# Rendere eseguibile
chmod +x validate_pdf_html.sh

# Eseguire validazione
./validate_pdf_html.sh

# Integrare in CI/CD
# In .github/workflows/validation.yml:
# - name: Validate PDF HTML
#   run: ./validate_pdf_html.sh
```

## 🎯 Errori Comuni Rilevabili

### 1. Tag Style Malformati
- `e type="text/css">` invece di `<style type="text/css">`
- Tag `</style>` senza apertura corrispondente

### 2. Tag Table Non Bilanciati
- `<table>` senza `</table>`
- Ordine di chiusura errato
- Struttura incompleta (mancanza tbody/tfoot)

### 3. Include Problematici
- `@include($view.'.head')` con file inesistente
- Include dinamici che falliscono
- Path di include errati

### 4. Tag HTML Generici
- `<div>` non chiusi
- `<tr>` senza `</tr>`
- Annidamento errato

## 🛠️ Comandi di Verifica Rapida

### Verifica Bilanciamento Tag
```bash
# Per un singolo file
file="path/to/view.blade.php"
echo "Style: $(grep -c '<style' $file) vs $(grep -c '</style>' $file)"
echo "Table: $(grep -c '<table' $file) vs $(grep -c '</table>' $file)"
```

### Trova Include Dinamici
```bash
grep -r "@include(\$" laravel/Modules/*/resources/views/
```

### Trova Tag Malformati
```bash
grep -r "^[^<]*type=" laravel/Modules/*/resources/views/
```

## 🎉 Correzioni Applicate

### File: `admin/schede/show/pdf.blade.php`

#### Fix 1: Tag Style
- ✅ Corretto `e type="text/css">` → `<style type="text/css">`

#### Fix 2: Struttura Tabella
- ✅ Aggiunto `<tbody>` per righe dati
- ✅ Aggiunto `<tfoot>` per riga totale
- ✅ Commentati include inesistenti

#### Fix 3: Include Sicure
- ✅ `@include($view.'.head')` → `{{-- @include($view.'.head') --}}`
- ✅ `@include($view.'.food')` → `{{-- @include($view.'.food') --}}`

### Risultato
**HTML perfettamente formato** per il parser Html2Pdf, **zero errori** di parsing.

---
*Script Validazione HTML - Framework Laraxot*
