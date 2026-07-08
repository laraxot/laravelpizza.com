#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Script per analizzare accessor che necessitano di metodo helper.
 * 
 * Identifica accessor con logica di calcolo embedded che dovrebbero
 * delegare a un metodo helper puro.
 */

$file = '/var/www/_bases/base_ptvx_fila5_mono/laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php';

if (!file_exists($file)) {
    echo "❌ File not found: $file\n";
    exit(1);
}

$content = file_get_contents($file);

// Pattern per trovare accessor
preg_match_all(
    '/public function (get\w+Attribute)\([^)]*\):\s*\?[\w\\\\]+\s*\{([^}]+(?:\{[^}]*\}[^}]*)*)\}/s',
    $content,
    $accessors,
    PREG_SET_ORDER
);

// Pattern per trovare metodi helper esistenti
preg_match_all(
    '/public function (get\w+)\(\):\s*\?[\w\\\\]+/s',
    $content,
    $helpers
);

$existingHelpers = array_flip($helpers[1]);

echo "📊 Analisi Accessor → Helper Pattern\n";
echo str_repeat("=", 80) . "\n\n";

$needsHelper = [];
$hasHelper = [];
$total = 0;

foreach ($accessors as $match) {
    $accessorName = $match[1];
    $accessorBody = $match[2];
    
    // Estrai il nome del campo (rimuovi "Attribute" e converti)
    $fieldName = preg_replace('/Attribute$/', '', $accessorName);
    
    // Controlla se esiste già il metodo helper
    $helperExists = isset($existingHelpers[$fieldName]);
    
    // Controlla se l'accessor chiama già il metodo helper
    $callsHelper = preg_match('/\$this->' . preg_quote($fieldName, '/') . '\(\)/', $accessorBody);
    
    // Controlla se c'è logica di calcolo embedded (operazioni matematiche, concatenazioni, ecc.)
    $hasEmbeddedLogic = (
        preg_match('/\$value\s*=\s*[^;]*[\+\-\*\/]/', $accessorBody) || // Operazioni matematiche
        preg_match('/\$value\s*=\s*intval\(/', $accessorBody) ||         // Conversioni
        preg_match('/\$value\s*=\s*\$this->\w+\s*[\+\-]/', $accessorBody) // Calcoli su proprietà
    );
    
    $total++;
    
    if ($helperExists && $callsHelper) {
        $hasHelper[] = [
            'accessor' => $accessorName,
            'helper' => $fieldName,
        ];
    } elseif ($hasEmbeddedLogic && !$callsHelper) {
        $needsHelper[] = [
            'accessor' => $accessorName,
            'helper' => $fieldName,
            'helperExists' => $helperExists,
        ];
    }
}

echo "📈 Statistiche:\n";
echo "  Totale accessor analizzati: $total\n";
echo "  ✅ Accessor con helper corretto: " . count($hasHelper) . "\n";
echo "  ⚠️  Accessor che necessitano helper: " . count($needsHelper) . "\n\n";

if (count($hasHelper) > 0) {
    echo "✅ Accessor già conformi al pattern:\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($hasHelper as $item) {
        echo "  • {$item['accessor']} → {$item['helper']}()\n";
    }
    echo "\n";
}

if (count($needsHelper) > 0) {
    echo "⚠️  Accessor da refactorare:\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($needsHelper as $item) {
        $status = $item['helperExists'] ? '(helper esiste, manca chiamata)' : '(helper da creare)';
        echo "  • {$item['accessor']} → {$item['helper']}() $status\n";
    }
    echo "\n";
    
    echo "📝 Prossimi passi:\n";
    echo "  1. Per ogni accessor, estrarre la logica di calcolo\n";
    echo "  2. Creare metodo helper get<Nome>() se non esiste\n";
    echo "  3. Far chiamare il metodo helper dall'accessor\n";
    echo "  4. Verificare con PHPStan livello 9+\n";
    echo "  5. Aggiungere test unitari per i metodi helper\n\n";
}

// Genera esempio di refactoring per il primo accessor
if (count($needsHelper) > 0) {
    $first = $needsHelper[0];
    echo "💡 Esempio di refactoring per {$first['accessor']}:\n";
    echo str_repeat("-", 80) . "\n";
    echo "// 1. Creare metodo helper (se non esiste):\n";
    echo "public function {$first['helper']}(): ?int\n";
    echo "{\n";
    echo "    // Logica di calcolo estratta dall'accessor\n";
    echo "    return \$this->campo1 + \$this->campo2;\n";
    echo "}\n\n";
    echo "// 2. Modificare accessor per delegare:\n";
    echo "public function {$first['accessor']}(?int \$value): ?int\n";
    echo "{\n";
    echo "    // ... guards e cache ...\n";
    echo "    \n";
    echo "    \$value = \$this->{$first['helper']}(); // ✅ Delega\n";
    echo "    \n";
    echo "    \$this->campo = \$value;\n";
    echo "    \$this->save();\n";
    echo "    \n";
    echo "    return \$value;\n";
    echo "}\n\n";
}

echo "✅ Analisi completata!\n";
echo "📄 Documentazione: /laravel/Modules/Sigma/docs/accessor-helper-pattern.md\n";
