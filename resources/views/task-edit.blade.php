@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $task ? __('Edit task for project') : __('Add task to project') }} <strong>{{ $projectTitle }}</strong></div>

                <div class="card-body">
                    <form method="POST" action="{{ $task ? route('tasks.update', ['id' => $task['id']]) : route('tasks.store').'?projects_id='.request('projects_id') }}">
                        @csrf

                        @if ($task ?? '')
                        @method('PATCH')
                        @endif

                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? ($task ? $task['title'] : '') }}" autocomplete="title" autofocus>
                                @error('title')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($task ? $task['description'] : '') }}</textarea>
                                @error('description')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-2 col-form-label text-md-right">Status</label>

                            <div class="col-md-6">
                                <select class="form-control" id="status" name="status">
                                @foreach($statuses as $s)
                                <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : ($task && $task['status']==$s ? 'selected' : '') }}>{{ $s }}</option>
                                @endforeach
                                </select>
                                @error('status')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="duration" class="col-md-2 col-form-label text-md-right">{{ __('Duration (days)') }}</label>

                            <div class="col-md-6">
                                <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? ($task ? ceil($task['duration']/(60*60*24)) : '') }}" autocomplete="duration" autofocus>
                                @error('duration')
                                    <div class="text-danger pt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="mt-4"><a href="{{ $task ? route('projects.view', ['id' => $task['projects_id']]) : route('projects.view', ['id' => request('projects_id')]) }}">Back to project details</a></div>

        </div>
    </div>

</div>
@endsection