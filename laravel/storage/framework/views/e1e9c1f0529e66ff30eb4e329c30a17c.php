<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

?>


    <div>
        <?php if (isset($component)) { $__componentOriginale383d99482cddb063ee71e37bf1cd6b8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale383d99482cddb063ee71e37bf1cd6b8 = $attributes; } ?>
<?php $component = Modules\Cms\View\Components\Page::resolve(['side' => 'content','slug' => $pageSlug,'data' => $data] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Modules\Cms\View\Components\Page::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale383d99482cddb063ee71e37bf1cd6b8)): ?>
<?php $attributes = $__attributesOriginale383d99482cddb063ee71e37bf1cd6b8; ?>
<?php unset($__attributesOriginale383d99482cddb063ee71e37bf1cd6b8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale383d99482cddb063ee71e37bf1cd6b8)): ?>
<?php $component = $__componentOriginale383d99482cddb063ee71e37bf1cd6b8; ?>
<?php unset($__componentOriginale383d99482cddb063ee71e37bf1cd6b8); ?>
<?php endif; ?>
    </div>
    <?php /**PATH /var/www/_bases/base_laravelpizza/laravel/storage/framework/views/0bd2cdeb30ccac8bbf0aad11831ba2e2.blade.php ENDPATH**/ ?>