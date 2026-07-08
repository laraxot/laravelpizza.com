# 🔧 Utility Patterns

## 💾 Cache Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Illuminate\Support\Facades\Cache;
use Modules\NomeModulo\Models\User;

class UserCacheService
{
    private const CACHE_TTL = 3600; // 1 ora
    private const CACHE_PREFIX = 'users';
    
    public function getUserById(int $id): ?User
    {
        $cacheKey = $this->getCacheKey('user', $id);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return User::find($id);
        });
    }
    
    private function getCacheKey(string $type, mixed $identifier): string
    {
        return self::CACHE_PREFIX . ":{$type}:{$identifier}";
    }
    
    public function clearUserCache(int $userId): void
    {
        Cache::forget($this->getCacheKey('user', $userId));
    }
}
```

## 📨 Queue/Job Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Services\EmailService;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function __construct(
        private readonly array $userIds,
        private readonly string $subject,
        private readonly string $message
    ) {}
    
    public function handle(EmailService $emailService): void
    {
        $users = User::whereIn('id', $this->userIds)->get();
        
        foreach ($users as $user) {
            $emailService->sendEmail($user, $this->subject, $this->message);
        }
    }
    
    public function tags(): array
    {
        return ['bulk-email', 'users'];
    }
}
```
