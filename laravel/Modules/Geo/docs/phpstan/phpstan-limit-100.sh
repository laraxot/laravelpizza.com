#!/bin/bash

# Configurazione
PHPSTAN="./vendor/bin/phpstan"
LEVEL="9"
TARGET_DIR="Modules"
OUTPUT_FILE="../docs/phpstan/level_9_first_100.json"
MEMORY_LIMIT="16G"

# Esegui PHPStan e filtra i primi 100 errori
php -d memory_limit=$MEMORY_LIMIT $PHPSTAN analyse --level=$LEVEL --error-format=json $TARGET_DIR | \
php -r "
\$input = stream_get_contents(STDIN);
\$json = json_decode(\$input, true);
if (!isset(\$json['files'])) {
    file_put_contents('$OUTPUT_FILE', json_encode(\$json, JSON_PRETTY_PRINT));
    exit;
}
\$count = 0;
foreach (\$json['files'] as \$file => &\$data) {
    if (!isset(\$data['messages'])) continue;
    \$remaining = 100 - \$count;
    \$data['messages'] = array_slice(\$data['messages'], 0, \$remaining);
    \$count += count(\$data['messages']);
    if (\$count >= 100) break;
}
\$json['files'] = array_filter(\$json['files'], fn(\$f) => !empty(\$f['messages']));
file_put_contents('$OUTPUT_FILE', json_encode(\$json, JSON_PRETTY_PRINT));
"
