@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8 text-center">
    
    <ul class="list-group">
        <li class="list-group-item active">Task Details</li>
        <li class="list-group-item text-left"><strong>Title:</strong> {{ $task['title'] }}</li>
        <li class="list-group-item text-left"><strong>Description:</strong> {{ $task['description'] }}</li>
        <li class="list-group-item text-left"><strong>Status:</strong> {{ $task['status'] }}</li>
        <li class="list-group-item text-left"><strong>Duration:</strong> {{ ceil($task['duration']/(60*60*24)) }} days</li>
        <li class="list-group-item text-left"><strong>Project:</strong> {{ $task['project'] }}</li>
    </ul>
    
    <div class="mt-4"><a href="/projects/{{ $task['projects_id'] }}">Back to project details</a></div>
    
    </div>
    </div>
</div>
@endsection    