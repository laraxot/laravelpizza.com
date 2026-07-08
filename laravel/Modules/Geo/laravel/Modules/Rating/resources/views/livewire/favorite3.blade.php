<div>
    <!-- Interested button -->
    <input type="checkbox" class="btn-check d-block" id="Interested{{ $post_id }}"
        @if ($fav) checked @endif wire:click="update()">
    <label class="btn btn-sm btn-outline-success d-block" for="Interested{{ $post_id }}">
        <i class="fa-solid fa-thumbs-up me-1"></i>
        Interested
    </label>

    {{-- <!-- Yes button -->
    <input class="btn-check" name="article{{ $post_id }}" id="articleup{{ $post_id }}" wire:click="update()">
    <label class="btn btn-outline-light btn-sm mb-0" for="articleup{{ $post_id }}">
        <i
            @if ($fav) class="fa-solid fa-thumbs-up me-1"
    @else
    class="fa-solid fa-thumbs-down ms-1" @endif></i>
    </label> --}}
</div>
