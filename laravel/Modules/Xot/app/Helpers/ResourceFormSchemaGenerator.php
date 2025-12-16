<?php

declare(strict_types=1);

namespace Modules\Xot\Helpers;

use Exception;
use Illuminate\Support\Str;
use ReflectionClass;
use RuntimeException;
use Webmozart\Assert\Assert;

use function Safe\error_log;
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\glob;
use function Safe\preg_match;
use function Safe\preg_replace;

class ResourceFormSchemaGenerator
{
    /**
     * @param  class-string  $resourceClass
     */
    public static function generateFormSchema(string $resourceClass): bool
    {
        try {
            if (! class_exists($resourceClass)) {
                throw new RuntimeException("Class {$resourceClass} does not exist");
            }

            $reflection = new ReflectionClass($resourceClass);
            $filename = $reflection->getFileName();

            if ($filename === false) {
                throw new RuntimeException("Failed to get filename for class: {$resourceClass}");
            }

            // Read the file contents
            $fileContents = file_get_contents($filename);

            // Check if getFormSchema method already exists
            if (str_contains($fileContents, 'public function getFormSchema')) {
                return false;
            }

            // Generate form schema
            $modelName = str_replace('Resource', '', $reflection->getShortName());
            $modelVariable = Str::camel($modelName);

            $formSchemaMethod = "\n    public function getFormSchema(): array\n    {\n        return [\n";
            $formSchemaMethod .= "            Forms\\Components\\TextInput::make('{$modelVariable}_name')\n";
            $formSchemaMethod .= "                ->required(),\n";
            $formSchemaMethod .= "        ];\n    }\n";

            // Insert the method before the last closing brace
            $modifiedContents = preg_replace('/}(\s*)$/', $formSchemaMethod.'}$1', $fileContents);

            // Write back to the file
            file_put_contents($filename, $modifiedContents);

            return true;
        } catch (Exception $e) {
            error_log("Error generating form schema for {$resourceClass}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * @return array{updated: array<string>, skipped: array<string>}
     */
    public static function generateForAllResources(): array
    {
        $resourceFiles = glob(
            '/var/www/html/base_orisbroker_fila3/laravel/Modules/*/app/Filament/Resources/*Resource.php',
        );

        $results = ['updated' => [], 'skipped' => []];

        foreach ($resourceFiles as $file) {
            try {
                Assert::string($file, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
                $content = file_get_contents($file);
                $namespaceMatch = [];
                $classMatch = [];

                if (
                    preg_match('/namespace\s+([\w\\\\\\\\]+);/', $content, $namespaceMatch) &&
                        preg_match('/class\s+(\w+)\s+extends\s+XotBaseResource/', $content, $classMatch) &&
                        ! empty($namespaceMatch[1]) &&
                        ! empty($classMatch[1])
                ) {
                    $fullClassName = $namespaceMatch[1].'\\'.$classMatch[1];

                    if (class_exists($fullClassName)) {
                        /** @var class-string $fullClassName */
                        if (self::generateFormSchema($fullClassName)) {
                            $results['updated'][] = $fullClassName;
                        }
                    }
                }
            } catch (Exception $e) {
                $results['skipped'][] = is_string($file) ? $file : (((string) $file).': '.$e->getMessage());
            }
        }

        return $results;
    }
}
