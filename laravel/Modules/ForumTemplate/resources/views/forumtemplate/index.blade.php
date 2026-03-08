@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Templates</h4>
                    <a href="{{ route('forum-template.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Author</th>
                                    <th>Forum</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forumTemplates as $forumTemplate)
                                <tr>
                                    <td>{{ $forumTemplate->id }}</td>
                                    <td>{{ $forumTemplate->name }}</td>
                                    <td>{{ Str::limit($forumTemplate->description, 50) }}</td>
                                    <td>{{ $forumTemplate->author->name ?? 'N/A' }}</td>
                                    <td>{{ $forumTemplate->forum->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($forumTemplate->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('forum-template.show', $forumTemplate->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('forum-template.edit', $forumTemplate->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('forum-template.destroy', $forumTemplate->id) }}" method="POST" style="display: inline;">
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
                    {{ $forumTemplates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection