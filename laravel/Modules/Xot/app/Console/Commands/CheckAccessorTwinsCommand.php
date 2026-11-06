<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

/**
 * Verifica la regola "accessor + gemello".
 *
 * Ogni metodo `get{Nome}Attribute()` deve avere un gemello `get{Nome}()` sulla stessa classe:
 * l'accessor gestisce cache/coercizione/persistenza, il gemello contiene il calcolo puro,
 * invocabile ed analizzabile staticamente.
 *
 * @see docs/wiki/rules/accessor-twin-method.md
 */
class CheckAccessorTwinsCommand extends Command
{
    protected $signature = 'xot:check-accessor-twins
                            {--module= : Analizza solo il modulo indicato}
                            {--orphans : Elenca invece i gemelli orfani: get*() su una colonna, senza accessor e senza chiamanti}
                            {--fail-on-missing : Esce con codice 1 se trova accessor senza gemello}';

    protected $description = 'Verifica la coppia accessor/gemello: get*Attribute() senza get*(), oppure (--orphans) calcoli mai invocati';

    public function handle(): int
    {
        $module = $this->option('module');
        $moduleName = is_string($module) && $module !== '' ? $module : null;
        $pattern = base_path('Modules/'.($moduleName ?? '*').'/app/Models/*.php');
        $files = $this->modelFiles($moduleName);

        if ($this->option('orphans') === true) {
            return $this->reportOrphanTwins($pattern);
        }

        /** @var array<string, list<string>> $missing */
        $missing = [];
        $accessors = 0;
        $analyzed = 0;

        foreach ($files as $file) {
            $class = $this->classFromPath($file);
            if ($class === null) {
                continue;
            }

            $reflection = new \ReflectionClass($class);

            if ($reflection->isAbstract() || ! $reflection->isSubclassOf(Model::class)) {
                continue;
            }

            $analyzed++;

            foreach ($reflection->getMethods() as $method) {
                $twin = $this->twinName($method);
                if ($twin === null) {
                    continue;
                }

                // Esclude metodi di dominio ereditati da trait/framework vendor
                // (es. HasFactory::getUseFactoryAttribute, HasTranslations::getTranslatableColumnsFromAttribute).
                if ($this->methodFromVendor($reflection, $method)) {
                    continue;
                }

                // Solo metodi dichiarati nei file dei moduli.
                $declaredIn = (string) $method->getDeclaringClass()->getFileName();
                if ($declaredIn === '' || ! str_starts_with($declaredIn, base_path('Modules'))) {
                    continue;
                }

                $accessors++;

                $parameters = $method->getParameters();
                if (! $method->isPublic()) {
                    $missing[$class][] = $method->getName().'() non è public';
                }
                if (
                    count($parameters) !== 1
                    || $parameters[0]->getName() !== 'value'
                    || $parameters[0]->getType() === null
                ) {
                    $missing[$class][] = $method->getName().'() deve ricevere un solo parametro $value tipizzato';
                }
                if ($method->getReturnType() === null) {
                    $missing[$class][] = $method->getName().'() non dichiara il tipo di ritorno';
                }

                if (! $reflection->hasMethod($twin)) {
                    $missing[$class][] = $method->getName().'(): manca '.$twin.'()';

                    continue;
                }

                $twinMethod = $reflection->getMethod($twin);
                if (! $twinMethod->isPublic() || $twinMethod->getReturnType() === null || $twinMethod->getNumberOfRequiredParameters() !== 0) {
                    $missing[$class][] = $method->getName().'() ha un gemello non pubblico, non tipizzato o con parametri obbligatori';
                }
                if (
                    $method->getFileName() !== $twinMethod->getFileName()
                    || $method->getDeclaringClass()->getName() !== $twinMethod->getDeclaringClass()->getName()
                ) {
                    $missing[$class][] = $method->getName().'() e '.$twin.'() non sono dichiarati nello stesso file/tipo';

                    continue;
                }

                if (! $this->delegatesToTwin($method, $twin)) {
                    $missing[$class][] = $method->getName().'() non delega a $this->'.$twin.'()';
                }
            }
        }

        $missingCount = array_sum(array_map('count', $missing));

        foreach ($missing as $class => $methods) {
            $this->line($class);
            foreach (array_unique($methods) as $finding) {
                $this->line('  - '.$finding);
            }
        }

        $this->info(sprintf(
            'Classi analizzate: %d | accessor: %d | senza gemello: %d',
            $analyzed,
            $accessors,
            $missingCount
        ));

        if ($missingCount > 0 && $this->option('fail-on-missing') === true) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * Gemelli orfani: `get{X}()` dove `{x}` e' una colonna della tabella, senza `get{X}Attribute()`.
     *
     * Sono calcoli che nessuno esegue: la colonna non viene mai valorizzata da quel codice. Non e' l'inverso della
     * regola accessor => gemello (generare accessor dai gemelli e' dannoso: maschera le relazioni e ignora il
     * valore gia' in DB), ma il segnale che un calcolo e' rimasto scollegato.
     *
     * @see Modules/Ptv/docs/orphan-twin-methods.md
     */
    private function reportOrphanTwins(string $pattern): int
    {
        $orphans = 0;
        $analyzed = 0;

        foreach (glob($pattern) as $file) {
            if (! is_string($file)) {
                continue;
            }

            $class = $this->classFromPath($file);
            if ($class === null) {
                continue;
            }

            $reflection = new \ReflectionClass($class);
            if ($reflection->isAbstract() || ! $reflection->isSubclassOf(Model::class)) {
                continue;
            }

            /** @var Model $model */
            $model = app($class);

            try {
                $columns = Schema::connection($model->getConnectionName())->getColumnListing($model->getTable());
            } catch (\Throwable) {
                continue; // connection non raggiungibile in questo ambiente
            }

            if ($columns === []) {
                continue;
            }

            $analyzed++;
            $found = [];

            foreach ($reflection->getMethods() as $method) {
                $name = $method->getName();

                if (preg_match('/^get([A-Z].*)$/', $name, $matches) !== 1) {
                    continue;
                }
                if (str_ends_with($name, 'Attribute') || $method->getNumberOfRequiredParameters() > 0) {
                    continue;
                }

                // Metodi del framework (es. Authenticatable::getRememberToken()): non sono gemelli di dominio.
                $declaredIn = (string) $method->getDeclaringClass()->getFileName();
                if ($declaredIn === '' || str_contains($declaredIn, '/vendor/')) {
                    continue;
                }

                $suffix = $matches[1] ?? '';
                if ($suffix === '') {
                    continue;
                }

                $column = Str::snake($suffix);
                if (! in_array($column, $columns, true) || $reflection->hasMethod($name.'Attribute')) {
                    continue;
                }

                $found[$column] = $name;
            }

            if ($found === []) {
                continue;
            }

            $this->line($class);
            foreach ($found as $column => $name) {
                $this->line('  - '.$name.'()  =>  colonna `'.$column.'` senza accessor: calcolo mai invocato');
                $orphans++;
            }
        }

        $this->info(sprintf('Classi analizzate: %d | gemelli orfani: %d', $analyzed, $orphans));

        if ($orphans > 0 && $this->option('fail-on-missing') === true) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * Nome del gemello atteso, null se il metodo non e' un accessor.
     */
    private function twinName(\ReflectionMethod $method): ?string
    {
        if (preg_match('/^get(.+)Attribute$/', $method->getName(), $matches) !== 1) {
            return null;
        }

        $name = $matches[1] ?? '';
        if ($name === '') {
            return null;
        }

        return 'get'.$name;
    }

    /**
     * Verifica se un metodo `get{X}Attribute()` origina da un trait/vendor class
     * (es. HasFactory::getUseFactoryAttribute, HasTranslations::getTranslatableColumnsFromAttribute).
     * I metodi ereditati da trait vendor non sono accessor di dominio e vanno esclusi.
     */
    /** @phpstan-ignore-next-line missingType.generics */
    private function methodFromVendor(\ReflectionClass $reflection, \ReflectionMethod $method): bool
    {
        $checked = [];
        $queue = [$reflection];

        while (! empty($queue)) {
            $current = array_pop($queue);
            if (isset($checked[$current->getName()])) {
                continue;
            }
            $checked[$current->getName()] = true;

            foreach ($current->getTraits() as $trait) {
                if ($trait->hasMethod($method->getName())) {
                    $traitFile = $trait->getFileName();
                    if ($traitFile === '' || str_starts_with((string) $traitFile, base_path('vendor'))) {
                        return true;
                    }
                }
                $queue[] = $trait;
            }

            $parent = $current->getParentClass();
            if ($parent && ! $parent->isInternal()) {
                $queue[] = $parent;
            }
        }

        return false;
    }

    /** @return list<string> */
    private function modelFiles(?string $module): array
    {
        $modulesRoot = base_path('Modules');
        $directories = $module === null
            ? glob($modulesRoot.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Models', \GLOB_ONLYDIR)
            : [$modulesRoot.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Models'];

        $files = [];
        foreach ($directories as $directory) {
            if (! is_string($directory) || ! is_dir($directory)) {
                continue;
            }

            foreach (Finder::create()->files()->name('*.php')->in($directory) as $file) {
                $path = $file->getRealPath();
                if (is_string($path)) {
                    $files[] = $path;
                }
            }
        }

        sort($files);

        return array_values(array_unique($files));
    }

    private function delegatesToTwin(\ReflectionMethod $method, string $twin): bool
    {
        $file = $method->getFileName();
        if (! is_string($file) || ! is_file($file)) {
            return false;
        }

        $lines = explode("\n", file_get_contents($file));
        $source = implode("\n", array_slice(
            $lines,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));
        $tokens = \token_get_all("<?php\n".$source);
        $significant = [];

        foreach ($tokens as $token) {
            if (is_array($token)) {
                if (in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
                    continue;
                }
                $significant[] = [$token[0], $token[1]];

                continue;
            }

            $significant[] = [null, $token];
        }

        $tokenCount = count($significant);
        for ($index = 0; $index + 3 < $tokenCount; $index++) {
            if (
                $significant[$index][0] === T_VARIABLE
                && $significant[$index][1] === '$this'
                && $significant[$index + 1][1] === '->'
                && $significant[$index + 2][0] === T_STRING
                && $significant[$index + 2][1] === $twin
                && $significant[$index + 3][1] === '('
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return class-string<Model>|null
     */
    private function classFromPath(string $file): ?string
    {
        $modulesRoot = base_path('Modules').\DIRECTORY_SEPARATOR;
        if (! str_starts_with($file, $modulesRoot)) {
            return null;
        }

        $relative = substr($file, \strlen($modulesRoot));
        $parts = explode(\DIRECTORY_SEPARATOR, $relative);

        if (\count($parts) < 4 || $parts[1] !== 'app' || $parts[2] !== 'Models') {
            return null;
        }

        $subnamespace = array_slice($parts, 3, -1);
        $class = 'Modules\\'.$parts[0].'\\Models';
        if ($subnamespace !== []) {
            $class .= '\\'.implode('\\', $subnamespace);
        }
        $class .= '\\'.basename($file, '.php');

        if (! class_exists($class) || ! is_subclass_of($class, Model::class)) {
            return null;
        }

        return $class;
    }
}
