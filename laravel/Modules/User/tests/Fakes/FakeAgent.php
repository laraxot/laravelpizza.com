<?php

declare(strict_types=1);

namespace Modules\User\Tests\Fakes;

use Jenssegers\Agent\Agent;

/**
 * Agent test double — no Mockery magic (PHPStan L10 friendly).
 */
final class FakeAgent extends Agent
{
    public string|bool|null $fakeDevice = null;

    public string|bool|null $fakePlatform = null;

    public string|bool|null $fakeBrowser = null;

    public bool $fakeIsDesktop = false;

    public bool $fakeIsMobile = false;

    public bool $fakeIsTablet = false;

    public bool $fakeIsPhone = false;

    public bool $fakeIsRobot = false;

    /** @var array<string, string|bool|null> */
    public array $fakeVersions = [];

    public string|bool|null $fakeRobot = null;

    /**
     * @param string|null $userAgent
     *
     * @return string|bool
     */
    #[\Override]
    public function device($userAgent = null)
    {
        return $this->fakeDevice ?? false;
    }

    /**
     * @param string|null $userAgent
     *
     * @return string|bool
     */
    #[\Override]
    public function platform($userAgent = null)
    {
        return $this->fakePlatform ?? false;
    }

    /**
     * @param string|null $userAgent
     *
     * @return string|bool
     */
    #[\Override]
    public function browser($userAgent = null)
    {
        return $this->fakeBrowser ?? false;
    }

    /**
     * @param string|null               $userAgent
     * @param array<string, mixed>|null $httpHeaders
     */
    #[\Override]
    public function isDesktop($userAgent = null, $httpHeaders = null): bool
    {
        return $this->fakeIsDesktop;
    }

    /**
     * @param string|null               $userAgent
     * @param array<string, mixed>|null $httpHeaders
     */
    #[\Override]
    public function isMobile($userAgent = null, $httpHeaders = null): bool
    {
        return $this->fakeIsMobile;
    }

    /**
     * @param string|null               $userAgent
     * @param array<string, mixed>|null $httpHeaders
     */
    #[\Override]
    public function isTablet($userAgent = null, $httpHeaders = null): bool
    {
        return $this->fakeIsTablet;
    }

    /**
     * @param string|null               $userAgent
     * @param array<string, mixed>|null $httpHeaders
     */
    #[\Override]
    public function isPhone($userAgent = null, $httpHeaders = null): bool
    {
        return $this->fakeIsPhone;
    }

    /**
     * @param string|null $userAgent
     */
    #[\Override]
    public function isRobot($userAgent = null): bool
    {
        return $this->fakeIsRobot;
    }

    /**
     * @param string $propertyName
     * @param string $type
     *
     * @return string|bool
     */
    #[\Override]
    public function version($propertyName, $type = self::VERSION_TYPE_STRING)
    {
        return $this->fakeVersions[$propertyName] ?? false;
    }

    /**
     * @param string|null $userAgent
     *
     * @return string|bool
     */
    #[\Override]
    public function robot($userAgent = null)
    {
        return $this->fakeRobot ?? false;
    }
}
