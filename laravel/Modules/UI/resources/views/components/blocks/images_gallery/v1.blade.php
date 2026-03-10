<?php

declare(strict_types=1);

?>
@props(['data'])

<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
      @if ($data['title'])
        <div class="flex w-full mb-20 flex-wrap">
            <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 lg:w-1/3 lg:mb-0 mb-4">{{ $data['title'] }}</h1>
            @if ($data['subtitle'])
              <p class="lg:pl-6 lg:w-2/3 mx-auto leading-relaxed text-base">{{ $data['subtitle'] }}</p>
            @endif
        </div>
      @endif
      <div class="flex flex-wrap md:-m-2 -m-1">
        {{-- {{ dddx([
          $model->content_blocks,
          $model->getImagesGallery()
          ]) }} --}}
        <div class="flex flex-wrap w-1/2">
          <div class="md:p-2 p-1 w-1/2">
            <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://dummyimage.com/500x300">
          </div>
          <div class="md:p-2 p-1 w-1/2">
            <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://dummyimage.com/501x301">
          </div>
          <div class="md:p-2 p-1 w-full">
            <img alt="gallery" class="w-full h-full object-cover object-center block" src="https://dummyimage.com/600x360">
          </div>
        </div>
        <div class="flex flex-wrap w-1/2">
          <div class="md:p-2 p-1 w-full">
            <img alt="gallery" class="w-full h-full object-cover object-center block" src="https://dummyimage.com/601x361">
          </div>
          <div class="md:p-2 p-1 w-1/2">
            <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://dummyimage.com/502x302">
          </div>
          <div class="md:p-2 p-1 w-1/2">
            <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://dummyimage.com/503x303">
          </div>
        </div>
      </div>
    </div>
  </section>
