@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Announcements</h4>
                    <a href="{{ route('forum-announcement.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Forum</th>
                                    <th>Active</th>
                                    <th>Starts At</th>
                                    <th>Ends At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forumAnnouncements as $forumAnnouncement)
                                <tr>
                                    <td>{{ $forumAnnouncement->id }}</td>
                                    <td>{{ $forumAnnouncement->title }}</td>
                                    <td>{{ $forumAnnouncement->author->name ?? 'N/A' }}</td>
                                    <td>{{ $forumAnnouncement->forum->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($forumAnnouncement->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $forumAnnouncement->starts_at ? $forumAnnouncement->starts_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>{{ $forumAnnouncement->ends_at ? $forumAnnouncement->ends_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('forum-announcement.show', $forumAnnouncement->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('forum-announcement.edit', $forumAnnouncement->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('forum-announcement.destroy', $forumAnnouncement->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $forumAnnouncements->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection