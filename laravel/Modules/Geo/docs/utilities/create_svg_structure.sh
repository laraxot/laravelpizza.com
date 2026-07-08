#!/bin/bash

# Script per creare la struttura SVG in tutti i moduli
# Rifattorizzazione DRY + KISS per SVG

echo "=== CREAZIONE STRUTTURA SVG NEI MODULI ==="

# Lista dei moduli
MODULES=(
    "Xot"
    "User"
    "UI"
    "Tenant"
    "Seo"
    "Rating"
    "Notify"
    "Job"
    "Geo"
    "Gdpr"
    "Fixcity"
    "Comment"
    "Chart"
    "Blog"
    "AI"
    "Activity"
    "Lang"
    "FormBuilder"
    "Cms"
    "DbForge"
    "Media"
)

# Contatore
CREATED_COUNT=0
EXISTING_COUNT=0

echo "1. Creazione cartelle resources/svg..."

for module in "${MODULES[@]}"; do
    SVG_DIR="laravel/Modules/$module/resources/svg"
    
    if [ ! -d "$SVG_DIR" ]; then
        mkdir -p "$SVG_DIR"
        echo "✅ Creata cartella: $SVG_DIR"
        ((CREATED_COUNT++))
    else
        echo "ℹ️  Cartella esistente: $SVG_DIR"
        ((EXISTING_COUNT++))
    fi
done

echo ""
echo "2. Creazione file icon.svg..."

for module in "${MODULES[@]}"; do
    ICON_FILE="laravel/Modules/$module/resources/svg/icon.svg"
    
    if [ ! -f "$ICON_FILE" ]; then
        cat > "$ICON_FILE" << 'EOF'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
  <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
</svg>
EOF
        echo "✅ Creato file: $ICON_FILE"
        ((CREATED_COUNT++))
    else
        echo "ℹ️  File esistente: $ICON_FILE"
        ((EXISTING_COUNT++))
    fi
done

echo ""
echo "3. Creazione SVG aggiuntivi comuni..."

for module in "${MODULES[@]}"; do
    SVG_DIR="laravel/Modules/$module/resources/svg"
    
    # Logo SVG
    LOGO_FILE="$SVG_DIR/logo.svg"
    if [ ! -f "$LOGO_FILE" ]; then
        cat > "$LOGO_FILE" << 'EOF'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
</svg>
EOF
        echo "✅ Creato logo.svg per: $module"
        ((CREATED_COUNT++))
    fi
    
    # Favicon SVG
    FAVICON_FILE="$SVG_DIR/favicon.svg"
    if [ ! -f "$FAVICON_FILE" ]; then
        cat > "$FAVICON_FILE" << 'EOF'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor">
  <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2" fill="none"/>
  <path d="M12 16l3 3 5-5"/>
</svg>
EOF
        echo "✅ Creato favicon.svg per: $module"
        ((CREATED_COUNT++))
    fi
    
    # Loading SVG
    LOADING_FILE="$SVG_DIR/loading.svg"
    if [ ! -f "$LOADING_FILE" ]; then
        cat > "$LOADING_FILE" << 'EOF'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
  <circle cx="12" cy="12" r="10" stroke-dasharray="31.416" stroke-dashoffset="31.416">
    <animate attributeName="stroke-dasharray" dur="2s" values="0 31.416;15.708 15.708;0 31.416" repeatCount="indefinite"/>
    <animate attributeName="stroke-dashoffset" dur="2s" values="0;-15.708;-31.416" repeatCount="indefinite"/>
  </circle>
</svg>
EOF
        echo "✅ Creato loading.svg per: $module"
        ((CREATED_COUNT++))
    fi
done

echo ""
echo "4. Creazione SVG specifici per moduli..."

# SVG specifici per moduli particolari
SPECIFIC_SVGS=(
    "User:user-icon.svg:user"
    "UI:ui-icon.svg:palette"
    "Tenant:tenant-icon.svg:building"
    "Media:media-icon.svg:image"
    "Blog:blog-icon.svg:document-text"
    "Cms:cms-icon.svg:document"
    "Chart:chart-icon.svg:chart-bar"
    "Notify:notify-icon.svg:bell"
    "Geo:geo-icon.svg:map"
    "Gdpr:gdpr-icon.svg:shield-check"
    "Seo:seo-icon.svg:search"
    "Rating:rating-icon.svg:star"
    "Comment:comment-icon.svg:chat"
    "Job:job-icon.svg:briefcase"
    "AI:ai-icon.svg:cpu-chip"
    "Activity:activity-icon.svg:clock"
    "Lang:lang-icon.svg:language"
    "FormBuilder:form-icon.svg:clipboard-document-list"
    "DbForge:db-icon.svg:database"
    "Fixcity:fixcity-icon.svg:building-office"
)

for svg_info in "${SPECIFIC_SVGS[@]}"; do
    IFS=':' read -r module filename icon_name <<< "$svg_info"
    SVG_FILE="laravel/Modules/$module/resources/svg/$filename"
    
    if [ ! -f "$SVG_FILE" ]; then
        cat > "$SVG_FILE" << EOF
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
  <!-- $icon_name icon for $module module -->
  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
</svg>
EOF
        echo "✅ Creato $filename per: $module"
        ((CREATED_COUNT++))
    else
        echo "ℹ️  File esistente: $SVG_FILE"
        ((EXISTING_COUNT++))
    fi
done

echo ""
echo "=== RIEPILOGO CREAZIONE SVG ==="
echo "📁 Cartelle create: $CREATED_COUNT"
echo "📁 Cartelle esistenti: $EXISTING_COUNT"
echo "📄 File SVG creati: $CREATED_COUNT"
echo "📄 File SVG esistenti: $EXISTING_COUNT"
echo ""
echo "✅ Struttura SVG completata per tutti i moduli!"
echo ""
echo "📋 File creati per ogni modulo:"
echo "   - icon.svg (icona principale del modulo)"
echo "   - logo.svg (logo del modulo)"
echo "   - favicon.svg (favicon del modulo)"
echo "   - loading.svg (icona di caricamento)"
echo "   - [modulo]-icon.svg (icona specifica del modulo)"
echo ""
echo "🎯 Obiettivo raggiunto: DRY + KISS per SVG" 