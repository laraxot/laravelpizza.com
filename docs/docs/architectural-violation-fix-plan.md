# 🚨 PIANO DI CORREZIONE: Violazione Architetturale Critica

## VIOLAZIONE IDENTIFICATA

**File**: `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
**Problema**: Modulo BASE (User) dipende da modulo SPECIFICO (<nome progetto>)
**Linea**: `use Modules\<nome progetto>\Models\Patient;`

## 🏗️ PRINCIPIO VIOLATO

**Il modulo User è un modulo BASE che NON può dipendere da <nome progetto>!**
**Problema**: Modulo BASE (User) dipende da modulo SPECIFICO (<nome progetto>)
**Linea**: `use Modules\<nome progetto>\Models\Patient;`

## 🏗️ PRINCIPIO VIOLATO

**Il modulo User è un modulo BASE che NON può dipendere da <nome progetto>!**

## 📋 PIANO DI CORREZIONE

### 1. SPOSTARE IL WIDGET
- **Da**: `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- **A**: `Modules/<nome progetto>/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`

### 2. AGGIORNARE NAMESPACE
- **Da**: `namespace Modules\User\Filament\Widgets;`
- **A**: `namespace Modules\<nome progetto>\Filament\Widgets;`
- **A**: `Modules/<nome progetto>/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`

### 2. AGGIORNARE NAMESPACE
- **Da**: `namespace Modules\User\Filament\Widgets;`
- **A**: `namespace Modules\<nome progetto>\Filament\Widgets;`

### 3. VERIFICARE UTILIZZI
- Cercare tutti i riferimenti al widget
- Aggiornare import e registrazioni
- Aggiornare documentazione

### 4. RIMUOVERE FILE ORIGINALE
- Eliminare il file dal modulo User
- Verificare che non ci siano altri riferimenti

## 🎯 MOTIVAZIONE ARCHITETTUALE

### Perché Spostare?
1. **Widget specifico per <nome progetto>**: Usa modelli specifici del dominio medico
2. **Logica business specifica**: Non è un widget generico di User
3. **Dipendenze corrette**: <nome progetto> può dipendere da User, non viceversa
1. **Widget specifico per <nome progetto>**: Usa modelli specifici del dominio medico
2. **Logica business specifica**: Non è un widget generico di User
3. **Dipendenze corrette**: <nome progetto> può dipendere da User, non viceversa
4. **Riusabilità**: Il modulo User rimane riutilizzabile in altri progetti

### Benefici della Correzione
- ✅ Architettura modulare pulita
- ✅ Modulo User riutilizzabile
- ✅ Separazione delle responsabilità
- ✅ Prevenzione dipendenze circolari

## 🔍 VERIFICA POST-CORREZIONE

### Comandi di Controllo
```bash
# Deve restituire NIENTE dopo la correzione
grep -r "<nome progetto>" Modules/User/ --include="*.php"
grep -r "Patient" Modules/User/ --include="*.php"

# Verifica che il widget sia nel posto giusto
ls -la Modules/<nome progetto>/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php
```

### Checklist di Verifica
- [ ] Widget spostato nel modulo <nome progetto>
- [ ] Namespace aggiornato correttamente
- [ ] File originale rimosso dal modulo User
- [ ] Nessuna dipendenza da <nome progetto> nel modulo User
grep -r "<nome progetto>" Modules/User/ --include="*.php"
grep -r "Patient" Modules/User/ --include="*.php"

# Verifica che il widget sia nel posto giusto
ls -la Modules/<nome progetto>/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php
```

### Checklist di Verifica
- [ ] Widget spostato nel modulo <nome progetto>
- [ ] Namespace aggiornato correttamente
- [ ] File originale rimosso dal modulo User
- [ ] Nessuna dipendenza da <nome progetto> nel modulo User
- [ ] Widget funziona correttamente nella nuova posizione
- [ ] Documentazione aggiornata

## 📚 LEZIONI APPRESE

### Come Prevenire Violazioni Future
1. **Controllo automatico**: Script per verificare dipendenze
2. **Review architetturale**: Controllare direzione dipendenze nei PR
3. **Documentazione chiara**: Principi architetturali ben documentati
4. **Training team**: Formare il team sui principi modulari

### Red Flags da Monitorare
- Import di moduli specifici nei moduli base
- Widget/componenti nel modulo sbagliato
- Logica business nei moduli infrastrutturali
- Riferimenti cross-module non giustificati

---

**Questa correzione è CRITICA per mantenere l'integrità architetturale del sistema.**

*Status: DA IMPLEMENTARE IMMEDIATAMENTE*
*Priorità: MASSIMA*
*Impatto: ARCHITETTURALE*
