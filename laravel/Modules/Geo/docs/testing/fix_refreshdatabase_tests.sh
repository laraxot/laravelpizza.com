#!/bin/bash

# Script per correggere tutti i test che usano RefreshDatabase
# Converte da RefreshDatabase a DatabaseTransactions seguendo le regole Laraxot

echo "🔧 Inizio correzione test con RefreshDatabase..."

# Lista dei file da correggere
FILES=(
    "Modules/Tenant/tests/Performance/SushiToJsonPerformanceTest.php"
    "Modules/Tenant/tests/Integration/SushiToJsonIntegrationTest.php"
    "Modules/Cms/tests/Feature/PageManagementBusinessLogicTest.php"
    "Modules/Media/tests/Unit/Models/MediaTest.php"
    "Modules/Xot/tests/Feature/ModuleBusinessLogicTest.php"
    "Modules/Notify/tests/Feature/NotificationTemplateVersionBusinessLogicTest.php"
    "Modules/Notify/tests/Feature/ContactManagementBusinessLogicTest.php"
    "Modules/Notify/tests/Feature/MailTemplateVersionBusinessLogicTest.php"
    "Modules/Notify/tests/Unit/Models/ContactTest.php"
    "Modules/Notify/tests/Unit/Models/NotificationTypeTest.php"
    "Modules/Notify/tests/Unit/Models/NotifyThemeableTest.php"
    "Modules/Notify/tests/Unit/Models/NotifyThemeTest.php"
    "Modules/Notify/tests/Unit/Models/NotificationTemplateTest.php"
    "Modules/Notify/tests/Unit/Models/MailTemplateTest.php"
    "Modules/Notify/tests/Unit/Models/MailTemplateLogTest.php"
    "Modules/Notify/tests/Unit/Models/NotificationTest.php"
    "Modules/UI/tests/Feature/WidgetBusinessLogicTest.php"
    "Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php"
    "Modules/User/tests/Feature/UserManagementBusinessLogicTest.php"
    "Modules/User/tests/Unit/Models/TenantTest.php"
    "Modules/User/tests/Unit/Models/PermissionTest.php"
    "Modules/User/tests/Unit/Models/DeviceTest.php"
    "Modules/User/tests/Unit/Models/RoleTest.php"
    "Modules/User/tests/Unit/Models/TeamTest.php"
    "Modules/User/tests/Unit/Models/UserTest.php"
    "Modules/User/tests/Unit/Models/ProfileTest.php"
    "Modules/Activity/tests/Feature/SnapshotBusinessLogicTest.php"
    "Modules/Activity/tests/Feature/StoredEventBusinessLogicTest.php"
    "Modules/Activity/tests/Feature/BaseModelBusinessLogicTest.php"
    "Modules/Job/tests/Feature/ResultBusinessLogicTest.php"
    "Modules/Job/tests/Feature/TaskBusinessLogicTest.php"
    "Modules/Job/tests/Feature/JobBatchBusinessLogicTest.php"
)

# Contatori
TOTAL=${#FILES[@]}
PROCESSED=0
ERRORS=0

echo "📋 Trovati $TOTAL file da correggere"

# Funzione di backup
backup_file() {
    local file="$1"
    if [ -f "$file" ]; then
        cp "$file" "$file.backup.$(date +%Y%m%d_%H%M%S)"
        echo "  ✅ Backup creato: $file.backup.$(date +%Y%m%d_%H%M%S)"
    fi
}

# Funzione di correzione
fix_file() {
    local file="$1"
    
    if [ ! -f "$file" ]; then
        echo "  ⚠️  File non trovato: $file"
        ((ERRORS++))
        return 1
    fi
    
    echo "📄 Elaborando: $file"
    
    # Backup del file originale
    backup_file "$file"
    
    # Sostituzioni PHPUnit -> Pest
    sed -i 's/use Illuminate\\Foundation\\Testing\\RefreshDatabase;/use Illuminate\\Foundation\\Testing\\DatabaseTransactions;/g' "$file"
    sed -i 's/RefreshDatabase/DatabaseTransactions/g' "$file"
    
    # Converti assertioni PHPUnit in expect() dove possibile
    sed -i 's/$this->assertEquals(/expect(/g' "$file"
    sed -i 's/$this->assertTrue(/expect(/g' "$file"
    sed -i 's/$this->assertFalse(/expect(/g' "$file"
    sed -i 's/$this->assertNull(/expect(/g' "$file"
    sed -i 's/$this->assertNotNull(/expect(/g' "$file"
    sed -i 's/$this->assertInstanceOf(/expect(/g' "$file"
    sed -i 's/$this->assertCount(/expect(/g' "$file"
    
    echo "  ✅ Correzioni applicate"
    ((PROCESSED++))
}

# Applica correzioni a tutti i file
for file in "${FILES[@]}"; do
    fix_file "$file"
done

echo ""
echo "📊 RIEPILOGO CORREZIONI:"
echo "   📁 File totali: $TOTAL"
echo "   ✅ File elaborati: $PROCESSED"
echo "   ❌ Errori: $ERRORS"

if [ $ERRORS -eq 0 ]; then
    echo ""
    echo "🎉 Tutte le correzioni completate con successo!"
    echo ""
    echo "📋 PROSSIMI STEP:"
    echo "   1. Verificare che i test funzionino: php artisan test"
    echo "   2. Aggiornare i file Pest.php dei moduli"
    echo "   3. Creare .env.testing con SQLite in memoria"
    echo ""
else
    echo ""
    echo "⚠️  Alcuni file hanno avuto problemi. Controlla i log sopra."
fi

echo "✨ Script completato!"
