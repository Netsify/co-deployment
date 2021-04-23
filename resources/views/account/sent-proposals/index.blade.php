@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.sent_proposals') }}
            </div>

            <div class="card-body">
                <form method="POST">
                    @method('DELETE')
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('account.open') }}</th>
                                <th scope="col">{{ __('account.receiver') }}</th>
                                <th scope="col">{{ __('account.facilities') }}</th>
                                <th scope="col">{{ __('account.subject') }}</th>
                                <th scope="col">{{ __('account.status') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($proposals as $proposal)
                                <tr>
                                    <td>
{{--                                        <a href="{{ route() }}">Открыть</a>--}}
                                    </td>
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
                                    <td>
                                        {{ $proposal->status->name }}
                                    </td>
                                    <td>
                                        @proposalUnderConsideration($proposal)
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                formaction="{{ route('account.inbox.delete', $proposal) }}">
                                            {{ __('account.delete') }}
                                        </button>
                                        @endproposalUnderConsideration($proposal)
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
