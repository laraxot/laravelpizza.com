<?php

declare(strict_types=1);

use Modules\Job\Models\Export;
use Modules\Job\Models\FailedJob;
use Modules\Job\Models\Frequency;
use Modules\Job\Models\Import;
use Modules\Job\Models\JobBatch;
use Modules\Job\Models\JobManager;
use Modules\Job\Models\Result;
use Modules\Job\Models\Schedule;
use Modules\Job\Models\Task;

describe('Job Models Coverage', function () {
    describe('Task Model', function () {
        it('can be instantiated', function () {
            $task = new Task;
            expect($task)->toBeInstanceOf(Task::class);
        });

        it('uses HasXotFactory trait', function () {
            expect(in_array('Modules\Xot\Models\Traits\HasXotFactory', class_uses(Task::class)))->toBeTrue();
        });

        it('uses FrontendSortable trait', function () {
            expect(in_array('Modules\Job\Models\Traits\FrontendSortable', class_uses(Task::class)))->toBeTrue();
        });

        it('uses Notifiable trait', function () {
            expect(in_array('Illuminate\Notifications\Notifiable', class_uses(Task::class)))->toBeTrue();
        });

        it('has fillable fields defined', function () {
            $task = new Task;
            expect($task->getFillable())->toContain('command');
            expect($task->getFillable())->toContain('description');
            expect($task->getFillable())->toContain('expression');
        });

        it('has appends defined', function () {
            $task = new Task;
            expect($task->getAppends())->toContain('activated');
            expect($task->getAppends())->toContain('upcoming');
            expect($task->getAppends())->toContain('average_runtime');
        });

        it('has frequencies relationship', function () {
            $task = new Task;
            expect(method_exists($task, 'frequencies'))->toBeTrue();
        });

        it('has results relationship', function () {
            $task = new Task;
            expect(method_exists($task, 'results'))->toBeTrue();
        });

        it('has compileParameters method', function () {
            $task = new Task;
            expect(method_exists($task, 'compileParameters'))->toBeTrue();
        });

        it('has autoCleanup method', function () {
            $task = new Task;
            expect(method_exists($task, 'autoCleanup'))->toBeTrue();
        });

        it('has notification routing methods', function () {
            $task = new Task;
            expect(method_exists($task, 'routeNotificationForMail'))->toBeTrue();
            expect(method_exists($task, 'routeNotificationForNexmo'))->toBeTrue();
            expect(method_exists($task, 'routeNotificationForSlack'))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(Task::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('Frequency Model', function () {
        it('can be instantiated', function () {
            $model = new Frequency;
            expect($model)->toBeInstanceOf(Frequency::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(Frequency::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(Frequency::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('Result Model', function () {
        it('can be instantiated', function () {
            $model = new Result;
            expect($model)->toBeInstanceOf(Result::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(Result::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(Result::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('Schedule Model', function () {
        it('can be instantiated', function () {
            $model = new Schedule;
            expect($model)->toBeInstanceOf(Schedule::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(Schedule::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(Schedule::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('Import Model', function () {
        it('can be instantiated', function () {
            $model = new Import;
            expect($model)->toBeInstanceOf(Import::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(Import::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(Import::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('Export Model', function () {
        it('can be instantiated', function () {
            $model = new Export;
            expect($model)->toBeInstanceOf(Export::class);
        });

        it('extends Filament Export', function () {
            $reflection = new ReflectionClass(Export::class);
            expect($reflection->isSubclassOf(\Filament\Actions\Exports\Models\Export::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(Export::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('JobBatch Model', function () {
        it('can be instantiated', function () {
            $model = new JobBatch;
            expect($model)->toBeInstanceOf(JobBatch::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(JobBatch::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(JobBatch::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('JobManager Model', function () {
        it('can be instantiated', function () {
            $model = new JobManager;
            expect($model)->toBeInstanceOf(JobManager::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(JobManager::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(JobManager::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });

    describe('FailedJob Model', function () {
        it('can be instantiated', function () {
            $model = new FailedJob;
            expect($model)->toBeInstanceOf(FailedJob::class);
        });

        it('extends BaseModel', function () {
            $reflection = new ReflectionClass(FailedJob::class);
            expect($reflection->isSubclassOf(\Modules\Job\Models\BaseModel::class))->toBeTrue();
        });

        it('uses strict types', function () {
            $reflection = new ReflectionClass(FailedJob::class);
            $content = file_get_contents($reflection->getFileName());
            expect($content)->toContain('declare(strict_types=1);');
        });
    });
});
