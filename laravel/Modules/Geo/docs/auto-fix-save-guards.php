<?php

declare(strict_types=1);

/**
 * Script per applicare automaticamente il controllo getKey() prima di save().
 * 
 * ATTENZIONE: Questo script modifica i file! Fare backup prima.
 */

$dryRun = true; // Cambia a false per applicare le modifiche

// Lista file da correggere (dal scan precedente)
$filesToFix = [
    'Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php',
    'Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php',
    'Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php',
    // Aggiungi altri file qui
];

echo "=== AUTO-FIX SAVE GUARDS ===\n\n";
echo "Modalità: " . ($dryRun ? "DRY RUN (nessuna modifica)" : "MODIFICA REALE") . "\n\n";

$totalFixed = 0;

foreach ($filesToFix as $file) {
    if (!file_exists($file)) {
        echo "⚠️  File non trovato: $file\n";
        continue;
    }
    
    $content = file_get_contents($file);
    $lines = explode("\n", $content);
    $modified = false;
    $fixCount = 0;
    
    $inMethod = false;
    $methodName = '';
    $bracketCount = 0;
    
    for ($i = 0; $i < count($lines); $i++) {
        $line = $lines[$i];
        
        // Rileva inizio metodo Attribute
        if (preg_match('/public function (get\w+Attribute|set\w+Attribute)\(/', $line, $matches)) {
            $inMethod = true;
            $methodName = $matches[1];
            $bracketCount = 0;
        }
        
        // Conta parentesi graffe
        if ($inMethod) {
            $bracketCount += substr_count($line, '{') - substr_count($line, '}');
            
            // Fine metodo
            if ($bracketCount <= 0 && strpos($line, '}') !== false) {
                $inMethod = false;
                $methodName = '';
            }
        }
        
        // Cerca $this->save() senza controllo
        if ($inMethod && strpos($line, '$this->save()') !== false) {
            // Verifica se c'è già il controllo
            $hasKeyCheck = false;
            $checkRange = max(0, $i - 15);
            
            for ($j = $checkRange; $j < $i; $j++) {
                if (strpos($lines[$j], 'getKey()') !== false || 
                    strpos($lines[$j], '// Guard: modello') !== false) {
                    $hasKeyCheck = true;
                    break;
                }
            }
            
            if (!$hasKeyCheck) {
                // Trova l'indentazione corretta
                preg_match('/^(\s*)/', $line, $indent);
                $indentation = $indent[1];
                
                // Inserisci il controllo prima di save()
                $guardLines = [
                    $indentation . "// Guard: modello deve avere PK per salvare",
                    $indentation . "if (null == \$this->getKey()) {",
                    $indentation . "    return \$value;",
                    $indentation . "}",
                    $indentation . "",
                ];
                
                array_splice($lines, $i, 0, $guardLines);
                $i += count($guardLines); // Salta le righe inserite
                $modified = true;
                $fixCount++;
                
                echo "   ✓ Corretto $methodName() alla linea " . ($i - count($guardLines) + 1) . "\n";
            }
        }
    }
    
    if ($modified) {
        if (!$dryRun) {
            file_put_contents($file, implode("\n", $lines));
            echo "✅ $file - $fixCount correzioni applicate\n\n";
        } else {
            echo "🔍 $file - $fixCount correzioni da applicare (DRY RUN)\n\n";
        }
        $totalFixed += $fixCount;
    }
}

echo "\n=== RIEPILOGO ===\n\n";
echo "Totale correzioni: $totalFixed\n";

if ($dryRun) {
    echo "\n⚠️  DRY RUN: Nessuna modifica applicata.\n";
    echo "Per applicare le modifiche, cambia \$dryRun = false nello script.\n";
}
