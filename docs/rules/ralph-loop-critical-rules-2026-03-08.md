# Ralph Loop Critical Rules - 2026-03-08

## 🚨 CRITICAL RULES - Ralph Loop Implementation

### **Regola Fondamentale da Ricordare SEMPRE**

**MAI** usare funzionalità che richiedono persistenza del contesto LLM senza meccanismi di backup!

### **Principi Fondamentali**
- **Loop Infinito**: `while :; do cat PROMPT.md | agent ; done`
- **Context Management**: Progresso non persiste nel contesto LLM, ma nei file e git history
- **Rotazione Contesto**: Ogni iterazione inizia con contesto pulito
- **Apprendimento Continuo**: Agent aggiorna AGENTS.md con pattern e gotchas

### **File di Configurazione Amp**
Posizione: `~/.config/amp/settings.json`

**DOVETE AGGIUNGERE QUESTO CONTENUTO:**
```json
{
  "amp.experimental.autoHandoff": { "context": 90 }
}
```

### **Workflows con Ralph**
1. **Crea PRD**: Usa skill `/prd` per generare Product Requirements Document
2. **Converti in JSON**: Usa skill `/ralph` per convertire PRD in `prd.json`
3. **Esegui Ralph Loop**: `./scripts/ralph/ralph.sh [max_iterations]`
4. **Verifica Progresso**: `cat prd.json | jq '.userStories[] | {id, title, passes}'`

### **File Chiave**
- `scripts/ralph/ralph.sh` - Loop autonomo AI
- `scripts/ralph/prompt.md` - Template prompt per Amp
- `scripts/ralph/CLAUDE.md` - Template prompt per Claude Code
- `prd.json` - User stories con stato `passes`
- `progress.txt` - Apprendimenti e contesto
- `skills/prd/` - Skill per generazione PRD
- `skills/ralph/` - Skill per conversione PRD

### **PROMEMORIA PER SEMPRE:**
> 'Usa Ralph Loop per sviluppo autonomo. Crea PRD, esegui loop, verifica progresso!'

## 📋 Stato Attuale Installazione

### **File Installati**
- ✅ `scripts/ralph/ralph.sh` - Script principale Ralph
- ✅ `scripts/ralph/prompt.md` - Template prompt Amp
- ✅ `scripts/ralph/CLAUDE.md` - Template prompt Claude Code
- ✅ `prd.json.example` - Esempio PRD
- ✅ `skills/prd/` - Directory skills PRD
- ✅ `skills/ralph/` - Directory skills Ralph

### **File Manenti**
- ❌ `skills/ralph/skill.json` - Skill non trovato
- ❌ `skills/prd/skill.json` - Skill non trovato

## 🔧 Configurazione Richiesta

### **Verifica Configurazione Amp**
```bash
cat ~/.config/amp/settings.json
```

### **Se non esiste, crea il file:**
```bash
mkdir -p ~/.config/amp
cat > ~/.config/amp/settings.json << 'EOF'
{
  "amp.experimental.autoHandoff": { "context": 90 }
}
EOF
```

## 🚀 Utilizzo Rapido

### **1. Crea PRD**
```bash
prd
```

### **2. Converti in JSON**
```bash
ralph
```

### **3. Esegui Ralph Loop**
```bash
./scripts/ralph/ralph.sh 10
```

### **4. Verifica Progresso**
```bash
cat prd.json | jq '.userStories[] | {id, title, passes}'
```

## 📊 Stato PRD

### **Verifica Stato**
```bash
cat prd.json | jq '.userStories | length'
cat prd.json | jq '.userStories[] | select(.passes == false) | {id, title}'
```

## 💾 Backup e Ripristino

### **Backup PRD**
```bash
cp prd.json prd.json.backup.$(date +%Y%m%d)
```

### **Ripristino PRD**
```bash
cp prd.json.backup.YYYYMMDD prd.json
```

## 🔄 Aggiornamenti e Mantenimento

### **Aggiornamento Ralph**
```bash
cd scripts/ralph
curl -fsSL https://raw.githubusercontent.com/snarktank/ralph/main/ralph.sh -o ralph.sh
chmod +x ralph.sh
```

## 📝 Note e Gotchas

### **Limitazioni**
- Ralph Loop richiede contesto pulito per ogni iterazione
- Progresso non persiste nel contesto LLM
- Usa file e git history per tracciare il progresso

### **Best Practices**
- Verifica sempre il contesto prima di eseguire Ralph Loop
- Usa `prd.json` per tracciare il progresso
- Esegui backup prima di grandi iterazioni
- Monitora `progress.txt` per apprendimenti

### **Troubleshooting**
- **Errore di permessi**: `chmod +x scripts/ralph/ralph.sh`
- **File skill mancanti**: Crea manualmente o scarica da repository Ralph
- **Configurazione Amp**: Verifica `~/.config/amp/settings.json`

## 🎯 Obiettivi Future

### **Implementazione Completa**
- [ ] Installare skill Ralph mancanti
- [ ] Configurare Amp correttamente
- [ ] Testare workflow completo
- [ ] Integrare con GitHub Issues
- [ ] Automatizzare backup PRD

### **Miglioramenti**
- [ ] Aggiungere logging dettagliato
- [ ] Implementare monitoraggio progresso
- [ ] Creare dashboard visivo
- [ ] Automatizzare aggiornamenti
- [ ] Integrare con CI/CD

## 📞 Comandi Utili

```bash
# Verifica stato Ralph
./scripts/ralph/ralph.sh --help

# Verifica file PRD
cat prd.json | jq '.'

# Verifica skills
ls -la skills/

# Verifica configurazione Amp
cat ~/.config/amp/settings.json

# Verifica permessi script
ls -la scripts/ralph/

# Backup PRD
cp prd.json prd.json.backup.$(date +%Y%m%d)

# Ripristino PRD
cp prd.json.backup.YYYYMMDD prd.json

# Aggiornamento Ralph
cd scripts/ralph && curl -fsSL https://raw.githubusercontent.com/snarktank/ralph/main/ralph.sh -o ralph.sh && chmod +x ralph.sh
```

---

**Ultimo Aggiornamento**: 2026-03-08
**Stato**: Installazione in corso
**Prossimo Passo**: Configurare Amp e testare workflow completo