@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8 text-center">
    
    @if(session()->has('message'))
        <div class="alert alert-success mt-2 mb-4">
            {{ session()->get('message') }}
        </div>
    @endif        
    
    <ul class="list-group">
        <li class="list-group-item active">Project Details</li>
        <li class="list-group-item text-left"><strong>Title:</strong> {{ $project['title'] }}</li>
        <li class="list-group-item text-left"><strong>Description:</strong> {{ $project['description'] }}</li>
        <li class="list-group-item text-left"><strong>Status:</strong> {{ $project['status'] }}</li>
        <li class="list-group-item text-left"><strong>Duration:</strong> {{ ceil($project['duration']/(60*60*24)) }} days</li>
        <li class="list-group-item text-left"><strong>Client:</strong> {{ $project['client'] }}</li>
        <li class="list-group-item text-left"><strong>Company:</strong> {{ $project['company'] }}</li>
    </ul>
    
    <h3 class="mt-5">Tasks</h4>
    
    <div class="mb-3 text-left">
        <a href="{{ url('/tasks/create?projects_id='.$project['id']) }}" class="btn btn-primary">Add new</a>
    </div>
    
    <ul class="list-group list-group-flush">
        @foreach($tasks as $t)
        <li class="list-group-item text-left">
            {{ $t['title'] }}
            
            <span class="float-right">
                <a href="{{ url('/tasks/'.$t['id']) }}">View</a>
                <div class="v-divider"></div>
                <a href="{{ url('/tasks/'.$t['id'].'/edit') }}">Edit</a> 
                <div class="v-divider"></div>
                <a href="javascript:if (confirm('Delete task. Are you sure?')) location.href='{{ url('/tasks/'.$t['id'].'/delete?project_id='.$project['id']) }}'">Delete</a>
            </span>
    
        </li>
        @endforeach
    </ul>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
        {{ $tasks->links() }}
        </div>
    </div>
    
    </div>
    </div>
</div>
@endsection