@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.edit') }}
            </div>

            <div class="card-body">

                @if (session()->has('message'))
                    <div class="alert alert-info d-flex align-items-center justify-content-center mb-2">
                        {{ session('message') }}
                    </div>
                @endif

                <form action="{{ route('account.projects.update', $project) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="col-form-label">{{ __('account.title') }}</label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') ?? $project->title }}">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="project_id" class="col-form-label">{{ __('account.project_id') }}</label>
                        <div name="project_id">
                            {{ $project->identifier }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">{{ __('account.participants') }}</label>
                        <div name="participants">
                            @foreach($project->users as $user)
                                <img src="{{ $user->photo }}" height="40"> {{ $user->full_name }}
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_id" class="col-form-label">{{ __('account.status') }}</label>
                        <select name="status_id" class="form-select @error('status_id') is-invalid @enderror">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ $project->status->id === $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('status_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="col-form-label">{{ __('account.summary') }}</label>
                        <input type="text" name="description"
                               class="form-control @error('description') is-invalid @enderror"
                               value="{{ old('description') ?? $project->description }}">

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('account.facilities') }}</th>
                                    <th scope="col">{{ __('facility.location') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->facilities as $facility)
                                    <tr>
                                        <td>{{ $facility->title }}</td>
                                        <td>{{ $facility->location }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mb-5">
                        <button type="submit" class="btn btn-primary">{{ __('dictionary.Save') }}</button>
                    </div>
                </form>

                @include('account.projects.comments')

            </div>
        </div>
    </div>
@endsection
