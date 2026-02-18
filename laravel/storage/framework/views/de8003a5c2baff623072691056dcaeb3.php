<?php

declare(strict_types=1);

?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null,
    'container0' => '',
    'slug0' => '',
    'data' => []
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null,
    'container0' => '',
    'slug0' => '',
    'data' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($blocks)): ?>
    <div class="page-<?php echo e($side); ?>-content" data-slug="<?php echo e($slug); ?>" data-side="<?php echo e($side); ?>">
        <?php echo $__env->make('cms::components.page-content', [
            'blocks' => $blocks,
            'data' => array_merge(['container0' => $container0, 'slug0' => $slug0], $data)
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/_bases/base_laravelpizza/laravel/Modules/Cms/resources/views/components/page.blade.php ENDPATH**/ ?>