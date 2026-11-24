---
<<<<<<< .merge_file_SmJjQR
<<<<<<< .merge_file_QAKsJi
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_rkRNv4
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_SmJjQR
>>>>>>> .merge_file_qgWwzk
=======
>>>>>>> .merge_file_rkRNv4
qmd: "database schema"
issues: []
discussions: []
title: "Notify Module Database Schema"
type: reference
tags: [notify, database, schema]
created: 2026-07-28
---

# Notify Module — Database Schema

## notifications Table

```sql
id UUID PRIMARY KEY
notifiable_id UUID NOT NULL
notifiable_type VARCHAR(255) NOT NULL
type VARCHAR(255) NOT NULL
data LONGTEXT (JSON)
read_at TIMESTAMP NULL
created_at TIMESTAMP
```

**Polymorphic:** notifiable_id + notifiable_type (usually User)
**Channels:** Stored in data JSON (mail, sms, slack)
