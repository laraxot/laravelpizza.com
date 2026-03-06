<?php

declare(strict_types=1);

use Modules\Media\Actions\Image\Merge as ImageMerge;
use Modules\Media\Actions\Image\SvgExistsAction;
use Modules\Media\Actions\Video\ConvertVideoAction;
use Modules\Media\Actions\Video\ConvertVideoByConvertDataAction;
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;
use Modules\Media\Actions\Video\GetVideoScreenshotAction;
use Modules\Media\Actions\Video\GetVideoFrameContentAction;
use Modules\Media\Actions\Video\GetVideoDurationAction;
use Modules\Media\Actions\S3\UploadFileAction;
use Modules\Media\Actions\S3\DeleteFileAction;
use Modules\Media\Actions\S3\GetFileInfoAction;
use Modules\Media\Actions\S3\CheckFileExistsAction;
use Modules\Media\Actions\S3\BaseS3Action;
use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;

describe('Media Actions Coverage', function () {
    describe('Image Merge Action', function () {
        it('can be instantiated', function () {
            $action = new ImageMerge();
            expect($action)->toBeInstanceOf(ImageMerge::class);
        });

        it('has handle method', function () {
            $action = new ImageMerge();
            expect(method_exists($action, 'handle'))->toBeTrue();
        });

        it('has execute method', function () {
            $action = new ImageMerge();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ImageMerge::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ImageMerge::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('SvgExistsAction', function () {
        it('can be instantiated', function () {
            $action = new SvgExistsAction();
            expect($action)->toBeInstanceOf(SvgExistsAction::class);
        });

        it('can be resolved from container', function () {
            $action = app(SvgExistsAction::class);
            expect($action)->toBeInstanceOf(SvgExistsAction::class);
        });

        it('has execute method', function () {
            $action = new SvgExistsAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(SvgExistsAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('ConvertVideoAction', function () {
        it('can be instantiated', function () {
            $action = new ConvertVideoAction();
            expect($action)->toBeInstanceOf(ConvertVideoAction::class);
        });

        it('can be resolved from container', function () {
            $action = app(ConvertVideoAction::class);
            expect($action)->toBeInstanceOf(ConvertVideoAction::class);
        });

        it('has execute method', function () {
            $action = new ConvertVideoAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ConvertVideoAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ConvertVideoAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('ConvertVideoByConvertDataAction', function () {
        it('can be instantiated', function () {
            $action = new ConvertVideoByConvertDataAction();
            expect($action)->toBeInstanceOf(ConvertVideoByConvertDataAction::class);
        });

        it('has execute method', function () {
            $action = new ConvertVideoByConvertDataAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ConvertVideoByConvertDataAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ConvertVideoByConvertDataAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('ConvertVideoByMediaConvertAction', function () {
        it('can be instantiated', function () {
            $action = new ConvertVideoByMediaConvertAction();
            expect($action)->toBeInstanceOf(ConvertVideoByMediaConvertAction::class);
        });

        it('has execute method', function () {
            $action = new ConvertVideoByMediaConvertAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(ConvertVideoByMediaConvertAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(ConvertVideoByMediaConvertAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('GetVideoScreenshotAction', function () {
        it('can be instantiated', function () {
            $action = new GetVideoScreenshotAction();
            expect($action)->toBeInstanceOf(GetVideoScreenshotAction::class);
        });

        it('has execute method', function () {
            $action = new GetVideoScreenshotAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetVideoScreenshotAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetVideoScreenshotAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('GetVideoFrameContentAction', function () {
        it('can be instantiated', function () {
            $action = new GetVideoFrameContentAction();
            expect($action)->toBeInstanceOf(GetVideoFrameContentAction::class);
        });

        it('has execute method', function () {
            $action = new GetVideoFrameContentAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetVideoFrameContentAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetVideoFrameContentAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('GetVideoDurationAction', function () {
        it('can be instantiated', function () {
            $action = new GetVideoDurationAction();
            expect($action)->toBeInstanceOf(GetVideoDurationAction::class);
        });

        it('has execute method', function () {
            $action = new GetVideoDurationAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetVideoDurationAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetVideoDurationAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('S3 UploadFileAction', function () {
        it('can be instantiated', function () {
            $action = new UploadFileAction();
            expect($action)->toBeInstanceOf(UploadFileAction::class);
        });

        it('has execute method', function () {
            $action = new UploadFileAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(UploadFileAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(UploadFileAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('S3 DeleteFileAction', function () {
        it('can be instantiated', function () {
            $action = new DeleteFileAction();
            expect($action)->toBeInstanceOf(DeleteFileAction::class);
        });

        it('has execute method', function () {
            $action = new DeleteFileAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(DeleteFileAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(DeleteFileAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('S3 GetFileInfoAction', function () {
        it('can be instantiated', function () {
            $action = new GetFileInfoAction();
            expect($action)->toBeInstanceOf(GetFileInfoAction::class);
        });

        it('has execute method', function () {
            $action = new GetFileInfoAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(GetFileInfoAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetFileInfoAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('S3 CheckFileExistsAction', function () {
        it('can be instantiated', function () {
            $action = new CheckFileExistsAction();
            expect($action)->toBeInstanceOf(CheckFileExistsAction::class);
        });

        it('has execute method', function () {
            $action = new CheckFileExistsAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('extends BaseS3Action', function () {
            $reflection = new ReflectionClass(CheckFileExistsAction::class);
            expect($reflection->isSubclassOf(BaseS3Action::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(CheckFileExistsAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('BaseS3Action', function () {
        it('can be instantiated', function () {
            $action = new BaseS3Action();
            expect($action)->toBeInstanceOf(BaseS3Action::class);
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(BaseS3Action::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(BaseS3Action::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('GetCloudFrontSignedUrlAction', function () {
        it('can be instantiated', function () {
            $action = new GetCloudFrontSignedUrlAction();
            expect($action)->toBeInstanceOf(GetCloudFrontSignedUrlAction::class);
        });

        it('has execute method', function () {
            $action = new GetCloudFrontSignedUrlAction();
            expect(method_exists($action, 'execute'))->toBeTrue();
        });

        it('uses QueueableAction trait', function () {
            expect(in_array('Spatie\QueueableAction\QueueableAction', class_uses(GetCloudFrontSignedUrlAction::class)))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(GetCloudFrontSignedUrlAction::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });
});
