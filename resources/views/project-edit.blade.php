@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ $project ? __('Edit project') : __('Add project') }}</div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ $project ? route('projects.update', ['id' => $project['id']]) : route('projects.store') }}">
                            @csrf

                            @if ($project ?? '')
                                @method('PATCH')
                            @endif

                            <div class="form-group row">
                                <label for="title"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') ?? ($project ? $project['title'] : '') }}"
                                        autocomplete="title" autofocus>
                                    @error('title')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($project ? $project['description'] : '') }}</textarea>
                                    @error('description')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-2 col-form-label text-md-right">Status</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="status" name="status">
                                        @foreach ($statuses as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status') == $s ? 'selected' : ($project && $project['status'] == $s ? 'selected' : '') }}>
                                                {{ $s }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="duration"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Duration (days)') }}</label>

                                <div class="col-md-6">
                                    <input id="duration" type="text"
                                        class="form-control @error('duration') is-invalid @enderror" name="duration"
                                        value="{{ old('duration') ?? ($project ? ceil($project['duration'] / (60 * 60 * 24)) : '') }}"
                                        autocomplete="duration" autofocus>
                                    @error('duration')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="client"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Client') }}</label>

                                <div class="col-md-6">
                                    <input id="client" type="text"
                                        class="form-control @error('client') is-invalid @enderror" name="client"
                                        value="{{ old('client') ?? ($project ? $project['client'] : '') }}"
                                        autocomplete="client" autofocus>
                                    @error('client')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Company') }}</label>

                                <div class="col-md-6">
                                    <input id="company" type="text"
                                        class="form-control @error('company') is-invalid @enderror" name="company"
                                        value="{{ old('company') ?? ($project ? $project['company'] : '') }}"
                                        autocomplete="company" autofocus>
                                    @error('company')
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
            </div>
        </div>

    </div>
@endsection
