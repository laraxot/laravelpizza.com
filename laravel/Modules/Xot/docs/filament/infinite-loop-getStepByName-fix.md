<<<<<<< HEAD














































































=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 50d6b63f (.)
=======
=======
=======
=======
=======
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 50d6b63f (.)
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 3bf39332 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 6d05deed (.)
=======
>>>>>>> 39bb163e (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> e7da37af (.)
<<<<<<< HEAD
>>>>>>> 7e4835b8e (.)
=======
=======
>>>>>>> 6d05deed (.)
<<<<<<< HEAD
>>>>>>> 9f193021d (.)
=======
=======
>>>>>>> 39bb163e (.)
<<<<<<< HEAD
>>>>>>> d9f43fce9 (.)
=======
=======
>>>>>>> 5a14301c (.)
>>>>>>> 50d6b63f (.)
>>>>>>> 551c768c4 (.)
>>>>>>> 38b70c7ba (.)
# CRITICAL FIX: Loop Infinito in getStepByName() - XotBaseResource

## 🚨 **PROBLEMA CRITICO RISOLTO**

### **Sintomo**
```
Xdebug has detected a possible infinite loop, and aborted your script with a stack depth of '256' frames
```

### **Causa Root**
Errore di sintassi PHP nel metodo `getStepByName()` di `XotBaseResource`:

```php
// ❌ ERRATO - Causava loop infinito
return Forms\Components\Wizard\Step::make($name)
    ->schema(static::$schema());
```

### **Correzione Applicata**
```php
// ✅ CORRETTO - Risolve il loop infinito
return Forms\Components\Wizard\Step::make($name)
    ->schema(static::{$schema}());
```

## 🔍 **Analisi Tecnica**

### **Problema di Sintassi**
- `static::$schema()` tentava di accedere a una **proprietà statica** e chiamarla come metodo
- PHP non riusciva a risolvere questa sintassi non valida
- Questo causava **ricorsioni infinite** nel sistema di risoluzione delle classi

### **Soluzione Dinamica**
- `static::{$schema}()` utilizza **variable variables** per chiamare dinamicamente il metodo
- Per `studio_step`: $schema = `getStudioStepSchema` → chiama `static::getStudioStepSchema()`
- Per `availability_step`: $schema = `getAvailabilityStepSchema` → chiama `static::getAvailabilityStepSchema()`

## 🎯 **Meccanismo di Naming**

### **Trasformazione Step Name → Method**
```php
$schema = Str::of($name)
    ->snake()      // 'studio_step' → 'studio_step'
    ->studly()     // 'studio_step' → 'StudioStep'  
    ->prepend('get') // 'StudioStep' → 'getStudioStep'
    ->append('Schema') // 'getStudioStep' → 'getStudioStepSchema'
    ->toString();
```

### **Esempi Mappatura**
| Step Name | Metodo Chiamato |
|-----------|----------------|
| `studio_step` | `getStudioStepSchema()` |
| `availability_step` | `getAvailabilityStepSchema()` |
| `personal_info_step` | `getPersonalInfoStepSchema()` |

## 🛡️ **Fix Secondario: property_exists Check**

### **Problema Aggiuntivo**
```php
// ❌ ERRATO - Proprietà potrebbe non esistere
$attachments = $model::$attachments;
```

### **Correzione Applicata**
```php  
// ✅ CORRETTO - Check esistenza proprietà
$attachments = property_exists($model, 'attachments') ? $model::$attachments : [];
```

## 📋 **Impatto della Correzione**

### **Prima** ❌
- Homepage registrazione dottore → **500 Error**
- Wizard step non funzionanti
- Sistema bloccato su qualsiasi step dinamico

### **Dopo** ✅
- Homepage registrazione dottore → **Funzionante**
- Step `studio_step` e `availability_step` → **Rendering corretto**
- Wizard navigation → **Fluida**

## 🧪 **Test di Regressione**

### **Verifica Wizard Steps**
- [ ] studio_step → Chiama `getStudioStepSchema()` ✅
- [ ] availability_step → Chiama `getAvailabilityStepSchema()` ✅  
- [ ] personal_info_step → Chiama `getPersonalInfoStepSchema()` ✅

### **Verifica No Loop**
- [ ] Homepage dottore carica senza errori ✅
- [ ] Navigation tra step funzionante ✅
- [ ] Xdebug non rileva più loop infiniti ✅

## ⚠️ **Regole di Prevenzione**

### **Syntax Check Obbligatorio**
1. **MAI** usare `static::$variabile()` per chiamate dinamiche
2. **SEMPRE** usare `static::{$variabile}()` per method calls dinamici
3. **SEMPRE** testare wizard step prima di commit
4. **SEMPRE** verificare property_exists prima di accedere a proprietà statiche

### **Pattern Corretto**
```php
// ✅ Dynamic method call
$methodName = 'getMethodName';
static::{$methodName}();

// ✅ Property existence check  
$prop = property_exists($class, 'property') ? $class::$property : [];
```

## 🔗 **Collegamenti**

### **File Modificati**
- [XotBaseResource.php](../../../Modules/Xot/app/Filament/Resources/XotBaseResource.php) - Fix principale
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
<<<<<<< HEAD
































=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> e7da37af (.)
<<<<<<< HEAD
>>>>>>> 7e4835b8e (.)
=======
=======
>>>>>>> 6d05deed (.)
<<<<<<< HEAD
>>>>>>> 9f193021d (.)
=======
=======
>>>>>>> 39bb163e (.)
>>>>>>> d9f43fce9 (.)
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
=======
<<<<<<< HEAD
>>>>>>> 50d6b63f (.)
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 3bf39332 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 6d05deed (.)
=======
>>>>>>> 39bb163e (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 3bf39332 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 6d05deed (.)
=======
>>>>>>> 39bb163e (.)
>>>>>>> 38b70c7ba (.)
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
<<<<<<< HEAD




























=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
<<<<<<< HEAD
=======
=======
=======
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
>>>>>>> 62cc8443 (.)
- [DoctorResource.php](../../../Modules/SaluteOra/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/SaluteOra/docs/wizard-step-implementation.md)
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 38b70c7ba (.)
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
<<<<<<< HEAD




















- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)




- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)












- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)









































=======
>>>>>>> 28fc70fe (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
- [DoctorResource.php](../../../Modules/SaluteOra/app/Filament/Resources/DoctorResource.php) - Utilizzo step

### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/SaluteOra/docs/wizard-step-implementation.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 50d6b63f (.)
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> e7da37af (.)
<<<<<<< HEAD
>>>>>>> 7e4835b8e (.)
=======
=======
>>>>>>> 6d05deed (.)
<<<<<<< HEAD
>>>>>>> 9f193021d (.)
=======
=======
>>>>>>> 39bb163e (.)
<<<<<<< HEAD
>>>>>>> d9f43fce9 (.)
=======
<<<<<<< HEAD
=======
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 3bf39332 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 6d05deed (.)
=======
>>>>>>> 39bb163e (.)
=======
>>>>>>> 5a14301c (.)
>>>>>>> 50d6b63f (.)
>>>>>>> 551c768c4 (.)
>>>>>>> 38b70c7ba (.)
- [Infinite Loop Prevention](../critical-fixes/infinite-loop-prevention.md)

---

**Priorità**: 🚨 **P0 - CRITICA**  
**Creato**: Gennaio 2025  
**Risolto**: Gennaio 2025  
**Impatto**: Blocco completo sistema registrazione dottori  
**Tempo risoluzione**: < 10 minuti dalla diagnosi  

## 💡 **Lesson Learned**

Questo fix dimostra l'importanza di:
1. **Syntax validation rigorosa** per chiamate dinamiche
2. **Testing immediato** dopo modifiche wizard
3. **Property existence checking** per codice robusto
4. **Xdebug monitoring** per rilevazione loop infiniti

*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
<<<<<<< HEAD


































*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 

*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 9f193021d (.)
=======
>>>>>>> d9f43fce9 (.)
=======
=======
>>>>>>> 28fc70fe (.)
>>>>>>> 851793957 (.)
=======
=======
>>>>>>> 28fc70fe (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 50d6b63f (.)
>>>>>>> 551c768c4 (.)
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
<<<<<<< HEAD
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 43d67f21 (.)
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> b7ea1cd1 (.)
<<<<<<< HEAD
>>>>>>> ecd5ec32 (.)
=======
<<<<<<< HEAD
=======
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 5a14301c (.)
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> d86d643a (.)
=======
>>>>>>> 43d67f21 (.)
=======
<<<<<<< HEAD
=======
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 5a14301c (.)
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> d86d643a (.)
=======
>>>>>>> 43d67f21 (.)
=======
>>>>>>> 50d6b63f (.)
>>>>>>> 38b70c7ba (.)
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
<<<<<<< HEAD
=======
>>>>>>> 39bb163e (.)
=======
>>>>>>> b396242e (.)
<<<<<<< HEAD
=======
=======
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 5a14301c (.)
=======
>>>>>>> 38b70c7ba (.)
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
<<<<<<< HEAD
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 







*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 

*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 



*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 

*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 



*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 



*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 

*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 



*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 






*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 






*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 






*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 






*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 



=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> b7ea1cd1 (.)
>>>>>>> 551c768c4 (.)
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 76bec91a (.)
<<<<<<< HEAD
>>>>>>> 5e6aa70fe (.)
=======
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> e7da37af (.)
<<<<<<< HEAD
>>>>>>> 7e4835b8e (.)
=======
=======
>>>>>>> 55fe1822 (.)
<<<<<<< HEAD
>>>>>>> e39b54ba7 (.)
=======
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 6d05deed (.)
<<<<<<< HEAD
>>>>>>> 9f193021d (.)
=======
=======
>>>>>>> 0d20089f (.)
<<<<<<< HEAD
>>>>>>> ba7efc23f (.)
=======
=======
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 39bb163e (.)
<<<<<<< HEAD
>>>>>>> d9f43fce9 (.)
=======
=======
>>>>>>> b396242e (.)
<<<<<<< HEAD
>>>>>>> 5df5c7505 (.)
=======
=======
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
>>>>>>> 5a14301c (.)
>>>>>>> 50d6b63f (.)
>>>>>>> 551c768c4 (.)
>>>>>>> 38b70c7ba (.)
