# Ralph Loop Skills - 2026-03-08

## 🎯 Skills per Ralph Loop

### **1. Skill /prd - Generazione PRD**

**Descrizione**: Genera un Product Requirements Document (PRD) strutturato per Ralph Loop

**Comando**: `/prd`

**Workflow**:
1. Riceve richiesta utente
2. Analizza contesto progetto LaravelPizza
3. Crea user stories strutturate in `prd.json`
4. Aggiorna `progress.txt` con apprendimenti

**Esempio di Input**:
```
Crea sistema di gestione eventi per meetup con calendario, iscrizioni e notifiche
```

**Esempio di Output** (`prd.json`):
```json
{
  "title": "Sistema di Gestione Eventi per Meetup",
  "userStories": [
    {
      "id": "story-001",
      "title": "Come organizzatore voglio creare eventi con dettagli",
      "description": "Implementare form creazione evento con data, ora, luogo, descrizione",
      "acceptanceCriteria": ["Campo data obbligatorio", "Validazione orario", "Salvataggio in database"],
      "priority": "high",
      "status": "pending",
      "passes": false
    }
  ]
}
```

### **2. Skill /ralph - Conversione PRD**

**Descrizione**: Converte PRD in formato JSON compatibile con Ralph Loop

**Comando**: `/ralph`

**Workflow**:
1. Legge `prd.md` o `prd.txt`
2. Converte in formato `prd.json`
3. Aggiorna stato user stories
4. Salva in `prd.json`

### **3. Skill /ralph-status - Stato Ralph**

**Descrizione**: Mostra stato corrente del loop Ralph

**Comando**: `/ralph-status`

**Output**:
```
Ralph Loop Status:
- PRD File: prd.json
- Total Stories: 15
- Completed: 8
- Pending: 7
- Failed: 0
```

### **4. Skill /ralph-progress - Progresso**

**Descrizione**: Mostra progresso dettagliato delle user stories

**Comando**: `/ralph-progress`

**Output**:
```
User Stories Progress:
story-001: ✅ Completed
story-002: ⏳ In Progress
story-003: ❌ Failed
...
```

### **5. Skill /ralph-backup - Backup PRD**

**Descrizione**: Crea backup del file PRD

**Comando**: `/ralph-backup`

**Workflow**:
1. Crea backup con timestamp
2. Salva in `prd.json.backup.YYYYMMDD`
3. Verifica integrità backup

### **6. Skill /ralph-restore - Ripristino PRD**

**Descrizione**: Ripristina PRD da backup

**Comando**: `/ralph-restore [data]`

**Esempio**:
```
/ralph-restore 20260308
```

### **7. Skill /ralph-update - Aggiornamento**

**Descrizione**: Aggiorna script Ralph

**Comando**: `/ralph-update`

**Workflow**:
1. Scarica ultima versione
2. Verifica checksum
3. Aggiorna permessi
4. Testa funzionalità

### **8. Skill /ralph-help - Aiuto**

**Descrizione**: Mostra help completo

**Comando**: `/ralph-help`

**Output**:
```
Ralph Loop Skills:
/prd - Genera PRD
/ralph - Converte PRD
/ralph-status - Stato loop
/ralph-progress - Progresso dettagliato
/ralph-backup - Backup PRD
/ralph-restore - Ripristina PRD
/ralph-update - Aggiorna script
/ralph-help - Aiuto
```

## 📋 Implementazione Skills

### **File Skill /prd**
Posizione: `skills/prd/skill.json`

```json
{
  "name": "prd",
  "description": "Genera Product Requirements Document per Ralph Loop",
  "prompt": "Analizza la richiesta dell'utente e crea un PRD strutturato in formato JSON con user stories, criteri accettazione e priorità. Salva il risultato in prd.json",
  "example": "Crea sistema di gestione eventi per meetup con calendario, iscrizioni e notifiche"
}
```

### **File Skill /ralph**
Posizione: `skills/ralph/skill.json`

```json
{
  "name": "ralph",
  "description": "Converte PRD in formato JSON per Ralph Loop",
  "prompt": "Leggi il file PRD e convertilo in formato JSON compatibile con Ralph Loop. Aggiorna stato user stories e salva in prd.json",
  "example": "Converti prd.md in prd.json"
}
```

## 🔧 Configurazione Skills

### **Directory Skills**
```
skills/
├── prd/
│   └── skill.json
└── ralph/
    └── skill.json
```

### **Verifica Skills**
```bash
ls -la skills/
ls -la skills/prd/
ls -la skills/ralph/
```

### **Test Skills**
```bash
# Test skill prd
prd "Crea sistema di gestione eventi"

# Test skill ralph
ralph
```

## 📊 Stato Skills

### **Status Attuale**
- ✅ `skills/prd/skill.json` - Creato
- ✅ `skills/ralph/skill.json` - Creato
- ❌ Script completi - Manca implementazione

### **Prossimi Passi**
1. Implementare script completi per skills
2. Testare funzionalità
3. Integrare con Ralph Loop
4. Documentare esempi

## 🔄 Integrazione con Ralph Loop

### **Workflow Completo**
1. Utente esegue `/prd`
2. Ralph genera `prd.json`
3. Utente esegue `/ralph`
4. Ralph converte PRD
5. Utente esegue `./scripts/ralph/ralph.sh`
6. Ralph esegue iterazioni
7. Utente verifica progresso con `/ralph-progress`

### **File Intermedi**
- `prd.json` - Output PRD
- `progress.txt` - Apprendimenti
- `skills/prd/skill.json` - Skill PRD
- `skills/ralph/skill.json` - Skill Ralph

## 📝 Note e Best Practices

### **Best Practices**
- Mantieni skills separate per funzionalità
- Usa formati standard (JSON, Markdown)
- Documenta esempi chiari
- Testa sempre prima di integrare

### **Troubleshooting**
- **Skill non trovato**: Verifica `skills/` directory
- **Formato errato**: Controlla `skill.json` sintassi
- **Permessi**: `chmod +x skills/*/skill.json`

### **Miglioramenti**
- Aggiungere più skills specifici
- Implementare test automatici
- Creare dashboard visivo
- Integrare con GitHub Actions

## 📞 Comandi Utili

```bash
# Verifica skills
ls -la skills/
cat skills/prd/skill.json
cat skills/ralph/skill.json

# Test skills
prd "test"
ralph

# Verifica stato
./scripts/ralph/ralph.sh --help
cat prd.json | jq '.'

# Backup skills
cp skills/prd/skill.json skills/prd/skill.json.backup.$(date +%Y%m%d)
cp skills/ralph/skill.json skills/ralph/skill.json.backup.$(date +%Y%m%d)
```

---

**Ultimo Aggiornamento**: 2026-03-08
**Stato**: Skills create, implementazione in corso
**Prossimi Passi**: Implementare script completi e testare funzionalità