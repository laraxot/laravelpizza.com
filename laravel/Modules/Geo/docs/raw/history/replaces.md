---
title: "replaces"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "replaces"
issues: []
discussions: []
---

public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}



public static function getFormSchema(): array
    {
        return [
            $1
        ]; 
    }

---------------------------------------------


public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}
