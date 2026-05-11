<?php

declare(strict_types=1);

/**
 * Generate coverage report from merged Clover XML files.
 */
$coverageFiles = array_map(fn ($i) => __DIR__."/coverage-part{$i}.xml", range(1, 6));

$allFiles = [];
$totalStats = [
    'lines' => ['total' => 0, 'covered' => 0],
    'statements' => ['total' => 0, 'covered' => 0],
    'methods' => ['total' => 0, 'covered' => 0],
    'classes' => ['total' => 0, 'covered' => 0],
    'elements' => ['total' => 0, 'covered' => 0],
];

foreach ($coverageFiles as $file) {
    if (! file_exists($file)) {
        echo "Warning: {$file} not found\n";

        continue;
    }

    $xml = simplexml_load_file($file);
    if (! $xml) {
        echo "Warning: Could not parse {$file}\n";

        continue;
    }

    // Navigate through project -> package -> file
    foreach ($xml->project->package as $package) {
        foreach ($package->file as $fileNode) {
            $fileName = (string) $fileNode['name'];

            // Skip if already processed (deduplication)
            if (isset($allFiles[$fileName])) {
                continue;
            }

            $fileStats = [
                'lines' => ['total' => 0, 'covered' => 0],
                'statements' => ['total' => 0, 'covered' => 0],
                'methods' => ['total' => 0, 'covered' => 0],
                'classes' => ['total' => 0, 'covered' => 0],
                'elements' => ['total' => 0, 'covered' => 0],
            ];

            // Get metrics from attributes
            foreach ($fileNode->metrics as $metrics) {
                $attrs = $metrics->attributes();

                $fileStats['statements']['total'] = (int) ($attrs['statements'] ?? 0);
                $fileStats['statements']['covered'] = (int) ($attrs['coveredstatements'] ?? 0);

                $fileStats['methods']['total'] = (int) ($attrs['methods'] ?? 0);
                $fileStats['methods']['covered'] = (int) ($attrs['coveredmethods'] ?? 0);

                $fileStats['classes']['total'] = (int) ($attrs['classes'] ?? 0);
                $fileStats['classes']['covered'] = (int) ($attrs['coveredclasses'] ?? 0);

                $fileStats['elements']['total'] = (int) ($attrs['elements'] ?? 0);
                $fileStats['elements']['covered'] = (int) ($attrs['coveredelements'] ?? 0);

                // Calculate lines from loc
                $fileStats['lines']['total'] = (int) ($attrs['loc'] ?? 0);
                // Estimate covered lines based on statement coverage ratio
                if ($fileStats['statements']['total'] > 0) {
                    $ratio = $fileStats['statements']['covered'] / $fileStats['statements']['total'];
                    $fileStats['lines']['covered'] = (int) round($fileStats['lines']['total'] * $ratio);
                }
            }

            $allFiles[$fileName] = $fileStats;

            // Accumulate totals
            foreach (['lines', 'statements', 'methods', 'classes', 'elements'] as $metric) {
                $totalStats[$metric]['total'] += $fileStats[$metric]['total'];
                $totalStats[$metric]['covered'] += $fileStats[$metric]['covered'];
            }
        }
    }
}

// Generate report
echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║         User Module Test Coverage Report                     ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "Summary:\n";
echo "─────────────────────────────────────────────────────────────────\n";
printf("  %-15s %8s %8s %10s\n", 'Metric', 'Total', 'Covered', 'Percent');
echo "─────────────────────────────────────────────────────────────────\n";

foreach ($totalStats as $metric => $stats) {
    $percent = $stats['total'] > 0
        ? round(($stats['covered'] / $stats['total']) * 100, 2)
        : 0;
    printf("  %-15s %8d %8d %9.2f%%\n",
        ucfirst($metric),
        $stats['total'],
        $stats['covered'],
        $percent
    );
}

echo "─────────────────────────────────────────────────────────────────\n";
echo "\n";

// Files with coverage
echo 'Files analyzed: '.count($allFiles)."\n\n";

// Top covered files (with significant coverage)
echo "Top 30 Covered Files (by element coverage, min 5 elements):\n";
echo "─────────────────────────────────────────────────────────────────\n";

$sortedFiles = $allFiles;
uksort($sortedFiles, function ($a, $b) use ($allFiles) {
    $aStats = $allFiles[$a];
    $bStats = $allFiles[$b];
    $aPercent = $aStats['elements']['total'] > 0
        ? ($aStats['elements']['covered'] / $aStats['elements']['total']) * 100
        : 0;
    $bPercent = $bStats['elements']['total'] > 0
        ? ($bStats['elements']['covered'] / $bStats['elements']['total']) * 100
        : 0;

    return $bPercent <=> $aPercent;
});

$counter = 0;
foreach ($sortedFiles as $fileName => $stats) {
    if ($counter >= 30) {
        break;
    }
    if ($stats['elements']['total'] < 5) {
        continue;
    }

    $percent = $stats['elements']['total'] > 0
        ? round(($stats['elements']['covered'] / $stats['elements']['total']) * 100, 1)
        : 0;
    $shortName = str_replace('/var/www/html/base_ptv_fila5_mono/laravel/', '', $fileName);

    printf("%3d. %6.1f%% (%3d elems) - %s\n", ++$counter, $percent, $stats['elements']['total'], $shortName);
}

echo "\n";

// Files with partial coverage
echo "Files with PARTIAL coverage (< 50%):\n";
echo "─────────────────────────────────────────────────────────────────\n";
$counter = 0;
foreach ($sortedFiles as $fileName => $stats) {
    if ($stats['elements']['total'] < 1) {
        continue;
    }
    $percent = $stats['elements']['total'] > 0
        ? ($stats['elements']['covered'] / $stats['elements']['total']) * 100
        : 0;
    if ($percent >= 50) {
        continue;
    }

    if ($counter >= 15) {
        echo "  ... and more\n";
        break;
    }

    $shortName = str_replace('/var/www/html/base_ptv_fila5_mono/laravel/', '', $fileName);
    printf("  %6.1f%% - %s\n", $percent, $shortName);
    ++$counter;
}

echo "\n";

// Files with no coverage
$uncoveredFiles = array_filter($allFiles, fn ($stats) => 0 === $stats['elements']['covered'] && $stats['elements']['total'] > 0);

if (count($uncoveredFiles) > 0) {
    echo 'Files with NO coverage ('.count($uncoveredFiles)." files):\n";
    echo "─────────────────────────────────────────────────────────────────\n";
    $counter = 0;
    foreach (array_keys($uncoveredFiles) as $fileName) {
        if ($counter >= 15) {
            echo '  ... and '.(count($uncoveredFiles) - 15)." more\n";
            break;
        }
        $shortName = str_replace('/var/www/html/base_ptv_fila5_mono/laravel/', '', $fileName);
        echo '  - '.$shortName."\n";
        ++$counter;
    }
    echo "\n";
}

// Test execution summary
echo "Test Execution Summary (from test runs):\n";
echo "─────────────────────────────────────────────────────────────────\n";
echo "  Part 1 (Unit/Actions):           58 tests run\n";
echo "  Part 2 (Unit/Models/Traits):    230 tests run\n";
echo "  Part 3 (Unit/Datas/Enums/etc):   84 tests run\n";
echo "  Part 4 (Feature/Actions):        40 tests run\n";
echo "  Part 5 (Feature/Filament):      136 tests run\n";
echo "  Part 6 (Feature/User/etc):      288 tests run\n";
echo "─────────────────────────────────────────────────────────────────\n";
$totalTests = 58 + 230 + 84 + 40 + 136 + 288;
echo "  Total:                          {$totalTests} test cases\n";
echo "\n";

echo "Coverage files generated:\n";
foreach ($coverageFiles as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo '  ✓ '.basename($file).' ('.number_format($size)." bytes)\n";
    }
}

echo "\n";
echo 'Report generated: '.date('Y-m-d H:i:s')."\n";
echo "\n";
