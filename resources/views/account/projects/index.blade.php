@extends('layouts.app-vue')

@section('vue-content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.projects') }}
            </div>
            <div class="card-body">

                <div class="card-body">
                    <form method="GET">
                        <h3>{{ __('account.quick_search') }}</h3>
                        <div class="input-group rounded mb-3">
                            <input type="search" name="content" class="form-control rounded"
                                   placeholder="{{ __('account.title_or_description') }}"
                                   aria-label="Search" aria-describedby="search-addon"
                                   value="{{ request('content') }}" />
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('account.status') }}</label>
                            <select name="status" class="form-select">
                                <option value="" hidden>{{ __('account.all') }}</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="month" class="form-label">{{ __('account.from') }}</label>
                            <input type="date" class="form-control" name="start_date">
                        </div>

                        <div class="mb-3">
                            <label for="month" class="form-label">{{ __('account.to') }}</label>
                            <input type="date" class="form-control" name="end_date">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('account.search') }}</button>
                        </div>
                    </form>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('account.project_id') }}</th>
                        <th scope="col">{{ __('account.title') }}</th>
                        <th scope="col">{{ __('account.status') }}</th>
                        <th scope="col">{{ __('account.subject') }}</th>
                        <th scope="col">{{ __('account.starting_date') }}</th>
                        <th scope="col"></th>
{{--                            <th scope="col"></th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->identifier }}</td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->status->name }}</td>
                            <td>{{ $project->description }}</td>
                            <td>{{ $project->starting_date }}</td>
                            <td>
                                <a type="submit" href="{{ route('account.inbox.edit', $project) }}" class="btn btn-warning btn-sm">
                                    {{ __('account.edit') }}
                                </a>
                            </td>
{{--                                <td>--}}
{{--                                    <button type="submit" class="btn btn-danger btn-sm"--}}
{{--                                            formaction="{{ route('account.inbox.delete', $project) }}">--}}
{{--                                        {{ __('account.delete') }}--}}
{{--                                    </button>--}}
{{--                                </td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
