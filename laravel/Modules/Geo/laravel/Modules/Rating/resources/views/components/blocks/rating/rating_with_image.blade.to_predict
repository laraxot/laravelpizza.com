@props([
    'tpl',
    'version' => 'v1',
])
<div>
  @php
    $model = $_theme->mapArticle($model);
    // dddx($model->ratings);
  @endphp
  {{-- <livewire:article.ratings-with-image :article="$model" type="show" :ratings="[]" :article_uuid="$model->uuid"/> --}}
  <livewire:article.ratings-with-image 
      type="show" 
      :ratings="$model->ratings" 
      :wire:key="$model->uuid" 
      :article_uuid="$model->uuid"
      />
</div>
