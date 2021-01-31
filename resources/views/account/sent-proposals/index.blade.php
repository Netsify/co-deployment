@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.send_proposals') }}
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('account.open') }}</th>
                        <th scope="col">{{ __('account.receiver') }}</th>
                        <th scope="col">{{ __('facility.facilities') }}</th>
                        <th scope="col">{{ __('account.subject') }}</th>
                        <th scope="col">{{ __('account.status') }}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>
                    <form method="POST">
                        @method('DELETE')
                        @csrf
                        @foreach($proposals as $proposal)
                            <tr>
                                <td></td>
                                <td>
                                    {{ $proposal->receiver->full_name }}
                                </td>
                                <td>
                                    @foreach($proposal->facilities as $facility)
                                        <div class="mb-1">
                                            {{ $facility->title }}
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $proposal->description }}</td>
                                <td>{{ $proposal->status }}</td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="">{{ __('knowledgebase.delete') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
