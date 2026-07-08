<div>
    <span class="card-fav-icon position-relative z-index-40 "
        @if ($fav) style="background-color:#d60021" @endif wire:click="update()">
        <svg class="svg-icon text-white active">
            <use xlink:href="#heart-1"> </use>
        </svg>
    </span>
</div>
