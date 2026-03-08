@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Template Details</h4>
                    <a href="{{ route('forum-template.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $forumTemplate->id }}</p>
                            <p><strong>Name:</strong> {{ $forumTemplate->name }}</p>
                            <p><strong>Author:</strong> {{ $forumTemplate->author->name ?? 'N/A' }}</p>
                            <p><strong>Forum:</strong> {{ $forumTemplate->forum->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Active:</strong> 
                                @if($forumTemplate->is_active)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </p>
                            <p><strong>Created At:</strong> {{ $forumTemplate->created_at ? $forumTemplate->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>Updated At:</strong> {{ $forumTemplate->updated_at ? $forumTemplate->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($forumTemplate->description)
                            <h5>Description:</h5>
                            <div class="border p-3 bg-light">
                                {!! $forumTemplate->description !!}
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <h5>Content:</h5>
                        <div class="border p-3 bg-light">
                            {!! $forumTemplate->content !!}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('forum-template.edit', $forumTemplate->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('forum-template.destroy', $forumTemplate->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection