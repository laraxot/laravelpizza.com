<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Harness;

<<<<<<< .merge_file_BVV6dJ
=======
<<<<<<< HEAD
>>>>>>> .merge_file_R2aIud
use Illuminate\Support\Facades\Process;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class)->group('no-xot-db');
<<<<<<< .merge_file_BVV6dJ
=======
=======
use PHPUnit\Framework\Assert;

use Symfony\Component\Process\Process;

use function Safe\json_encode;
>>>>>>> laraxot/dev
>>>>>>> .merge_file_R2aIud

/*
 * Il guard PreToolUse dell'harness (.harness/bin/guard) blocca con exit 2 le azioni vietate dalle regole del
 * progetto e lascia passare tutto il resto: ogni regola ha almeno un caso che la fa scattare e uno vicino che no.
<<<<<<< .merge_file_BVV6dJ
=======
 * Source-level (niente app): il guard deve funzionare proprio quando Laravel non parte, e così il suo test.
>>>>>>> .merge_file_R2aIud
 *
 * @see Modules/Xot/docs/adr/agent-harness.md
 */

/**
 * @param  array<array-key, mixed>  $input  il tool_input del payload, passato com'è a json_encode
 * @return array{0: int, 1: string}
 */
function runHarnessGuard(string $tool, array $input): array
{
<<<<<<< .merge_file_BVV6dJ
=======
<<<<<<< HEAD
>>>>>>> .merge_file_R2aIud
    $result = Process::env(['HARNESS_RUNS_DIR' => sys_get_temp_dir().'/harness-guard-test'])
        ->input(json_encode(['hook_event_name' => 'PreToolUse', 'tool_name' => $tool, 'tool_input' => $input]))
        ->run([PHP_BINARY, dirname(base_path()).'/.harness/bin/guard']);

    return [$result->exitCode() ?? -1, $result->errorOutput()];
<<<<<<< .merge_file_BVV6dJ
=======
=======
    $process = new Process(
        [PHP_BINARY, dirname(__DIR__, 6).'/.harness/bin/guard'],
        null,
        ['HARNESS_RUNS_DIR' => sys_get_temp_dir().'/harness-guard-test'],
        json_encode(['hook_event_name' => 'PreToolUse', 'tool_name' => $tool, 'tool_input' => $input]),
    );
    $process->run();

    return [$process->getExitCode() ?? -1, $process->getErrorOutput()];
>>>>>>> laraxot/dev
>>>>>>> .merge_file_R2aIud
}

it('blocks what the project rules forbid', function (string $rule, string $tool, array $input): void {
    [$exit, $stderr] = runHarnessGuard($tool, $input);

    Assert::assertSame(2, $exit, "atteso blocco [{$rule}]");
    Assert::assertStringContainsString("[harness:{$rule}]", $stderr);
})->with([
    'read .env' => ['secrets.env', 'Read', ['file_path' => '/repo/laravel/.env']],
    'cat .env' => ['secrets.env', 'Bash', ['command' => 'cat laravel/.env']],
    'grep in .env.production' => ['secrets.env', 'Bash', ['command' => 'grep DB_ .env.production']],
    'dropColumn' => ['migration.destructive', 'Edit', ['file_path' => '/r/laravel/Modules/Blog/database/migrations/2024_01_01_000011_create_articles_table.php', 'new_string' => '$table->dropColumn(\'title\');']],
    'change()' => ['migration.destructive', 'Write', ['file_path' => '/r/laravel/Modules/Rating/database/migrations/x.php', 'content' => '$table->decimal(\'amount\')->change();']],
    'migrate:fresh' => ['db.fresh', 'Bash', ['command' => 'php artisan migrate:fresh --seed']],
    'RefreshDatabase' => ['db.fresh', 'Write', ['file_path' => '/r/laravel/Modules/Blog/tests/Feature/XTest.php', 'content' => 'uses(RefreshDatabase::class);']],
    'reset --hard' => ['git.rewind', 'Bash', ['command' => 'git reset --hard HEAD~1']],
    'checkout file' => ['git.rewind', 'Bash', ['command' => 'git checkout -- laravel/composer.json']],
    'checkout branch' => ['git.rewind', 'Bash', ['command' => 'git -C laravel/Modules/Xot checkout -b feature']],
    'restore' => ['git.rewind', 'Bash', ['command' => 'git restore app/Models/User.php']],
    'push --force' => ['git.rewind', 'Bash', ['command' => 'git push --force laraxot dev']],
<<<<<<< .merge_file_BVV6dJ
=======
    'push +refspec' => ['git.rewind', 'Bash', ['command' => 'git push laraxot +HEAD:dev']],
    'db:wipe' => ['db.fresh', 'Bash', ['command' => 'php artisan db:wipe']],
    'migrate --force' => ['db.fresh', 'Bash', ['command' => 'php artisan migrate --force']],
    'switch' => ['git.rewind', 'Bash', ['command' => 'git switch main']],
    'clean -fd' => ['git.rewind', 'Bash', ['command' => 'git clean -fd']],
    'stash drop' => ['git.rewind', 'Bash', ['command' => 'git stash drop']],
    'MultiEdit dropIfExists' => ['migration.destructive', 'MultiEdit', ['file_path' => '/r/laravel/Modules/Geo/database/migrations/x.php', 'edits' => [['old_string' => 'a', 'new_string' => "Schema::dropIfExists('places');"]]]],
    'Edit .env.production' => ['secrets.env', 'Edit', ['file_path' => '/r/laravel/.env.production', 'new_string' => 'X=1']],
>>>>>>> .merge_file_R2aIud
]);

it('lets ordinary work through', function (string $tool, array $input): void {
    [$exit] = runHarnessGuard($tool, $input);

    Assert::assertSame(0, $exit);
})->with([
    'read .env.example' => ['Read', ['file_path' => '/repo/laravel/.env.example']],
    'grep .env.testing' => ['Bash', ['command' => 'grep DB_DATABASE laravel/.env.testing']],
    'config:show' => ['Bash', ['command' => 'php artisan config:show database.default']],
    'additive migration' => ['Edit', ['file_path' => '/r/laravel/Modules/Blog/database/migrations/x.php', 'new_string' => "if (! \$this->hasColumn('slug')) { \$table->string('slug')->nullable(); }"]],
    'migrate' => ['Bash', ['command' => 'php artisan migrate --pretend']],
    'git status/log/commit' => ['Bash', ['command' => 'git status --short && git log -3 && git commit -m "fix"']],
    'restore --staged' => ['Bash', ['command' => 'git restore --staged laravel/composer.json']],
    'normal push' => ['Bash', ['command' => 'git push laraxot HEAD:dev']],
    'payload without tool' => ['', []],
<<<<<<< .merge_file_BVV6dJ
=======
    'stash push' => ['Bash', ['command' => 'git stash push -m wip']],
    'dropColumn outside migrations' => ['Edit', ['file_path' => '/r/laravel/Modules/Xot/docs/rules/migrations.md', 'new_string' => 'mai ->dropColumn(']],
    'git named in a heredoc body' => ['Bash', ['command' => "cat >> story.md <<'EOF'\n- `git switch --help` era bloccato\nEOF\necho ok"]],
    'RefreshDatabase named in a test comment' => ['Edit', ['file_path' => '/r/laravel/Modules/Xot/tests/Unit/XTest.php', 'new_string' => '// mai RefreshDatabase qui']],
    'RefreshDatabase named in docs' => ['Write', ['file_path' => '/r/laravel/Modules/Xot/docs/adr/x.md', 'content' => 'mai RefreshDatabase']],
    'read .env.testing' => ['Read', ['file_path' => '/r/laravel/.env.testing']],
>>>>>>> .merge_file_R2aIud
]);
