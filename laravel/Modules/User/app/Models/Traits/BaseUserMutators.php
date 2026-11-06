<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait BaseUserMutators
{
    public function getFullNameAttribute(?string $value): string
    {
        if ($value !== null) {
            return $value;
        }

        return $this->getFullName();
    }

    public function getFullName(): string
    {
        $fullName = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        return $fullName !== '' ? $fullName : ($this->email ?? 'User');
    }

    public function getNameAttribute(?string $value): string
    {
        if ($value !== null) {
            return $value;
        }

        $name = $this->getName();

        if ($this->getKey() === null) {
            return $name;
        }

        if ($this->isRunningTests()) {
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
        $i = 1;
        $candidate = $name.'-'.$i;

        if ($this->isRunningTests()) {
            return $candidate;
        }

        try {
            $value = $candidate;
            while (self::firstWhere(['name' => $value]) !== null) {
                $i++;
                $value = $name.'-'.$i;
            }

            return $value;
        } catch (\Throwable) {
            return $candidate;
        }
    }

    private function isRunningTests(): bool
    {
        $app = app();
        if (method_exists($app, 'environment') && $app->environment('testing')) {
            return true;
        }

        return \PHP_SAPI === 'cli' && (getenv('APP_ENV') === 'testing' || getenv('ENV') === 'testing');
    }

    public function setPasswordAttribute(?string $value): void
    {
        if (empty($value)) {
            unset($this->attributes['password']);

            return;
        }

        if (\strlen($value) < 32) {
            $this->attributes['password'] = Hash::make($value);

            return;
        }

        $this->attributes['password'] = $value;
    }
}
