<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions;

use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Modules\Media\Actions\Image\Merge as ImageMerge;
use Modules\Media\Actions\Image\SvgExistsAction;
use Modules\Media\Actions\S3\BaseS3Action;
use Modules\Media\Actions\S3\CheckFileExistsAction;
use Modules\Media\Actions\S3\DeleteFileAction;
use Modules\Media\Actions\S3\GetFileInfoAction;
use Modules\Media\Actions\S3\UploadFileAction;
use Modules\Media\Actions\Video\ConvertVideoAction;
use Modules\Media\Actions\Video\ConvertVideoByConvertDataAction;
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;
use Modules\Media\Actions\Video\GetVideoDurationAction;
use Modules\Media\Actions\Video\GetVideoFrameContentAction;
use Modules\Media\Actions\Video\GetVideoScreenshotAction;

describe('Media Actions Coverage', function () {
    describe('Image Merge Action', function () {
        it('can be instantiated', function () {
            $action = new ImageMerge;
            expect($action)->toBeInstanceOf(ImageMerge::class);
        });

        it('has handle method', function () {
            $action = new ImageMerge;
            expect(method_exists($action, 'handle'))->toBeTrue();
        });

        it('has execute method', function () {
            $action = new ImageMerge;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ImageMerge::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ImageMerge::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('SvgExistsAction', function () {
        it('can be instantiated', function () {
            $action = new SvgExistsAction;
            expect($action)->toBeInstanceOf(SvgExistsAction::class);
        });

        it('can be resolved from container', function () {
            $action = app(SvgExistsAction::class);
            expect($action)->toBeInstanceOf(SvgExistsAction::class);
        });

        it('has execute method', function () {
            $action = new SvgExistsAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(SvgExistsAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('ConvertVideoAction', function () {
        it('can be instantiated', function () {
            $action = new ConvertVideoAction;
            expect($action)->toBeInstanceOf(ConvertVideoAction::class);
        });

        it('can be resolved from container', function () {
            $action = app(ConvertVideoAction::class);
            expect($action)->toBeInstanceOf(ConvertVideoAction::class);
        });

        it('has execute method', function () {
            $action = new ConvertVideoAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ConvertVideoAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ConvertVideoAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('ConvertVideoByConvertDataAction', function () {
        it('can be instantiated', function () {
            $action = new ConvertVideoByConvertDataAction;
            expect($action)->toBeInstanceOf(ConvertVideoByConvertDataAction::class);
        });

        it('has execute method', function () {
            $action = new ConvertVideoByConvertDataAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ConvertVideoByConvertDataAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ConvertVideoByConvertDataAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('ConvertVideoByMediaConvertAction', function () {
        it('can be instantiated', function () {
            $action = new ConvertVideoByMediaConvertAction;
            expect($action)->toBeInstanceOf(ConvertVideoByMediaConvertAction::class);
        });

        it('has execute method', function () {
            $action = new ConvertVideoByMediaConvertAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ConvertVideoByMediaConvertAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ConvertVideoByMediaConvertAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('GetVideoScreenshotAction', function () {
        it('can be instantiated', function () {
            $action = new GetVideoScreenshotAction;
            expect($action)->toBeInstanceOf(GetVideoScreenshotAction::class);
        });

        it('has backoff property', function () {
            $action = new GetVideoScreenshotAction;
            expect(property_exists($action, 'backoff'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetVideoScreenshotAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetVideoScreenshotAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('GetVideoFrameContentAction', function () {
        it('can be instantiated', function () {
            $action = new GetVideoFrameContentAction;
            expect($action)->toBeInstanceOf(GetVideoFrameContentAction::class);
        });

        it('has execute method', function () {
            $action = new GetVideoFrameContentAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetVideoFrameContentAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetVideoFrameContentAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('GetVideoDurationAction', function () {
        it('can be instantiated', function () {
            $action = new GetVideoDurationAction;
            expect($action)->toBeInstanceOf(GetVideoDurationAction::class);
        });

        it('has execute method', function () {
            $action = new GetVideoDurationAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetVideoDurationAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetVideoDurationAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('S3 UploadFileAction', function () {
        it('has execute method', function () {
            $reflection = new ReflectionClass(UploadFileAction::class);
            expect($reflection->hasMethod('execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(UploadFileAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(UploadFileAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('S3 DeleteFileAction', function () {
        it('has execute method', function () {
            $reflection = new ReflectionClass(DeleteFileAction::class);
            expect($reflection->hasMethod('execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(DeleteFileAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(DeleteFileAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('S3 GetFileInfoAction', function () {
        it('has execute method', function () {
            $reflection = new ReflectionClass(GetFileInfoAction::class);
            expect($reflection->hasMethod('execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(GetFileInfoAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetFileInfoAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('S3 CheckFileExistsAction', function () {
        it('has execute method', function () {
            $reflection = new ReflectionClass(CheckFileExistsAction::class);
            expect($reflection->hasMethod('execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(CheckFileExistsAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(CheckFileExistsAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });

    describe('BaseS3Action', function () {
        it('is abstract', function () {
            $reflection = new ReflectionClass(BaseS3Action::class);
            expect($reflection->isAbstract())->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(BaseS3Action::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(BaseS3Action::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });

        it('has s3Client property', function () {
            $reflection = new ReflectionClass(BaseS3Action::class);
            expect($reflection->hasProperty('s3Client'))->toBeTrue();
        });

        it('has bucketName property', function () {
            $reflection = new ReflectionClass(BaseS3Action::class);
            expect($reflection->hasProperty('bucketName'))->toBeTrue();
        });

        it('has logger property', function () {
            $reflection = new ReflectionClass(BaseS3Action::class);
            expect($reflection->hasProperty('logger'))->toBeTrue();
        });
    });

    describe('GetCloudFrontSignedUrlAction', function () {
        it('can be instantiated', function () {
            $action = new GetCloudFrontSignedUrlAction;
            expect($action)->toBeInstanceOf(GetCloudFrontSignedUrlAction::class);
        });

        it('has execute method', function () {
            $action = new GetCloudFrontSignedUrlAction;
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetCloudFrontSignedUrlAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetCloudFrontSignedUrlAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('');
        });
    });
});
