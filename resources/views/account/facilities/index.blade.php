@extends('layouts.app-vue')

@section('vue-content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('facility.facilities') }}

                @can('create', \App\Models\Facilities\Facility::class)
                    <a class="btn btn-sm btn-success" href="{{ route('account.facilities.create') }}" style="float: right">
                        {{ __('facility.create_facility') }}
                    </a>
                @endcan
            </div>

            <div class="card-body">
                <form method="POST">
                    @method('DELETE')
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('facility.facilities') }}</th>
                                <th scope="col">{{ __('facility.visibility') }}</th>
                                <th scope="col">{{ __('facility.type') }}</th>
                                <th scope="col">{{ __('account.subject') }}</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($facilities as $facility)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $facility->title }}</td>
                                <td>{{ $facility->visibility->name }}</td>
                                <td>{{ $facility->type->name }}</td>
                                <td>{{ $facility->preview }}</td>
                                <td>
                                    <a type="submit" href="{{ route('account.facilities.edit', $facility) }}"
                                       class="btn btn-warning btn-sm">
                                        {{ __('account.edit') }}
                                    </a>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="{{ route('account.facilities.destroy', $facility) }}">
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
