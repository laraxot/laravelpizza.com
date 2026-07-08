<?php

declare(strict_types=1);

use Modules\Lang\Database\Factories\PostFactory;
use Modules\Lang\Database\Factories\TranslationFactory;
use Modules\Lang\Database\Factories\TranslationFileFactory;
use Modules\Lang\Models\Post;
use Modules\Lang\Models\Translation;
use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Lang Business Logic', function () {
    it('can create and manage posts', function () {
        $user = UserFactory::new()->createOne();

        $post = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'status' => 'draft',
        ]);

        Assert::assertInstanceOf(Post::class, $post);
        Assert::assertSame($user->id, $post->user_id);
        Assert::assertSame('Test Post', $post->title);
        Assert::assertSame('draft', $post->status);

        langAssertDatabaseHasRow('posts', [
            'id' => $post->id,
            'user_id' => $user->id,
            'title' => 'Test Post',
            'status' => 'draft',
        ]);
    });

    it('can publish posts', function () {
        $user = UserFactory::new()->createOne();
        $post = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        $post->update(['status' => 'published']);

        $freshPost = $post->fresh();
        Assert::assertNotNull($freshPost);
        Assert::assertSame('published', $freshPost->status);
        langAssertDatabaseHasRow('posts', [
            'id' => $post->id,
            'status' => 'published',
        ]);
    });

    it('can manage post categories', function () {
        $user = UserFactory::new()->createOne();

        $newsPost = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'category' => 'news',
            'title' => 'News Post',
        ]);

        $tutorialPost = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'category' => 'tutorial',
            'title' => 'Tutorial Post',
        ]);

        Assert::assertSame('news', $newsPost->category);
        Assert::assertSame('tutorial', $tutorialPost->category);
        langAssertDatabaseHasRow('posts', [
            'id' => $newsPost->id,
            'category' => 'news',
        ]);

        langAssertDatabaseHasRow('posts', [
            'id' => $tutorialPost->id,
            'category' => 'tutorial',
        ]);
    });

    it('can create and manage translations', function () {
        $user = UserFactory::new()->createOne();

        $translation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        Assert::assertInstanceOf(Translation::class, $translation);
        Assert::assertSame($user->id, $translation->user_id);
        Assert::assertSame('welcome.message', $translation->key);
        Assert::assertSame('Welcome to our application', $translation->value);
        Assert::assertSame('en', $translation->locale);

        langAssertDatabaseHasRow('translations', [
            'id' => $translation->id,
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);
    });

    it('can manage multilingual content', function () {
        $user = UserFactory::new()->createOne();

        $englishTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        $italianTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Benvenuto nella nostra applicazione',
            'locale' => 'it',
        ]);

        $germanTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Willkommen in unserer Anwendung',
            'locale' => 'de',
        ]);

        Assert::assertSame('Welcome to our application', $englishTranslation->value);
        Assert::assertSame('Benvenuto nella nostra applicazione', $italianTranslation->value);
        Assert::assertSame('Willkommen in unserer Anwendung', $germanTranslation->value);

        langAssertDatabaseHasRow('translations', [
            'key' => 'welcome.message',
            'locale' => 'en',
        ]);

        langAssertDatabaseHasRow('translations', [
            'key' => 'welcome.message',
            'locale' => 'it',
        ]);

        langAssertDatabaseHasRow('translations', [
            'key' => 'welcome.message',
            'locale' => 'de',
        ]);
    });

    it('can manage translation files', function () {
        $translationFile = TranslationFileFactory::new()->createOne([
            'name' => 'welcome.php',
            'path' => module_path('Lang', 'lang/en/welcome.php'),
        ]);

        Assert::assertInstanceOf(TranslationFile::class, $translationFile);
        Assert::assertSame('welcome.php', $translationFile->name);
        Assert::assertSame(module_path('Lang', 'lang/en/welcome.php'), $translationFile->path);
    });

    it('can validate translation keys', function () {
        $user = UserFactory::new()->createOne();

        $validTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'user.profile.name',
            'value' => 'User Name',
            'locale' => 'en',
        ]);

        Assert::assertNotNull($validTranslation->key);
        Assert::assertStringContainsString('.', $validTranslation->key);
        Assert::assertStringStartsWith('user', $validTranslation->key);

        $invalidTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'invalid_key_format',
            'value' => 'Invalid Key',
            'locale' => 'en',
        ]);

        Assert::assertNotNull($invalidTranslation->key);
        Assert::assertStringNotContainsString('.', $invalidTranslation->key);
    });

    it('can manage post workflow', function () {
        $user = UserFactory::new()->createOne();
        $post = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        $post->update(['status' => 'review']);
        $reviewPost = $post->fresh();
        Assert::assertNotNull($reviewPost);
        Assert::assertSame('review', $reviewPost->status);

        $post->update(['status' => 'published']);
        $publishedPost = $post->fresh();
        Assert::assertNotNull($publishedPost);
        Assert::assertSame('published', $publishedPost->status);

        $post->update(['status' => 'archived']);
        $archivedPost = $post->fresh();
        Assert::assertNotNull($archivedPost);
        Assert::assertSame('archived', $archivedPost->status);
    });

    it('can track translation changes', function () {
        $user = UserFactory::new()->createOne();
        $translation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Original message',
            'locale' => 'en',
        ]);

        $translation->update(['value' => 'Updated message']);

        $freshTranslation = $translation->fresh();
        Assert::assertNotNull($freshTranslation);
        Assert::assertSame('Updated message', $freshTranslation->value);
        langAssertDatabaseHasRow('translations', [
            'id' => $translation->id,
            'value' => 'Updated message',
        ]);
    });

    it('can manage post metadata', function () {
        $user = UserFactory::new()->createOne();

        $post = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'title' => 'SEO Optimized Post',
            'meta_title' => 'SEO Meta Title',
            'meta_description' => 'SEO Meta Description',
            'meta_keywords' => 'seo, optimization, meta',
        ]);

        Assert::assertSame('SEO Meta Title', $post->meta_title);
        Assert::assertSame('SEO Meta Description', $post->meta_description);
        Assert::assertSame('seo, optimization, meta', $post->meta_keywords);

        langAssertDatabaseHasRow('posts', [
            'id' => $post->id,
            'meta_title' => 'SEO Meta Title',
            'meta_description' => 'SEO Meta Description',
            'meta_keywords' => 'seo, optimization, meta',
        ]);
    });

    it('can manage translation namespaces', function () {
        $user = UserFactory::new()->createOne();

        $adminTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'admin.dashboard.title',
            'value' => 'Admin Dashboard',
            'locale' => 'en',
            'namespace' => 'admin',
        ]);

        $frontendTranslation = TranslationFactory::new()->createOne([
            'user_id' => $user->id,
            'key' => 'frontend.home.title',
            'value' => 'Home Page',
            'locale' => 'en',
            'namespace' => 'frontend',
        ]);

        Assert::assertSame('admin', $adminTranslation->namespace);
        Assert::assertSame('frontend', $frontendTranslation->namespace);
        langAssertDatabaseHasRow('translations', [
            'id' => $adminTranslation->id,
            'namespace' => 'admin',
        ]);

        langAssertDatabaseHasRow('translations', [
            'id' => $frontendTranslation->id,
            'namespace' => 'frontend',
        ]);
    });

    it('can validate locale formats', function () {
        $user = UserFactory::new()->createOne();

        $validLocales = ['en', 'it', 'de', 'fr', 'es'];

        foreach ($validLocales as $locale) {
            $translation = TranslationFactory::new()->createOne([
                'user_id' => $user->id,
                'key' => "test.{$locale}",
                'value' => "Test in {$locale}",
                'locale' => $locale,
            ]);

            Assert::assertSame($locale, $translation->locale);
            langAssertDatabaseHasRow('translations', [
                'id' => $translation->id,
                'locale' => $locale,
            ]);
        }
    });

    it('can manage post scheduling', function () {
        $user = UserFactory::new()->createOne();
        $futureDate = now()->addDays(7);

        $scheduledPost = PostFactory::new()->createOne([
            'user_id' => $user->id,
            'title' => 'Scheduled Post',
            'status' => 'scheduled',
            'published_at' => $futureDate,
        ]);

        Assert::assertSame('scheduled', $scheduledPost->status);
        Assert::assertNotNull($scheduledPost->published_at);
        Assert::assertSame(
            $futureDate->format('Y-m-d H:i:s'),
            $scheduledPost->published_at->format('Y-m-d H:i:s'),
        );
        langAssertDatabaseHasRow('posts', [
            'id' => $scheduledPost->id,
            'status' => 'scheduled',
        ]);
    });

    it('can track translation statistics', function () {
        $user = UserFactory::new()->createOne();

        TranslationFactory::new()->count(5)->create([
            'user_id' => $user->id,
            'locale' => 'en',
        ]);

        TranslationFactory::new()->count(3)->create([
            'user_id' => $user->id,
            'locale' => 'it',
        ]);

        TranslationFactory::new()->count(2)->create([
            'user_id' => $user->id,
            'locale' => 'de',
        ]);

        $totalTranslations = Translation::where('user_id', $user->id)->count();
        $englishCount = Translation::where('user_id', $user->id)->where('locale', 'en')->count();
        $italianCount = Translation::where('user_id', $user->id)->where('locale', 'it')->count();
        $germanCount = Translation::where('user_id', $user->id)->where('locale', 'de')->count();

        Assert::assertSame(10, $totalTranslations);
        Assert::assertSame(5, $englishCount);
        Assert::assertSame(3, $italianCount);
        Assert::assertSame(2, $germanCount);
    });
});
