@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Announcement Details</h4>
                    <a href="{{ route('forum-announcement.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $forumAnnouncement->id }}</p>
                            <p><strong>Title:</strong> {{ $forumAnnouncement->title }}</p>
                            <p><strong>Author:</strong> {{ $forumAnnouncement->author->name ?? 'N/A' }}</p>
                            <p><strong>Forum:</strong> {{ $forumAnnouncement->forum->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Active:</strong> 
                                @if($forumAnnouncement->is_active)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </p>
                            <p><strong>Starts At:</strong> {{ $forumAnnouncement->starts_at ? $forumAnnouncement->starts_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>Ends At:</strong> {{ $forumAnnouncement->ends_at ? $forumAnnouncement->ends_at->format('M d, Y H:i') : 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $forumAnnouncement->created_at ? $forumAnnouncement->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>Content:</h5>
                        <div class="border p-3 bg-light">
                            {!! $forumAnnouncement->content !!}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('forum-announcement.edit', $forumAnnouncement->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('forum-announcement.destroy', $forumAnnouncement->id) }}" method="POST" style="display: inline;">
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