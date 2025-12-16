<?php

declare(strict_types=1);

use Modules\Lang\Models\Post;
use Modules\Lang\Models\Translation;
use Modules\Lang\Models\TranslationFile;
use Modules\User\Models\User;

describe('Lang Business Logic', function () {
    it('can create and manage posts', function () {
        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'status' => 'draft',
        ]);

        expect($post)
            ->toBeInstanceOf(Post::class)
            ->and($post->user_id)
            ->toBe($user->id)
            ->and($post->title)
            ->toBe('Test Post')
            ->and($post->status)
            ->toBe('draft');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $user->id,
            'title' => 'Test Post',
            'status' => 'draft',
        ]);
    });

    it('can publish posts', function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        $post->update(['status' => 'published']);

        expect($post->fresh()->status)->toBe('published');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'published',
        ]);
    });

    it('can manage post categories', function () {
        $user = User::factory()->create();

        $newsPost = Post::factory()->create([
            'user_id' => $user->id,
            'category' => 'news',
            'title' => 'News Post',
        ]);

        $tutorialPost = Post::factory()->create([
            'user_id' => $user->id,
            'category' => 'tutorial',
            'title' => 'Tutorial Post',
        ]);

        expect($newsPost->category)->toBe('news')->and($tutorialPost->category)->toBe('tutorial');

        $this->assertDatabaseHas('posts', [
            'id' => $newsPost->id,
            'category' => 'news',
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $tutorialPost->id,
            'category' => 'tutorial',
        ]);
    });

    it('can create and manage translations', function () {
        $user = User::factory()->create();

        $translation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        expect($translation)
            ->toBeInstanceOf(Translation::class)
            ->and($translation->user_id)
            ->toBe($user->id)
            ->and($translation->key)
            ->toBe('welcome.message')
            ->and($translation->value)
            ->toBe('Welcome to our application')
            ->and($translation->locale)
            ->toBe('en');

        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);
    });

    it('can manage multilingual content', function () {
        $user = User::factory()->create();

        $englishTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        $italianTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Benvenuto nella nostra applicazione',
            'locale' => 'it',
        ]);

        $germanTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Willkommen in unserer Anwendung',
            'locale' => 'de',
        ]);

        expect($englishTranslation->value)
            ->toBe('Welcome to our application')
            ->and($italianTranslation->value)
            ->toBe('Benvenuto nella nostra applicazione')
            ->and($germanTranslation->value)
            ->toBe('Willkommen in unserer Anwendung');

        $this->assertDatabaseHas('translations', [
            'key' => 'welcome.message',
            'locale' => 'en',
        ]);

        $this->assertDatabaseHas('translations', [
            'key' => 'welcome.message',
            'locale' => 'it',
        ]);

        $this->assertDatabaseHas('translations', [
            'key' => 'welcome.message',
            'locale' => 'de',
        ]);
    });

    it('can manage translation files', function () {
        $user = User::factory()->create();

        $translationFile = TranslationFile::factory()->create([
            'user_id' => $user->id,
            'filename' => 'welcome.php',
            'locale' => 'en',
            'content' => '<?php return ["welcome" => "Welcome"];',
        ]);

        expect($translationFile)
            ->toBeInstanceOf(TranslationFile::class)
            ->and($translationFile->user_id)
            ->toBe($user->id)
            ->and($translationFile->filename)
            ->toBe('welcome.php')
            ->and($translationFile->locale)
            ->toBe('en');

        $this->assertDatabaseHas('translation_files', [
            'id' => $translationFile->id,
            'user_id' => $user->id,
            'filename' => 'welcome.php',
            'locale' => 'en',
        ]);
    });

    it('can validate translation keys', function () {
        $user = User::factory()->create();

        $validTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'user.profile.name',
            'value' => 'User Name',
            'locale' => 'en',
        ]);

        expect($validTranslation->key)->toContain('.')->and($validTranslation->key)->toStartWith('user');

        $invalidTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'invalid_key_format',
            'value' => 'Invalid Key',
            'locale' => 'en',
        ]);

        expect($invalidTranslation->key)->not->toContain('.');
    });

    it('can manage post workflow', function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        // Draft to Review
        $post->update(['status' => 'review']);
        expect($post->fresh()->status)->toBe('review');

        // Review to Published
        $post->update(['status' => 'published']);
        expect($post->fresh()->status)->toBe('published');

        // Published to Archived
        $post->update(['status' => 'archived']);
        expect($post->fresh()->status)->toBe('archived');
    });

    it('can track translation changes', function () {
        $user = User::factory()->create();
        $translation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Original message',
            'locale' => 'en',
        ]);

        $translation->update(['value' => 'Updated message']);

        expect($translation->fresh()->value)->toBe('Updated message');

        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'value' => 'Updated message',
        ]);
    });

    it('can manage post metadata', function () {
        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'SEO Optimized Post',
            'meta_title' => 'SEO Meta Title',
            'meta_description' => 'SEO Meta Description',
            'meta_keywords' => 'seo, optimization, meta',
        ]);

        expect($post->meta_title)
            ->toBe('SEO Meta Title')
            ->and($post->meta_description)
            ->toBe('SEO Meta Description')
            ->and($post->meta_keywords)
            ->toBe('seo, optimization, meta');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'meta_title' => 'SEO Meta Title',
            'meta_description' => 'SEO Meta Description',
            'meta_keywords' => 'seo, optimization, meta',
        ]);
    });

    it('can manage translation namespaces', function () {
        $user = User::factory()->create();

        $adminTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'admin.dashboard.title',
            'value' => 'Admin Dashboard',
            'locale' => 'en',
            'namespace' => 'admin',
        ]);

        $frontendTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'frontend.home.title',
            'value' => 'Home Page',
            'locale' => 'en',
            'namespace' => 'frontend',
        ]);

        expect($adminTranslation->namespace)->toBe('admin')->and($frontendTranslation->namespace)->toBe('frontend');

        $this->assertDatabaseHas('translations', [
            'id' => $adminTranslation->id,
            'namespace' => 'admin',
        ]);

        $this->assertDatabaseHas('translations', [
            'id' => $frontendTranslation->id,
            'namespace' => 'frontend',
        ]);
    });

    it('can validate locale formats', function () {
        $user = User::factory()->create();

        $validLocales = ['en', 'it', 'de', 'fr', 'es'];

        foreach ($validLocales as $locale) {
            $translation = Translation::factory()->create([
                'user_id' => $user->id,
                'key' => "test.{$locale}",
                'value' => "Test in {$locale}",
                'locale' => $locale,
            ]);

            expect($translation->locale)->toBe($locale);

            $this->assertDatabaseHas('translations', [
                'id' => $translation->id,
                'locale' => $locale,
            ]);
        }
    });

    it('can manage post scheduling', function () {
        $user = User::factory()->create();
        $futureDate = now()->addDays(7);

        $scheduledPost = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Scheduled Post',
            'status' => 'scheduled',
            'published_at' => $futureDate,
        ]);

        expect($scheduledPost->status)->toBe('scheduled')->and($scheduledPost->published_at)->toEqual($futureDate);

        $this->assertDatabaseHas('posts', [
            'id' => $scheduledPost->id,
            'status' => 'scheduled',
            'published_at' => $futureDate,
        ]);
    });

    it('can track translation statistics', function () {
        $user = User::factory()->create();

        Translation::factory()
            ->count(5)
            ->create([
                'user_id' => $user->id,
                'locale' => 'en',
            ]);

        Translation::factory()
            ->count(3)
            ->create([
                'user_id' => $user->id,
                'locale' => 'it',
            ]);

        Translation::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
                'locale' => 'de',
            ]);

        $totalTranslations = Translation::where('user_id', $user->id)->count();
        $englishCount = Translation::where('user_id', $user->id)->where('locale', 'en')->count();
        $italianCount = Translation::where('user_id', $user->id)->where('locale', 'it')->count();
        $germanCount = Translation::where('user_id', $user->id)->where('locale', 'de')->count();

        expect($totalTranslations)
            ->toBe(10)
            ->and($englishCount)
            ->toBe(5)
            ->and($italianCount)
            ->toBe(3)
            ->and($germanCount)
            ->toBe(2);
    });
});
