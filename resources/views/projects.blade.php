@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
        
        <div>
        
        <h2 class="mb-4">Projects</h2>
        
        @if(session()->has('message'))
            <div class="alert alert-success mt-2 mb-4">
                {{ session()->get('message') }}
            </div>
        @endif        

        <div class="mb-3 text-left">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Add new</a>
        </div>
        
        @if ($projects->all() ?? '')
        
        <table class="table table-bordered">
            <thead class="headcolor">
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col">Duration (days)</th>
                <th scope="col"></th>
            </thead>
            @foreach($projects as $p)
            <tr class="{{ $loop->index%2 ? 'bg-grey' : 'bg-white'  }}">
                <td>{{ $p['title'] }}</td>
                <td>{{ $p['status'] }}</td>
                <td class="text-center">{{ ceil($p['duration']/(60*60*24)) }}</td>
                <td class="text-center">
                    <a href="{{ route('projects.view', ['id' => $p['id']]) }}">View</a>
                    <div class="v-divider"></div>
                    <a href="{{ route('projects.edit', ['id' => $p['id']]) }}">Edit</a> 
                    <div class="v-divider"></div>
                    <a href="javascript:if (confirm('Delete project. Are you sure?')) location.href='{{ route('projects.delete', ['id' => $p['id']]) }}'">Delete</a>
                </td>
            </tr>
            @endforeach
        </table>
        
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        </div>
        
        
        @endif
        
        </div>
        
        </div>
    </div>
</div>
@endsection