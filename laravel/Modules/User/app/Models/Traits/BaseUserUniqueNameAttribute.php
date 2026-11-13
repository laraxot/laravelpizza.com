<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Support\Str;

trait BaseUserUniqueNameAttribute
{
    public function getNameAttribute(?string $value): string
    {
        if ($value !== null) {
            return $value;
        }

        $name = $this->getName();

        if ($this->getKey() === null) {
            return $name;
        }

        if ($this->shouldAvoidNamePersistenceDuringTests()) {
            $this->attributes['name'] = $name;

            return $name;
        }

        try {
            $this->update(['name' => $name]);
        } catch (\Throwable) {
            $name = Str::of((string) $this->email)->before('@')->toString().'-1';
            $this->attributes['name'] = $name;
        }

        return $name;
    }

    public function getName(): string
    {
        if ($this->getKey() === null) {
            return $this->email ?? 'User';
        }

        $name = Str::of((string) $this->email)->before('@')->toString();

        if ($this->shouldAvoidNamePersistenceDuringTests()) {
            return $name.'-1';
        }

        try {
            return $this->resolveUniqueUserName($name);
        } catch (\Throwable) {
            return $name.'-1';
        }
    }

    protected function shouldAvoidNamePersistenceDuringTests(): bool
    {
        $app = app();
        if (method_exists($app, 'environment') && $app->environment('testing')) {
            return true;
        }

        return \PHP_SAPI === 'cli' && (getenv('APP_ENV') === 'testing' || getenv('ENV') === 'testing');
    }

    protected function resolveUniqueUserName(string $name): string
    {
        $i = 1;
        $value = $name.'-'.$i;

        while (static::firstWhere(['name' => $value]) !== null) {
            $i++;
            $value = $name.'-'.$i;
        }

        return $value;
    }
}
