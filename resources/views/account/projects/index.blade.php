@extends('layouts.app-vue')

@section('vue-content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.projects') }}
            </div>
            <div class="card-body">
                <form method="POST">
                    @method('DELETE')
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('account.project_id') }}</th>
                            <th scope="col">{{ __('account.title') }}</th>
                            <th scope="col">{{ __('account.status') }}</th>
                            <th scope="col">{{ __('account.subject') }}</th>
                            <th scope="col">{{ __('account.starting_date') }}</th>
                            <th scope="col">{{ __('account.edit') }}</th>
                            <th scope="col">{{ __('account.delete') }}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project->identifier }}</td>
                                <td>{{ $project->title }}</td>
                                <td>{{ $project->status->name }}</td>
                                <td>{{ $project->description }}</td>
                                <td>{{ $project->created_at }}</td>
                                <td>
                                    <button type="submit" class="btn btn-warning btn-sm"
                                            formaction="{{ route('account.inbox.edit', $project) }}">
                                        {{ __('account.edit') }}
                                    </button>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="{{ route('account.inbox.delete', $project) }}">
                                        {{ __('account.delete') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
